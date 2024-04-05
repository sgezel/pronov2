<?php
session_start();
include_once("config.php");
include_once("QuestionCrud.php");

CheckAdminAccess();

$questionCrud = new QuestionCrud();

if(isset($_POST))
    $questionCrud->actionEdit();