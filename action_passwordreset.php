<?php
require_once("config.php");
include_once('UserCrud.php');

$crud = new UserCrud();

if(isset($_POST))
    $crud->actionReset();
