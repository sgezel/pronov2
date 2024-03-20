<?php
require_once("config.php");

function redirect( $location )
{
    header("location: " . $location . ".php");
}
