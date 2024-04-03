<?php
session_start();
include_once("UserCrud.php");
include_once("config.php");

CheckAccess();

$crud = new UserCrud();

if(isset($_POST))
    $crud->actionSaveQuestions();

if(isset($_POST))
    $crud->actionSaveMatches();