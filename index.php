<?php
require_once("header.php");
?>

<!-- banner section start -->
<div class="banner_section layout_padding">
   <div class="container">
      
               <div class="row">
                  <div class="col-sm-12">
                     <h1 class="banner_taital">Hij is er eindelijk weer! <?=$_SESSION["registergroup"] ?>   <?= $_GET["group"] ?>  <?= session_id() ?>.</h1>
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
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="5" aria-label="Slide 6"></button>
    </div>
    <div class="carousel-inner">
      
    <?php if($sponsor) : ?>
      <div class="carousel-item active" style="background-image:url(images/premed.jpg);">
        <div class="container">
          <div class="carousel-caption text-start">
            <h1>We hebben een sponsor!</h1>           
               <p>Premed verdubbelt het binnengekomen inschrijvingsgeld, waardoor we extra deelnemers kunnen belonen. Dankjewel!.</p>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div class="carousel-item" <?php !$sponsor ? "active" : "";?> style="background-image:url(images/smartphone.jpg);">
        
        <div class="container">
          <div class="carousel-caption">
            <h1>De Pr(emed)onostiek, nu ook in jouw handpalm!</h1>
            <p>De vernieuwde website is smartphonecompatibel, dus nog meer plezier op nog meer toestellen!</p>
          </div>
        </div>
      </div>

      <div class="carousel-item" style="background-image:url(images/quickpick.jpg);">
        
        <div class="container">
          <div class="carousel-caption">
            <h1>Snel, Slim, QuickPick&trade;!</h1>
            <p>Voor de vergeetachtige of voor de niet-voetbalfan hebben we nu het nieuwe QuickPick&trade;, het systeem dat het werk voor jou doet!</p>
          </div>
        </div>
      </div>

      <div class="carousel-item" style="background-image:url(images/notifications.png);">
        
        <div class="container">
          <div class="carousel-caption">
            <h1>Blijf Voorop met Onze Notificaties!</h1>
            <p>Accepteer onze notificatiemeldingen en ontvang updates, zodat je nooit een kans mist om te pronostikeren!</p>
          </div>
        </div>
      </div>


      <div class="carousel-item" style="background-image:url(images/badges.png);">
        
        <div class="container">
          <div class="carousel-caption text-end">
            <h1>Verdien Je Badges!</h1>
            <p>Elke mijlpaal brengt u een stap dichter bij het verdienen van exclusieve badges. Pronostikeer, presteer en verzamel ze allemaal!<br />
               </p>
          </div>
        </div>
      </div>
      
      <div class="carousel-item" style="background-image:url(images/livescore.jpg);">
        

        <div class="container">
          <div class="carousel-caption text-start">
            <h1>Beleef de Actie Bijna Live op Pr(emed)onostiek!</h1>
            <p>Mis geen moment van de spanning! Met onze livescore-updates (elke 5 minuten) blijf je altijd in het hart van de actie.</p>
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