<?php
	session_set_cookie_params(604800);
	session_start();

	$_SESSION["login"]["message"] = "Gebruikersnaam of wachtwoord incorrect.";   
    
	if(isset($_POST["username"]) && isset($_POST["password"]))
	{
		$username = $_POST["username"];
		$password = $_POST["password"];

		if($username !== "" && $password!=="")
		{
			$filename = "data/user/" .  $username . ".json";

			if(file_exists($filename))
			{
				$userdata =  json_decode(file_get_contents($filename), true);

				if($userdata["password"] == $password)
				{

					$_SESSION["user"] = $userdata["username"];
					$_SESSION["login"]["message"] = "";
					$_SESSION["data"] = $userdata;
				}	

                header("location: /beta/invullen.php");
				
			}			
				
		}

	}	
?>

<?php include("header.php"); ?>


<div class=container>
            <div class=row>
            <section class="map_wrapper clearfix" style="padding: 150px 0 0 0;">
        <div class=container>
            <div class=row>
                <div class=contact_form><h2 class=heading>in<span>loggen</span></h2>

                   <form method="post" action="login.php" data-parsley-validate="" name=contact class="formcontact clearfix">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Email" required=""
                                                     data-parsley-required-message=""></div>
                        <div class="form-group"><input type="password" class="form-control" name="password" placeholder="Wachtwoord"
                                                     required="" data-parsley-required-message="">
                        </div>
                        
                        <input type=submit class="btn btn-red" value="Inloggen!" />
                        <div class=form-message></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
            </div>
        </div>



    <?php include("footer.php"); ?>