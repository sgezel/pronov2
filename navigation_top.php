<?php
include_once("SettingCrud.php");
$settingsCrud = new SettingCrud();
$registration = $settingsCrud->actionGetSetting("registrations");
?>

<nav class="navbar navbar-expand-lg  navbar-light bg-light bg-body-tertiary">
   <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
         <img src="images/logo.png" class="float-left" />
        
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav ms-auto">
            <li class="nav-item">
               <a class="nav-link" href="index.php">Home</a>
            </li>

            <li class="nav-item">
               <a class="nav-link" href="reglement.php">Reglement</a>
            </li>

            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) : ?>

               <li class="nav-item">
                  <a class="nav-link" href="main.php">Invullen</a>
               </li>

               <li class="nav-item">
                  <a class="nav-link" href="scoreboard.php">Scorebord</a>
               </li>

               <li class="nav-item">
                  <a class="nav-link" href="overzicht.php">Overzicht</a>
               </li>

               <?php if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) : ?>
                  <li class="nav-item">
                     <a class="nav-link" href="admin.php">Admin</a>
                  </li>
               <?php endif; ?>

               <li class="nav-item">
                  <a class="nav-link" href="logout.php">Uitloggen</a>
               </li>

            <?php else : ?>
               <li class="nav-item">
                  <a class="nav-link" href="login.php">Inloggen</a>
               </li>

               <?php if ($registration) : ?>
                  <li class="nav-item">
                     <a class="nav-link" href="register.php">Registreren</a>
                  </li>
               <?php endif; ?>

            <?php endif; ?>


         </ul>

      </div>
   </div>
</nav>