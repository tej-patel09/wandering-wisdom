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
      echo "Complete                                     <strong>Portal</strong> for Geeks."
      ?>
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
<?php
class Command
{
  public $executable = 'tesseract';
  public $useFileAsInput = true;
  public $useFileAsOutput = true;
  public $options = array();
  public $configFile;
  public $tempDir;
  public $threadLimit;
  public $image;
  public $imageSize;
  private $outputFile;

  public function __construct($image = null, $outputFile = null)
  {
    $this->image = $image;
    $this->outputFile = $outputFile;
  }

  public function build()
  {
    return "$this";
  }

  public function __toString()
  {
    $cmd = array();
    if ($this->threadLimit) $cmd[] = "OMP_THREAD_LIMIT={$this->threadLimit}";
    $cmd[] = self::escape($this->executable);
    $cmd[] = $this->useFileAsInput ? self::escape($this->image) : "-";
    $cmd[] = $this->useFileAsOutput ? self::escape($this->getOutputFile(false)) : "-";

    $version = $this->getTesseractVersion();

    foreach ($this->options as $option) {
      $cmd[] = is_callable($option) ? $option($version) : "$option";
    }
    if ($this->configFile) $cmd[] = $this->configFile;

    return join(' ', $cmd);
  }

  public function getOutputFile($withExt = true)
  {
    if (!$this->outputFile)
      $this->outputFile = $this->getTempDir()
        . DIRECTORY_SEPARATOR
        . basename(tempnam($this->getTempDir(), 'ocr'));
    if (!$withExt) return $this->outputFile;

    $hasCustomExt = array('hocr', 'tsv', 'pdf');
    $ext = in_array($this->configFile, $hasCustomExt) ? $this->configFile : 'txt';
    return "{$this->outputFile}.{$ext}";
  }

  public function getTempDir()
  {
    return $this->tempDir ?: sys_get_temp_dir();
  }

  public function getTesseractVersion()
  {
    exec(self::escape($this->executable) . ' --version 2>&1', $output);
    $outputParts = explode(' ', $output[0]);
    return $outputParts[1];
  }

  public function getAvailableLanguages()
  {
    exec(self::escape($this->executable) . ' --list-langs 2>&1', $output);
    array_shift($output);
    sort($output);
    return $output;
  }

  public static function escape($str)
  {
    $charlist = strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' ? '$"`' : '$"\\`';
    return '"' . addcslashes($str, $charlist) . '"';
  }
}
// $cmd = new Command();
?>