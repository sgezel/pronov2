<?php
session_start();
require_once("UserCrud.php");
require_once("MatchCrud.php");

echo "<pre>";
getLiveScore();
echo "</pre>";

die("done");

function isMatchLocked($matchDate, $matchTime)
{
    $now = new DateTime("now");
    $currentTime = strtotime($now->format('Y-m-d H:i:s'));

    // Combine date and time into a single timestamp
    $matchTimestamp = strtotime("$matchDate $matchTime");

    // Calculate the difference between current time and match time
    $timeDifference = $matchTimestamp - $currentTime;

    if ($timeDifference <= 3600) {
        return "true";
    }

    return "false";
}

function lockMatches()
{
    $matchCrud = new MatchCrud();

    $matchData  = $matchCrud->actionRead();

    foreach ($matchData as $matchId => $match) {
        if (isset($match["locked"])) {
            // print($match["date"] . " " . $match["time"] . ": " .  isMatchLocked($match["date"], $match["time"]) . "\n");
            $matchData[$matchId]["locked"] = isMatchLocked($match["date"], $match["time"]);
        } else {
            $matchData[$matchId]["locked"] = "false";
        }
    }

    //$matchCrud->actionUpdateMatchData($matchData);
}

function quickPick()
{
}

function calculateScoreboard()
{
}

function getLiveScore()
{
    $matchCrud = new MatchCrud();

    $matchData  = $matchCrud->actionRead();

    $today = date("Y-m-d");
    $currentTime = date("H:i");

    foreach ($matchData as $matchId => $match) {

           if (($match["date"] === $today) && (!$match["finished"])  && strtotime($match["time"]) < strtotime($currentTime)) {

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
                    die("fout bij ophalen data");
                } else {
                    $data = json_decode($result, true);
                    if (isset($data)) {
                        $scores = explode("-", $data["header"]["status"]["scoreStr"]);
                        $finished = $data["header"]["status"]["finished"];

                        $match["home_score"] = $scores[0];
                        $match["away_score"] = $scores[1];

                        if ($finished === true)
                            $match["finished"] = true;

                        echo  $match["home_score"] . " - " . $match["away_score"] . "---------" . $match["finished"];
                    }
                }
            } catch (Exception $e) {
                echo "Error fetching data: " . $e->getMessage();
            }
        }
    }
}


function calculateScores()
{
    $userCrud = new UserCrud();
    $matchCrud = new MatchCrud();

    $data  = $userCrud->actionRead();
    $matchData  = $matchCrud->actionRead();

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
                }
            }
        }

        $userCrud->actionUpdateMatchScore($userId, $userdata);
    }
}
