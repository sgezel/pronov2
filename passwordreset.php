<?php
require_once("header.php");
?>

<form method="post" action="action_passwordreset.php">
<div class="contact_section layout_padding">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-6">
                  <div class="mail_section_1">
                     <h1 class="contact_taital">Wachtwoord resetten?</h1>
                     <div class="form">
                        <input type="text" class="mail_text" placeholder="E-mailadres" name="username" />                       
                     </div>
                     <input type="submit" class="btn btn-primary" value="Wachtwoord resetten" />
                  </div>
               </div>
               <br/>
               <br/>
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
