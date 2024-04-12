<?php
require_once("header.php");
?>

<form method="post" action="action_setnewpassword.php">
   <div class="contact_section layout_padding">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-6">
               <div class="mail_section_1">
                  <h1 class="contact_taital">Nieuw wachtwoord</h1>
                  <div class="form">
                     <input type="password" class="mail_text" placeholder="Nieuw wachtwoord" name="password" />
                  </div> <br />
                  <br />
                  <input type="submit" class="btn btn-primary" value="Opslaan" />
               </div>
            </div>
            <div class="col-md-6 padding_right_0">
               <div class="contact_img"><img src="images/about-img.png"></div>
            </div>

         </div>
      </div>
   </div>
</form>

<?php
require_once("footer.php");
?>