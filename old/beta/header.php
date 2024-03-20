<?php 
  include("config.php");
  $logged_in = false;

  if(isset($_SESSION["user"]) && $_SESSION["user"] !== "")
    $logged_in = true;
  ?>

<!doctype html>
<html class=no-js lang="">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset=utf-8>
    <meta name=description content="">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title>Premedonostiek</title>
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
    <link rel=stylesheet href=vendor.css>
    <link rel=stylesheet href=style.css>
    <link rel=stylesheet type=text/css href=css/layerslider.css>
    <script src=js/vendor/modernizr.js></script>
</head>
<body><!--[if lt IE 10]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<div class=wrapper>
    <header class=header-main>
        <div class=header-upper>
            <div class=container>
                <div class=row>
                    <ul>
                        <?php if($config["enable_registrations"]): ?>
                            <li><a href="register.php">Registreren</a></li>
                        <?php endif; ?>
                        
                        <?php if($config["enable_login"]): ?>
                            <?php if (!$logged_in): ?>
                                <li><a href="login.php">Inloggen</a></li>
                            <?php else: ?>
                                <li><a href="logout.php">Uitloggen</a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-lower clearfix">
            <div class=container>
                <div class=row><h1 class=logo><a href="index.php"><img src=images/logo.png alt=image></a></h1>

                    <div class=menubar>
                        <nav class=navbar>
                            <div class=nav-wrapper>
                                <div class=navbar-header>
                                    <button type=button class=navbar-toggle><span class=sr-only>Toggle navigation</span>
                                        <span class=icon-bar></span></button>
                                </div>
                                <div class=nav-menu>
                                    <ul class="nav navbar-nav menu-bar">
                                        <li><a href=index.php  class="<?= (basename($_SERVER['PHP_SELF']) === "index.php") ? "active" : "";  ?>">Home <span></span> <span></span>
                                            <span></span> <span></span></a></li>

                                            <?php if ($logged_in): ?>
                                                <li><a href="invullen.php" class="<?= (basename($_SERVER['PHP_SELF']) === "invullen.php") ? "active" : "";  ?>">Pronostiek <span></span> <span></span> <span></span> <span></span></a>                                                 </li>

                                        <li><a href="scoreboard.php" class="<?= (basename($_SERVER['PHP_SELF']) === "scoreboard.php") ? "active" : "";  ?>">Scorebord <span></span> <span></span> <span></span> <span></span></a>
                                            
                                        </li>
                                        <?php endif;?>
                                        
                                        <li><a href=reglement.php class="<?= (basename($_SERVER['PHP_SELF']) === "reglement.php") ? "active" : "";  ?>">Reglement <span></span> <span></span> <span></span>
                                            <span></span></a></li>

                                            
                                        <?php if (isset($_SESSION["data"]["admin"]) && $_SESSION["data"]["admin"] == true): ?>
                                        <li class="">
                                            <a href="admin.php" class="<?= (basename($_SERVER['PHP_SELF']) === "admin.php") ? "active" : "";  ?>">Admin</a>
                                        </li>
                                        <?php endif;?>
                                       
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                   
            </div>
        </div>
    </header>