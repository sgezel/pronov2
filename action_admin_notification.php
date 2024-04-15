<?php

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

require 'vendor/autoload.php';

if (isset($_POST)) {
$credential = new ServiceAccountCredentials(
    "https://www.googleapis.com/auth/firebase.messaging",
    json_decode(file_get_contents("pvKey.json"), true)
);

$token = $credential->fetchAuthToken(HttpHandlerFactory::build());

$ch = curl_init("https://fcm.googleapis.com/v1/projects/premedonostiek/messages:send");

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer '.$token['access_token']
]);

$jsonstring123 = "{
    \"message\": {
    \"token\": \"" . $_POST["devicekey"] . "\",
    \"notification\": {
      \"title\": \"" . $_POST["notificationtitle"] . "\",
      \"body\": \"" . $_POST["notificationtext"] . "\",
      \"image\": \"" . $_POST["notificationimg"] . "\"
    },
    \"webpush\": {
      \"fcm_options\": {
        \"link\": \"https://pronostiek.codepage.be\"
      }
    }
  }
}";


  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonstring123);

  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "post");

  $response = curl_exec($ch);

  curl_close($ch);

  echo $response;
  
  echo $jsonstring123;
}

header("location: admin.php?tab=notification");
