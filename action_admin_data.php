<?php
include_once("UserCrud.php");
include_once("config.php");

CheckAccess();

$crud = new UserCrud();

if (isset($_POST)) {

    if(isJson($_POST["datafile"]))
    {
        file_put_contents($crud->filePath, $_POST["datafile"]);
        $_SESSION["success_message"] = "Data file opgeslagen.";
    }
    else
    {
        $_SESSION["error_message"] = "Geen geldige json.";
    }

}


function isJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
 }

header("location: admin.php?tab=data");
