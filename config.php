<?php
session_start();
$title = "Pr(emed)onostiek";

$datafile = "data.json";
require_once("functions.php");

if(isset($_SESSION["error_message"]))
{
    $error_message = $_SESSION["error_message"];
    unset($_SESSION["error_message"]);
}
else
{
    unset($error_message);
}
