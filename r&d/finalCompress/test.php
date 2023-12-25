<?php
header('Content-Type: text/plain');

function rmspace($buffer)
{
  $search = ['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s', '/<!--(.|\s)*?-->/'];
  $replace = ['>', '<', '\\1', ''];
  $buffer = preg_replace($search, $replace, $buffer);
  return $buffer;
};

$tokens = token_get_all(file_get_contents('example1.php'));
$globals = ['$GLOBALS', '$_SERVER', '$_GET', '$_POST', '$_FILES', '$_COOKIE', '$_SESSION', '$_REQUEST', '$_ENV', '$this'];
$magicFunctions = ['__construct()', '__destruct()', '__call()', '__callStatic()', '__get()', '__set()', '__isset()', '__unset()', '__sleep()', '__wakeup()', '__serialize()', '__unserialize()', '__toString()', '__invoke()', '__set_state()', '__clone()',  '__debugInfo()'];

$registry = get_defined_functions();
$registry = $registry['internal'];

$var = 'a';

foreach ($tokens as $key => $element) {
  print_r($key);
  print_r($element);
  if (isset($element[1]))
    print_r(token_name($element[0]));
  echo "\n";
  if (!is_array($element)) {
    continue;
  }
  switch ($element[0]) {
    case T_OPEN_TAG:
      $tokens[$key][1] .= ' ';
      continue 2;
      break;

    case T_FUNCTION:
    case T_CLASS:
      if (in_array($tokens[$key + 2][1], $magicFunctions)) {
        continue 2;
      }
      $prefix = '';
      $index = $key + 2;
      break;

    case T_VARIABLE:
      if (in_array($element[1], $globals)) {
        continue 2;
      }
      $prefix = '$';
      $index = $key;
      break;

    case T_OBJECT_OPERATOR:
      $temp = $tokens[$key + 1][1];
      if (isset($registry['$' . $temp]))
        $temp = substr($registry['$' . $temp], 1);
      else {
        if (isset($registry[$temp])) {
          $temp = $registry[$temp];
        } else {
          $registry[$temp] = $var++;
          $temp = $registry[$temp];
        }
      }
      $tokens[$key + 1][1] = $temp;
      continue 2;
      break;

    case T_DOUBLE_COLON:
      if (in_array($tokens[$key + 1][1], $magicFunctions)) {
        continue 2;
      }
      $prefix = '';
      $index = $key + 1;
      break;

    case T_COMMENT:
      unset($tokens[$key]);
      continue 2;
      break;

    case T_INLINE_HTML:
      $tokens[$key][1] = rmspace($tokens[$key][1]);
      continue 2;
      break;

    case T_STRING:
      if (isset($registry[$element[1]])) {
        $tokens[$key][1] = $registry[$element[1]];
      }
      continue 2;
      break;

    default:
      continue 2;
  }

  if (!isset($registry[$tokens[$index][1]])) {
    $registry[$tokens[$index][1]] = $prefix . $var++;
  }
  $tokens[$index][1] = $registry[$tokens[$index][1]];
}

$file_input = '';
foreach ($tokens as $key => $token) {
  print_r($key);
  print_r($token);
  if (isset($token[1]))
    print_r(token_name($token[0]));
  echo "\n";
  $temp = $token[1] ?? $token;
  if (is_array($temp)) {
    print_r($temp);
    print_r("q3wr3q");
  }
  $file_input .= $temp;
}
$file_input = str_replace(["\n", "\r"], '', $file_input);
file_put_contents("output2.php", $file_input);
file_put_contents("output1.php", php_strip_whitespace("output2.php"));
