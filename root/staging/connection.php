<?php
require_once("./vars.php");
function dd($d)
{
  echo "<pre>" . var_export($d, true) . "</pre>";
}
$MongoConnect = new MongoDB\Client($mongoConnectionString);
$mongoConnectionString = NULL;
$ww = $MongoConnect->{$DB['wandering-wisdom']};
