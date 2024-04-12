<?php

/*
c:\xampp\php\php.exe C:\xampp\htdocs\pronov2\cron.php lockMatches getLiveScore
*/

error_reporting(E_ALL ^ E_WARNING); 
date_default_timezone_set('Europe/Brussels');
require_once("config.php");

$dataSet = json_decode(file_get_contents($cron_file), true);

$dataChanged = false;

$functions_to_execute = [];

$web = false;

if(isset($argv))
{
    for($i = 1; $i< count($argv); $i++)
    {
        if(function_exists("cron_" . $argv[$i]))
            $functions_to_execute[] = "cron_" . $argv[$i];
    }
}
else if(isset($_GET["func"]))
{
    $web = true;
    foreach(explode(",",$_GET["func"]) as $func)
    {
        if(function_exists("cron_" . $func))
            $functions_to_execute[] = "cron_" . $func;
    }
}

if($web)
    echo "<pre>";


foreach($functions_to_execute as $function)
{
    echo (new DateTime("now"))->format('Y-m-d H:i:s') .  ": calling $function \n";
    $dataChanged  = $function() || $dataChanged;
}

/*
$dataChanged  = lockMatches() || $dataChanged;
$dataChanged  = getLiveScore() || $dataChanged;
$dataChanged = calculateScores() || $dataChanged;
*/

if ($dataChanged) {
    print("data aangepast, opslaan\n");
    file_put_contents($cron_file, json_encode($dataSet, JSON_PRETTY_PRINT));
}

if($web)
    echo "</pre>";

function isMatchLocked($matchDate, $matchTime)
{
    $now = new DateTime("now");
    $currentTime = strtotime($now->format('Y-m-d H:i:s'));

    // Combine date and time into a single timestamp
    $matchTimestamp = strtotime("$matchDate $matchTime");

    // Calculate the difference between current time and match time
    $timeDifference = $matchTimestamp - $currentTime;

    if ($timeDifference <= 3600) {
        return true;
    }

    return false;
}

function cron_lockMatches()
{
    global $dataSet;

    $datachanged = false;

    $matchData  = $dataSet["matches"];

    foreach ($matchData as $matchId => $match) {
        if (isset($match["locked"])) {
            $matchData[$matchId]["locked"] = isMatchLocked($match["date"], $match["time"]);

            cron_quickPick($matchId);

            $datachanged = true;
        } else {
            $matchData[$matchId]["locked"] = false;
            $datachanged = true;

        }
    }

    $dataSet["matches"] = $matchData;

    return $datachanged;
}

function cron_quickPick($matchId)
{
     global $dataSet;

     $userdata = $dataSet["users"];

     foreach($userdata as $userid => $data)
     {
        if(isset($data["quickpicker"]) && ($data["quickpicker"] === true || $data["quickpicker"] === "true"))
        {
            if(isset($userdata[$userid]["matches"][$matchId]))
            {
                if(!isset($userdata[$userid]["matches"][$matchId]["home"]) || !isset($userdata[$userid]["matches"][$matchId]["away"]))
                {
                    $userdata[$userid]["matches"][$matchId] = getQuickPickScore();  
                }
            }
            else
            {
                $userdata[$userid]["matches"][$matchId] = getQuickPickScore();
            }
        }
        else
        {
            $userdata[$userid]["matches"][$matchId]["quickpicked"] = false;
        }
     }

     $dataSet["users"] = $userdata;
     return true;
}

function getQuickPickScore()
{
    $homeWeights = [
        0 => 3083,
        1 => 3609,
        2 => 1880,
        3 => 1053,
        4 => 301,
        5 => 75
    ];

    $awayWeights = [
        0 => 2857,
        1 => 3759,
        2 => 2180,
        3 => 677,
        4 => 376,
        5 => 150
    ];

    return ["home" => getWeightedResult($homeWeights), "away" => getWeightedResult($awayWeights), "quickpicked" => true];

}

function getWeightedResult($weighted_array)
{
    $total_weight = array_sum(array_values($weighted_array));
    $selection = random_int(1, $total_weight);

    $count = 0;
    foreach($weighted_array as $score => $weight) {
        
        $count += $weight;
        if ($count >= $selection) {
          return $score;
        }
      }
}

function cron_calculateScoreboard()
{
    global $dataSet;

    $scoreboard = [];
    $datachanged = false;

    $data = $dataSet["users"];

    foreach($data as $id => $userdata)
    {
        $totalscore = 0;
        $correct = 0;

        foreach($userdata["matches"] as $match)
        {
            if(isset($match["points"]))
            {
                $totalscore = $totalscore + $match["points"];
                
                if($match["points"] == 4)
                    $correct++;
            }
        }

        $scoreboard[] = ["name" => $userdata["name"], "score" => $totalscore, "correct" => $correct];
        $datachanged = true;
    }

    $key_values = array_column($scoreboard, 'score'); 
    array_multisort($key_values, SORT_DESC, $scoreboard);

    $dataSet["scoreboard"] = $scoreboard;
    return $datachanged;


}

function cron_getLiveScore()
{
    global $dataSet;

    $datachanged = false;

    $matchData  = $dataSet["matches"];

    $today = date("Y-m-d");
    $currentTime = date("H:i");

    foreach ($matchData as $matchId => $match) {
        if (($match["date"] === $today)
            && (!$match["finished"])
            && strtotime($match["time"]) < strtotime($currentTime)
            
        ) {
            //API code
            $apiUrl = 'https://free-football-live-score.p.rapidapi.com/live/all-details';
            $headers = [
                'Content-type' => 'application/json',
                'X-RapidAPI-Key' => '625dee17c3mshbe3761434ffa1fdp19767ejsn126181a8d6b0',
                'X-RapidAPI-Host' => 'free-football-live-score.p.rapidapi.com',
            ];
            $payload = ['match_id' => $matchId];

            $options = [
                'http' => [
                    'header' => implode("\r\n", array_map(function ($a, $b) {
                        return "$a: $b";
                    }, array_keys($headers), array_values($headers))),
                    'method' => 'POST',
                    'content' => json_encode($payload),
                ],
            ];

            try {
                $context = stream_context_create($options);
                $result = file_get_contents($apiUrl, false, $context);
                if ($result === false) {
                    print("fout bij ophalen data\n");
                } else {
                    $data = json_decode($result, true);

                    if (isset($data)) {
                        $scores = explode("-", $data["header"]["status"]["scoreStr"]);
                        $finished = $data["header"]["status"]["finished"];

                        $matchData[$matchId]["home_score"] = trim($scores[0]);
                        $matchData[$matchId]["away_score"] = trim($scores[1]);
                        
                        if ($finished == true)
                            $matchData[$matchId]["finished"] = true;

                        $datachanged = true;
                }
                }
            } catch (Exception $e) {
                echo "Error fetching data: " . $e->getMessage();
            }
        }
    }
    $dataSet["matches"] = $matchData;

    return $datachanged;
}


function cron_calculateScores()
{
    global $dataSet;

    $datachanged = false;

    $data  = $dataSet["users"];
    $matchData  = $dataSet["matches"];

    foreach ($data as $userId => $userdata) {
        foreach ($matchData as $matchId => $match) {
            if (isset($match["home_score"]) && isset($match["away_score"])) {
                if (!array_key_exists($matchId,  $userdata["matches"])) {
                    continue;
                }

                $user_match = $userdata["matches"][$matchId];

                $user_home = $user_match["home"];
                $user_away = $user_match["away"];

                $match_home = $match["home_score"];
                $match_away = $match["away_score"];

                $match_score = 0;

                $matches_correct = 0;


                if ((isset($user_home) && $user_home != "" || isset($user_away) && $user_away != "") && (isset($match_home) && $match_home != "" || isset($match_away) && $match_away != "")) {

                    if ($user_home == $match_home)
                        $match_score++;

                    if ($user_away == $match_away)
                        $match_score++;

                    if (abs($user_home - $user_away) == abs($match_home - $match_away))
                        $match_score++;

                    if (($match_home > $match_away && $user_home > $user_away) || ($match_home == $match_away && $user_home == $user_away)  || ($match_home < $match_away && $user_home < $user_away))
                        $match_score++;

                    if ($match_score == 4)
                        $matches_correct++;

                    $userdata["matches"][$matchId]["points"] = $match_score;
                    $datachanged = true;
                }
            }
        }

        $data[$userId] = $userdata;
    }

    $dataSet["users"] = $data;

    return $datachanged;
}
