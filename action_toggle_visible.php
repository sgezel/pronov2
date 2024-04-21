<?php
session_start();

$_SESSION["visible"] = !$_SESSION["visible"];

if(isset($_GET["p"]))
{
    header("location: " . $_GET["p"] . ".php");
}else
{
    header("location: scoreboard.php");
}
