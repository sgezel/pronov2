<?php
session_start();

echo(!isset($_SESSION["visiblegroup"]) ? "yes visgroup" : "no visgroup");
echo($_SESSION["group"]);


if(!isset($_SESSION["visiblegroup"]) && isset($_SESSION["group"]))
    $_SESSION["visiblegroup"] = $_SESSION["group"];
else
    unset($_SESSION["visiblegroup"]);

if(isset($_GET["p"]))
{
    header("location: " . $_GET["p"] . ".php");
}else
{
    header("location: scoreboard.php");
}
