<?php require_once("config.php"); ?>

<!DOCTYPE html>
<html>

<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- site metas -->
   <title><?= $title; ?></title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- bootstrap css -->
   <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
   <!-- style css -->
   <link rel="stylesheet" type="text/css" href="css/style.css">
   <!-- Responsive-->
   <link rel="stylesheet" href="css/responsive.css">
   <!-- fevicon -->
   <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
   <link rel="manifest" href="images/favicon/site.webmanifest">
   <!-- Scrollbar Custom CSS -->
   <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
   <!-- Tweaks for older IEs-->
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <!-- font css -->
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Raleway:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

   <div class="header_section">
      <div class="container">
         <?php require_once("navigation_top.php"); ?>
      </div>
   </div>
   
   <!-- header section end -->
   <?php if (isset($error_message)) : ?>
      <div class="row">
         <div class="col-md-12">
            <div class="alert alert-danger">
               <?= $error_message; ?>
            </div>
         </div>
      </div>
   <?php endif; ?>

   <?php if (isset($success_message)) : ?>
      <div class="row">
         <div class="col-md-12">
            <div class="alert alert-success">
               <?= $success_message; ?>
            </div>
         </div>
      </div>
   <?php endif; ?>