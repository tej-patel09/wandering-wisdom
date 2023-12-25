<?php
require '../../vendor/autoload.php';

$mongoConnectionString = "mongodb://localhost:27017";
$files = [];
$files['header'] = "./assets/php/header.php";
$files['footer'] = "./assets/php/footer.php";
$files['nav'] = "./assets/php/navbar.php";
$DB = [
  "wandering-wisdom" => "wandering-wisdom"
];
$collection = [
  'country' => 'country',
  'googleCred' => 'googleCred',
];
