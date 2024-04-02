<?php
session_start();
include_once("MatchCrud.php");

CheckAdminAccess();

$matchCrud = new MatchCrud();

if(isset($_POST))
    $matchCrud->actionEdit();