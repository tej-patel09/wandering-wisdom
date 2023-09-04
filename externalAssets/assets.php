<?php
require '../vendor/autoload.php';
$con = new MongoDB\Client("mongodb://localhost:27017");
$DB = "wandering-wisdom";
$db = $con->$DB;
$collection = $db->country;
$record = $collection->find([]);
foreach ($record as $employe => $val) {
  print_r($val);
}
