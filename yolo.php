<?php
session_start();
session_destroy();
session_start();
$_SESSION["registergroup"] = "Yolo";
header("location: index.php");
?>

