<?php
session_start();
require_once("UserCrud.php");
require_once("MatchCrud.php");
echo" <pre>";
calculateScores();
echo "</pre>";
die("done");
function lockMatches()
{

}

function quickPick()
{

}

function calculateScoreboard()
{

}

function calculateScores()
{
    $userCrud = new UserCrud();
    $matchCrud = new MatchCrud();

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