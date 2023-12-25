<?php

$a = [];
$_ = hex2bin("61727261795f6d65726765");
$a = $_($a, [123]);
print_r($a);

header('Content-Type: text/plain');

file_put_contents("o2n.php", php_strip_whitespace("o2.php"));

file_put_contents("o1n2.php", php_strip_whitespace("o1.php"));

function rmspace($buffer)
{
  // https://chrisleverseo.com/t/minify-html-with-this-php-function.22/ 
  $search = [
    '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
    '/[^\S ]+\</s',     // strip whitespaces before tags, except space
    '/(\s)+/s',         // shorten multiple whitespace sequences
    '/<!--(.|\s)*?-->/' // Remove HTML comments
  ];

  $replace = ['>', '<', '\\1', ''];

  $buffer = preg_replace($search, $replace, $buffer);
  print_r($buffer);
  return $buffer;
};
$html = rmspace(file_get_contents("o1.php"));

// ob_start();
// include("new_file_html.php");
// $html = rmspace(ob_get_clean());
// ob_end_clean();

print_r($html);
file_put_contents("o1n.php", $html);
