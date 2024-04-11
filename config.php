<?php
session_start();
$title = "Pr(emed)onostiek";

$_SESSION["datafile"] = "data.json";
$_SESSION["install_path"] =  "/pronov2";

$cron_file = "data.json";


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

// Usage with $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //$_POST = array_map('sanitize_input', $_POST);
}

// Usage with $_GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //$_GET = array_map('sanitize_input', $_GET);
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function sanitize($data)
{
    if(is_array($data))
    {
        return array_map('sanitize_input', $data);
    }
    else
    {
        return sanitize_input($data);
    }
}


function CheckAccess()
{
    if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
        $_SESSION["error_message"] = "U heeft geen toegang tot deze pagina. gelieve eerst in te loggen.";
        header("location: login.php");
    }
}

function CheckAdminAccess()
{
    if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] &&  !isset($_SESSION["admin"]) && !$_SESSION["admin"]) {
        $_SESSION["error_message"] = "U heeft geen toegang tot deze pagina. gelieve eerst in te loggen.";
        header("location: login.php");
    }
}
