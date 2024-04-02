<?php

require_once("config.php");
include_once("UserCrud.php");

CheckAccess();

$crud = new UserCrud();

if(isset($_POST))
    $crud->actionSaveQuickPick();