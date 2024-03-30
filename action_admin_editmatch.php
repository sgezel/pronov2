<?php
session_start();
include_once("MatchCrud.php");

$matchCrud = new MatchCrud();

if(isset($_POST))
    $matchCrud->actionEdit();