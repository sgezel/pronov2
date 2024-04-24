<?php
require_once("header.php");
?>

<!-- banner section start -->
<div class="banner_section layout_padding">
   <div class="container">
      
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
<!-- banner section end -->
<!-- about section start -->
<div class="about_section layout_padding">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="about_taital">Wat is er nieuw?</div>

            <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators ">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        
        <img src="https://splidejs.com/images/slides/image-slider/01.jpg" class="bd-placeholder-img" width="100%" height="100%"/>

        <div class="container">
          <div class="carousel-caption text-start">
            <h1>Smartphone compatibel.</h1>
           
               <p>De vernieuwde website is smartphonecompatibel, dus nog meer plezier op nog meer toestellen!</p>

          </div>
        </div>
      </div>
      <div class="carousel-item">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>

        <div class="container">
          <div class="carousel-caption">
            <h1>QuickPick&trade;.</h1>
            <p>Voor de vergeetachtige of voor de niet-voetbalfan hebben we nu het nieuwe QuickPick&trade;, het systeem dat het werk voor jou doet!</p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>

        <div class="container">
          <div class="carousel-caption text-end">
            <h1>Badges</h1>
            <p>Probeer ook al onze badges te verzamelen! <br />
               De tussenstanden worden tijdens de wedstrijd elke 5 minuten, automatisch, geüpdatet. Hierdoor kan je bijna Live de stand volgen en zien waar je op het scorebord zal staan.</p>
          </div>
        </div>
      </div>
      
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Vorige</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Volgende</span>
    </button>
  </div>
  
            </p>
            
         </div>
      </div>
   </div>
</div>
<!-- about section end -->

<?php require_once("footer.php"); ?>