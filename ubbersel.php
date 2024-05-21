<?php
session_start();
session_destroy();
session_start();
$_SESSION["registergroup"] = "Ubbersel";
header("location: index.php");
?>

