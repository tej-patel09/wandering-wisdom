<?php
require_once("./connection.php");
// $countryData = $ww->{$collection['country']}->find([])->toArray();
// dd($countryData);
$countryData = $ww->{$collection['country']}->find([]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php
  require_once($files['header']);
  ?>

<body>
  <?php
  require_once($files['nav']);
  ?>
  <div class="container">
    <table class="table table-bordered">
      <thead>
        <tr>
          <td>Sr. No.</td>
          <td>Name</td>
          <td>Population</td>
          <td>World Share</td>
          <td>Land Area</td>
        </tr>
      </thead>
      <thead>
        <?php
        foreach ($countryData as $key => $value) {
          echo "<tr>";
          echo "<td>{$value['_id']}</td>";
          echo "<td>{$value['countryName']}</td>";
          echo "<td>{$value['population']}</td>";
          echo "<td>{$value['worldShare']}%</td>";
          echo "<td>{$value['landArea']}</td>";
          echo "</tr>";
        }
        ?>
      </thead>
    </table>
  </div>
  <?php
  require_once($files['footer']);
  ?>
</body>

</html>