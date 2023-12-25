<?php
header('Content-Type: text/plain');
// $tokens = token_get_all(file_get_contents('example.php'));
$tokens = token_get_all(file_get_contents('example2.php'));

$globals = array('$GLOBALS', '$_SERVER', '$_GET', '$_POST', '$_FILES', '$_COOKIE', '$_SESSION', '$_REQUEST', '$_ENV', '$this');
$globalFunctions = array('__construct');

$registry = get_defined_functions();
var_export($registry);
$registry = $registry['internal'];
$var = 'a';
foreach ($tokens as $key => $element) {
  print_r($element);
  if (isset($element[1]))
    print_r(token_name($element[0]));
  echo "\n";
  if (!is_array($element)) {
    continue;
  }
  switch ($element[0]) {
    case T_FUNCTION:
    case T_CLASS:
      if (in_array($tokens[$key + 2][1], $globalFunctions)) {
        continue 2;
      }
      $prefix = '';
      $index = $key + 2;
      break;

    case T_VARIABLE:
      if (in_array($element[1], $globals)) {
        continue 2;
      }
      // else if (isset($element[1], $customVariables)) {
      // }
      $prefix = '$';
      $index = $key;
      break;

    case T_OBJECT_OPERATOR:
      $temp = $tokens[$key + 1][1];
      if (isset($registry['$' . $temp]))
        $temp = substr($registry['$' . $temp], 1);
      else
        $temp = $registry[$temp];
      $tokens[$key + 1][1] = $temp;
      continue 2;
      break;

    case T_COMMENT:
      unset($tokens[$key]);
      continue 2;
      break;

      // case T_WHITESPACE:
      //   if (isset($tokens[$key - 1][0]) && !($tokens[$key - 1][0] == T_ECHO || $tokens[$key - 1][0] == T_FUNCTION)) {
      //     unset($tokens[$key]);
      //   }
      //   continue 2;
      //   break;

    default:
      continue 2;
  }

  if (!isset($registry[$tokens[$index][1]])) {
    do {
      $replacement = $prefix . $var++;
    } while (in_array($replacement, $registry));

    $registry[$tokens[$index][1]] = $replacement;
  }

  $tokens[$index][1] = $registry[$tokens[$index][1]];
}
foreach ($tokens as $key => $value) {
  print_r($value);
  if (isset($value[1]))
    print_r(token_name($value[0]));
  echo "\n";
}
$tokens = array_map(function ($element) use ($registry) {
  if (is_array($element) && $element[0] === T_STRING) {
    if (isset($registry[$element[1]])) {
      $element[1] = $registry[$element[1]];
    }
  }
  return $element;
}, $tokens);
// unset($tokens[0]);
// $file_input = '<?php ';
$file_input = '';
foreach ($tokens as $token) {
  $temp = $token[1] ?? $token;
  // $temp = preg_replace('/\s\s+/', '', $temp);
  $file_input .= $temp;
}
$file_input = preg_replace('/\s\s+/', '', $file_input);
$file_input = preg_replace('/\<\?php/', '<?php ', $file_input);
// file_put_contents("output.php", $file_input);
file_put_contents("output2.php", $file_input);
