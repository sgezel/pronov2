<?php
session_start();
include_once("UserCrud.php");

CheckAccess();

$crud = new UserCrud();

if(isset($_POST))
    $crud->actionSaveMatches();