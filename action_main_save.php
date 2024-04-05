<?php
include_once("UserCrud.php");
include_once("config.php");

CheckAccess();

$crud = new UserCrud();

if(isset($_POST))
    $crud->actionSaveData();