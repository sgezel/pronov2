<?php
require_once("header.php");
include_once("UserCrud.php");
require_once("SettingCrud.php");

$crud = new UserCrud();
$settingsCrud = new SettingCrud();
$registrations = $settingsCrud->actionGetSetting("registrations");

if($registrations !== true && $registrations !== "on")
   header("location: index.php");

?>

<form method="post" action="action_register.php" autocomplete="off">
   <div class="contact_section layout_padding">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-6">
               <div class="mail_section_1">
                  <h1 class="contact_taital">Registreren</h1>
                  <div class="form">
                     <input type="email" class="mail_text" placeholder="Email" name="username" required autofill="false" />
                     <input type="text" class="mail_text" placeholder="Naam" name="name" required/>
                     <input type="password" class="mail_text" placeholder="Wachtwoord" name="password" required/>
                     <input type="password" class="mail_text" placeholder="Wachtwoord herhalen" name="password2" required/>
                  </div>
                  <input type="submit" class="btn btn-primary" value="Maak account" />
               </div>
            </div>
            <div class="col-md-6 padding_right_0">
               <div class="contact_img"><img src="images/contact-img.png"></div>
            </div>
         </div>
      </div>
   </div>
</form>

<?php
require_once("footer.php");
?>