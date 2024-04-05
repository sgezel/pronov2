<?php
include_once("UserCrud.php");
include_once("config.php");

CheckAccess();

$crud = new UserCrud();

if (isset($_POST)) {
    file_put_contents($crud->filePath, $_POST["datafile"]);
}

header("location: admin.php?tab=data");
