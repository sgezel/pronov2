<?php
require_once("header.php");
?>

<!-- banner section start -->
<div class="banner_section layout_padding">
   <div class="container">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">         
         <div class="carousel-inner">
            <div class="carousel-item active">
               <div class="row">
                  <div class="col-sm-12">
                     <h1 class="banner_taital">Hij is er eindelijk weer!</h1>
                     <p class="banner_text">De <?= $title ?> is er weer vanaf juni 2024!</p>
                     <div class="btn_main">
                        <div class="started_bt"><a href="register.php">Schrijf je nu in!</a></div>
                     </div>
                  </div>
               </div>
            </div>           
         </div>
      </div>
   </div>
</div>
<!-- banner section end -->
<!-- about section start -->
<div class="about_section layout_padding">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="about_taital">Wat is er nieuw?</div>
            <p class="about_text">
               Dit is een tekst die gaat over de gloednieuwe features zoals de quickpick. 
            </p>
            
         </div>
      </div>
   </div>
</div>
<!-- about section end -->

<?php require_once("footer.php"); ?>