<?php
session_start();
require_once("UserCrud.php");
require_once("MatchCrud.php");

$userCrud = new UserCrud();
$matchCrud = new MatchCrud();

echo" <pre>";
lockMatches($matchCrud);
calculateScores($userCrud, $matchCrud);
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

    if ( $timeDifference <= 3600) {
        return "true";
    } 

    return "false";
}

function lockMatches()
{
    $matchCrud = new MatchCrud();

    $matchData  = $matchCrud->actionRead();

    foreach($matchData as $matchId => $match)
    {
        if(isset($match["locked"]))
        {
           // print($match["date"] . " " . $match["time"] . ": " .  isMatchLocked($match["date"], $match["time"]) . "\n");
            $matchData[$matchId]["locked"] = isMatchLocked($match["date"], $match["time"]) ;
        }
        else
        {
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

function calculateScores($userCrud, $matchCrud)
{
    $data  = $userCrud->actionRead();
    $matchData  = $matchCrud->actionRead();

    foreach($data as $userId => $userdata)
    {
        foreach($matchData as $matchId => $match)
        {
            if(isset($match["home_score"]) && isset($match["away_score"]))
            {
               if(!array_key_exists($matchId,  $userdata["matches"]))
                {
                   continue;
                }

                $user_match = $userdata["matches"][$matchId];

                $user_home = $user_match["home"];
                $user_away = $user_match["away"];

                $match_home = $match["home_score"];
                $match_away = $match["away_score"];

                $match_score = 0;

                $matches_correct = 0;


                if((isset($user_home) && $user_home != "" || isset($user_away) && $user_away != "") && (isset($match_home) && $match_home != "" || isset($match_away) && $match_away != ""))
                {
                     
                    if($user_home == $match_home)
                        $match_score++;

                    if($user_away == $match_away)
                        $match_score++;

                    if(abs($user_home - $user_away) == abs($match_home - $match_away))
                        $match_score++;

                    if(($match_home > $match_away && $user_home > $user_away) || ($match_home == $match_away && $user_home == $user_away)  || ($match_home < $match_away && $user_home < $user_away))
                        $match_score++;

                    if($match_score == 4)
                        $matches_correct++;

                    $userdata["matches"][$matchId]["points"]= $match_score;
                    
                }
            }
          
    }

    $userCrud->actionUpdateMatchScore($userId, $userdata);
}

}

?>