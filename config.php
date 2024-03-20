<?php
session_start();
$title = "Pr(emed)onostiek";

$_SESSION["datafile"] = "data.json";
$_SESSION["install_path"] =  "/pronov2";

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

if(isset($_SESSION["success_message"]))
{
    $success_message = $_SESSION["success_message"];
    unset($_SESSION["success_message"]);
}
else
{
    unset($success_message);
}
