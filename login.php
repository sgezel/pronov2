<?php
require_once("header.php");
?>

<form method="post" action="action_login.php">
<div class="contact_section layout_padding">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-6">
                  <div class="mail_section_1">
                     <h1 class="contact_taital">Inloggen</h1>
                     <div class="form">
                        <input type="text" class="mail_text" placeholder="E-mailadres" name="username" />
                        <input type="password" class="mail_text" placeholder="Wachtwoord" name="password" />                       
                     </div>
                     <input type="submit" class="btn btn-primary" value="Log In" />
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
