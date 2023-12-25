<?php
/*
  This is a multiline
*/
$example = "\/* This is a multiline*/";
$anothervar = 'function exampleFunction($variable2)';
$anothervar2 = "function exampleFunction($anothervar)";
$arr = [];
$arr['temp']  = "Qe";

if /* some comment in middle*/ (isset($_POST['something'])) { // somecomment
  echo $_POST['something'];
}
if (isset($_POST[$anothervar])) {
  echo $_POST[$anothervar];
}
// This is a comment             
function exampleFunction($variable2)
{
  echo $variable2;
}

exampleFunction($example);

$variable3 = array('example', 'another');

foreach ($variable3 as $key => $var3val) {
  echo $var3val . "somestring";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

</body>

</html>