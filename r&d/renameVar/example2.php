<?php
class Fruit
{
  // Properties
  public $name;
  public $color;
  // Constructor 
  private function __construct()
  {
  }

  // Methods
  function set_name($name)
  {
    $this->name = $name;
  }
  function get_name()
  {
    return $this->name;
  }
}

$apple = new Fruit();
$banana = new Fruit();
$apple->set_name('Apple');
$banana->set_name('Banana');

echo "Fruit";
echo "name";
echo "color";
echo "this";
echo "$this";
echo "->";
echo "col          or";
echo "                     ";
echo "$this";
echo "get_name";
echo $apple->get_name();
echo "<br>";
echo $banana->get_name();
?>
<!DOCTYPE html>
<html>

<head>
  <style>
    h1 {
      color: green;
    }
  </style>
</head>
<!-- This is a test comment  -->

<body>
  <center>
    <h1>Welcome To GFG</h1>
    <!-- This is a test comment  -->
    <p>
      <?php
      echo "Complete                                     <strong>Portal</strong> for Geeks." ?>
      <br><br>
      <?php
      echo 'Explore, <?php ?> <!-- -->learn and grow.';
      echo 'Explore,                                                                                           learn and grow.';
      echo 'Explore, learn and grow.';
      echo 'Explore, learn and grow.';
      echo 'Explore, learn and grow.';
      echo 'Explore, learn and grow.';
      echo 'Explore, learn and grow.';
      echo 'Explore, learn and grow.';
      echo 'Explore, learn and grow.';
      echo 'Explore, learn and grow.';
      echo 'Explore, learn and grow.'; ?>
    </p>
  </center>
</body>

</html>