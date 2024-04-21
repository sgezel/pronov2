<?php
session_start();
include_once("config.php");
include_once("UserCrud.php");

CheckAdminAccess();

$userCrud = new UserCrud();


if(isset($_POST))
{
    $uid = $_POST["user"];
    $mid = $_POST["match"];

    $userCrud->actionSetMatchScoreQP($uid, $mid, getQuickPickScore());

    $_SESSION["success_message"] = "QuickPick update for user" . $uid;
}


header("location: admin.php?tab=QuickPickFix®");

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
