<?php
session_start();
session_destroy();
session_start();
$_SESSION["registergroup"] = "Linkhout";
header("location: index.php");
?>

