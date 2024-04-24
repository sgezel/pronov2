<?php

/*
c:\xampp\php\php.exe C:\xampp\htdocs\pronov2\cron.php lockMatches getLiveScore
*/

error_reporting(E_ALL ^ E_WARNING);
date_default_timezone_set('Europe/Brussels');

$cron_file = getcwd() . "/data.json";


$dataSet = json_decode(file_get_contents($cron_file), true);

$dataChanged = false;

$functions_to_execute = [];

$web = false;

if (isset($argv)) {
    for ($i = 1; $i < count($argv); $i++) {
        if (function_exists("cron_" . $argv[$i]))
            $functions_to_execute[] = "cron_" . $argv[$i];
    }
} else if (isset($_GET["func"])) {
    $web = true;
    foreach (explode(",", $_GET["func"]) as $func) {
        if (function_exists("cron_" . $func))
            $functions_to_execute[] = "cron_" . $func;
    }
}

if ($web)
    echo "<pre>";


foreach ($functions_to_execute as $function) {
    echo (new DateTime("now"))->format('Y-m-d H:i:s') . ": calling $function \n";

    $dataChanged = $function() || $dataChanged;
}

if ($dataChanged) {
    print("data aangepast, opslaan\n");
    file_put_contents($cron_file, json_encode($dataSet, JSON_PRETTY_PRINT));
}

if ($web)
    echo "</pre>";


function isActive($variable)
{
    return ($variable === true || $variable === "true" || $variable === "on");
}

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

    $datachanged = true;

    $matchData = $dataSet["matches"];

    foreach ($matchData as $matchId => $match) {
        if (isMatchLocked($match["date"], $match["time"])) {
            $matchData[$matchId]["locked"] = true;

            echo "quickpicking $matchId \n";
            cron_quickPick($matchId);
        } else {
            $matchData[$matchId]["locked"] = false;
        }
    }

    $dataSet["matches"] = $matchData;

    return $datachanged;
}

function cron_quickPick($matchId)
{
    global $dataSet;

    $userdata = $dataSet["users"];

    if (!isset($dataSet["matches"][$matchId]["finished"]) || ($dataSet["matches"][$matchId]["finished"] != true && $dataSet["matches"][$matchId]["finished"] != "true")) {

        foreach ($userdata as $userid => $data) {

            print $data["name"] . "\n";

            if (isset($data["quickpicker"]) && isActive($data["quickpicker"])) {

                print "quickpicker\n";

                if (isset($userdata[$userid]["matches"][$matchId])) {
                    if (
                        (!isset($userdata[$userid]["matches"][$matchId]["home"]) || !isset($userdata[$userid]["matches"][$matchId]["away"]))
                        ||
                        ($userdata[$userid]["matches"][$matchId]["home"] === "" || $userdata[$userid]["matches"][$matchId]["away"] === "")
                    ) {
                        print "setting score\n";
                        $userdata[$userid]["matches"][$matchId] = getQuickPickScore();
                    }
                } else {
                    $userdata[$userid]["matches"][$matchId] = getQuickPickScore();
                }
            } else {
                $userdata[$userid]["matches"][$matchId]["quickpicked"] = false;
            }
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
    foreach ($weighted_array as $score => $weight) {

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
    $questionPoints = $dataSet["settings"][0]["questionvalue"];

    foreach ($data as $id => $userdata) {
        $totalscore = 0;
        $correct = 0;
        $questionsCorrect = 0;

        if (!isset($userdata["badges"]["Wanbetaler"])) {

            foreach ($userdata["matches"] as $match) {
                if (isset($match["points"])) {
                    $totalscore = $totalscore + $match["points"];

                    if ($match["points"] == 4)
                        $correct++;
                }
            }

            foreach ($userdata["questions"] as $question) {
                if ($question["correct"] == true) {
                    $totalscore = $totalscore + $questionPoints;
                    $questionsCorrect++;
                }
            }
        }

        $scoreboard[] = ["uid" => $id, "name" => $userdata["name"], "score" => $totalscore, "correct" => $correct, "questions" => $questionsCorrect, "visible" => (($userdata["visible"] === true) || ($userdata["visible"] == "on"))];

        usort($scoreboard, function ($a, $b) {
            if ($a['score'] == $b['score']) {
                return $b['correct'] - $a['correct'];
            }
            return $b['score'] - $a['score'];
        });

        $datachanged = true;
    }



    $dataSet["scoreboard"] = $scoreboard;
    return $datachanged;
}

function cron_getLiveScore()
{
    global $dataSet;

    $datachanged = false;

    $matchData = $dataSet["matches"];

    $today = date("Y-m-d");
    $currentTime = date("H:i");

    foreach ($matchData as $matchId => $match) {
        if (
            ($match["date"] === $today)
            && (!$match["finished"])
            && strtotime($match["time"]) < strtotime($currentTime)

        ) {
            //API code
            $apiUrl = 'https://free-football-live-score.p.rapidapi.com/live/all-details';
            $headers = [
                'Content-type' => 'application/json',
                'X-RapidAPI-Key' => $dataSet["settings"][0]["apikey"],
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

    $data = $dataSet["users"];
    $matchData = $dataSet["matches"];

    foreach ($data as $userId => $userdata) {
        foreach ($matchData as $matchId => $match) {
            if (isset($match["home_score"]) && isset($match["away_score"])) {
                if (!array_key_exists($matchId, $userdata["matches"])) {
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

                    if (($match_home > $match_away && $user_home > $user_away) || ($match_home == $match_away && $user_home == $user_away) || ($match_home < $match_away && $user_home < $user_away))
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

function cron_calculateBadges()
{
    global $dataSet;
    global $web;

    $datachanged = true;

    cron_calculateScoreboard(); //zeker zijn dat het scorebord geupdate is

    $udata = $dataSet["users"];
    $mdata = $dataSet["matches"];
    $sdata = $dataSet["scoreboard"];
    $qdata = $dataSet["questions"];

    $matchesplayed = 0;
    $allmatchesfinished = true;
    $questionssolved = 0;
    $allquestionssolved = true;

    foreach ($mdata as $mid => $match) {
        if ($match["finished"]) {
            $matchesplayed++;

            if ($matchesplayed > 2)
                break; //vanaf 3 gaan we winnaar en loser badges berekenen
        } else {
            $allmatchesfinished = false;
        }
    }

    foreach ($qdata as $qid => $question) {
        if ($question["solved" === "on"]) {
            $questionssolved++;
        } else {
            $allquestionssolved = false;
        }
    }

    /*Wanbetalers*/
    foreach ($udata as $userId => $userdata) {

        if ((!($userdata["paid"] === true) && !($userdata["paid"] == "on"))) {
            $udata[$userId]["badges"]["Wanbetaler"]["icon"] = "wanbetaler";
            $udata[$userId]["badges"]["Wanbetaler"]["title"] = "Wanbetaler";
        } else {
            unset($udata[$userId]["badges"]["Wanbetaler"]);
        }
    }


    if (!$web) //deze mogen maar een keer per dag worden berekend.
    {
        //Uitslag correct
        foreach ($sdata as $score) {
            $uid = $score["uid"];

            switch ($score["correct"]) {
                case 1: // Deze lege lijnen zijn voor de test data, daar hebben we wat berekeningen "gemist"
                case 2:
                case 3:
                case 4:
                    $udata[$uid]["badges"]["Correcte pronostiek"]["icon"] = "nauwkeurigevoorspeller";
                    $udata[$uid]["badges"]["Correcte pronostiek"]["title"] = "Nauwkeurige Voorspeller";
                    break;
                case 5:
                    $udata[$uid]["badges"]["Correcte pronostiek"]["icon"] = "viersterrenkoning";
                    $udata[$uid]["badges"]["Correcte pronostiek"]["title"] = "Viersterrenkoning";
                    break;
                case 10:
                    $udata[$uid]["badges"]["Correcte pronostiek"]["icon"] = "kampioenziener";
                    $udata[$uid]["badges"]["Correcte pronostiek"]["title"] = "Kampioen Ziener";
                    break;
            }

            if ($score["score"] >= 30) {
                $udata[$uid]["badges"]["ekexpert"]["icon"] = "ekexpert";
                $udata[$uid]["badges"]["ekexpert"]["title"] = "EK Expert";
            }
        }

        //Pechvogel && Quickpicked
        foreach ($udata as $uid => $userdata) {
            $zeroscore = 0;
            $quickpicked = 0;

            foreach ($userdata["matches"] as $mid => $match) {
                if ($mdata[$mid]["finished"] == true) {
                    if ($match["points"] == 0)
                        $zeroscore++;

                    if ($match["quickpicked"] == true)
                        $quickpicked++;
                }
            }

            if ($zeroscore > 0 && $zeroscore < 5) {
                $udata[$uid]["badges"]["Pechvogel"]["icon"] = "pechvogel";
                $udata[$uid]["badges"]["Pechvogel"]["title"] = "Pechvogel";
            } else if ($zeroscore >= 5 && $zeroscore < 10) {
                $udata[$uid]["badges"]["Pechvogel"]["icon"] = "nulmeester";
                $udata[$uid]["badges"]["Pechvogel"]["title"] = "Nulmeester";
            } else if ($zeroscore >= 10) {
                $udata[$uid]["badges"]["Pechvogel"]["icon"] = "legendevandelegehand";
                $udata[$uid]["badges"]["Pechvogel"]["title"] = "Legende van de Lege Hand";
            }

            if ($quickpicked > 0 && $quickpicked < 5) {
                $udata[$uid]["badges"]["QuickPicker"]["icon"] = "quickpickenthousiast";
                $udata[$uid]["badges"]["QuickPicker"]["title"] = "QuickPick Enthousiast";
            } else if ($quickpicked >= 5 && $quickpicked < 10) {
                $udata[$uid]["badges"]["QuickPicker"]["icon"] = "quickpickgebruiker";
                $udata[$uid]["badges"]["QuickPicker"]["title"] = "QuickPick Gebruiker";
            } else if ($quickpicked >= 10) {
                $udata[$uid]["badges"]["QuickPicker"]["icon"] = "quickpickfanaat";
                $udata[$uid]["badges"]["QuickPicker"]["title"] = "QuickPick Fanaat";
            }
        }

        //puntenkoning

        foreach ($udata as $uid => $userdata) {

            if (count($userdata["matches"]) >= 3) {

                $keys = array_keys($userdata["matches"]);

                for ($i = 2; $i < count($keys); $i++) {
                    $points = [];
                    $points[] = $userdata["matches"][$keys[$i]]["points"];
                    $points[] = $userdata["matches"][$keys[$i - 1]]["points"];
                    $points[] = $userdata["matches"][$keys[$i - 2]]["points"];

                    if (array_sum($points) > 6)
                    {
                        $udata[$uid]["badges"]["Puntenkoning"]["icon"] = "puntenkoning";
                        $udata[$uid]["badges"]["Puntenkoning"]["title"] = "Puntenkoning";
                    }
                }
            }
        }


        if ($matchesplayed > 2) {
            //Winnaar
            $winnaarid = $sdata[0]["uid"];
            $udata[$winnaarid]["badges"]["Winnaarsbadge"]["icon"] = "scoreprofeet";
            $udata[$winnaarid]["badges"]["Winnaarsbadge"]["title"] = "Scoreprofeet";

            //Loser
            $loserid = end($sdata)["uid"];
            $udata[$loserid]["badges"]["Losersbadge"]["icon"] = "onderstebovenkampioen";
            $udata[$loserid]["badges"]["Losersbadge"]["title"] = "Onderstebovenkampioen";
        }
    }
    
    //deze doen we enkel op het einde van het EK wanneer alle wedstrijden gespeeld zijn en alle vragen verbeterd:
    if ($allquestionssolved) {
        foreach ($udata as $uid => $userdata) { // Use reference to modify the original array
    
            $keys = array_keys($userdata["questions"]);
            $correctquestions = 0;
    
            foreach ($keys as $key) {
                if (isset($userdata["questions"][$key]["correct"]) && $userdata["questions"][$key]["correct"] === true) {
                    $correctquestions++;
                }
            }
            if ($correctquestions >= (count($qdata["questions"]) / 2)) {
                $udata[$uid]["badges"]["vragenvirtuoos"]["icon"] = "vragenvirtuoos";
                $udata[$uid]["badges"]["vragenvirtuoos"]["title"] = "Vragen Virtuoos";
            }
        }
    }

    //QuickPick-ontwijker
    if ($allmatchesfinished) {
        foreach ($udata as $uid => $userdata) {
            if (!array_key_exists("QuickPicker", $userdata["badges"])) {
                $udata[$uid]["badges"]["QuickPickOntwijker"]["icon"] = "quickpickweigeraar";
                $udata[$uid]["badges"]["QuickPickOntwijker"]["title"] = "QuickPick Weigeraar";
            }
        }
    }


    $dataSet["users"] = $udata;

    return $datachanged;
}
