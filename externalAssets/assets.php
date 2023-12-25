<?php
require '../vendor/autoload.php';
function dd($d)
{
  echo "<pre>" . var_export($d, true) . "</pre>";
}
$MongoConnect = new MongoDB\Client("mongodb://localhost:27017");
dd($_SERVER);
dd($_REQUEST);
$DB = "wandering-wisdom";
$collection = [
  'country' => 'country',
  'googleCred' => 'googleCred',
];
$WanderingWisdom = $MongoConnect->$DB;
// $collection = $db->$collection['country'];
// $record = $collection->find([]);
// foreach ($record as $employe => $val) {
//   print_r($val);
// }
