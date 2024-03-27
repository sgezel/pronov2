<?php

require_once("config.php");
include_once("MatchCrud.php");

$crud = new MatchCrud();

if(isset($_POST))
    $crud->actionAdd();