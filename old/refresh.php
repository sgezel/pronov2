<?php
session_start();
$filename = "data/user/" .  $_SESSION["user"] . ".json";

			if(file_exists($filename))
			{
				$userdata =  json_decode(file_get_contents($filename), true);
					
				$_SESSION["data"] = $userdata;	
				
				header("location: /invullen.php");
				
			}	
			else
			{
				header("location: /");
			}

			
?>