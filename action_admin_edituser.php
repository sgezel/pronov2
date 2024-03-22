<?php
session_start();
include_once("UserCrud.php");

$userCrud = new UserCrud();

if(isset($_POST))
    $userCrud->actionEdit();