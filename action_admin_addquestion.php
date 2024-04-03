<?php

require_once("config.php");
include_once("QuestionCrud.php");

CheckAdminAccess();

$crud = new QuestionCrud();

if(isset($_POST))
    $crud->actionAdd();