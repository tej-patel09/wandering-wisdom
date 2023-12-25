<?php
// Example 1
$var1 = "cybersecurity";
echo $var1[0];
echo $var1[000001];
echo $var1[0x002];
/* 
  Warning: String offset cast occurred in .....test.php on line 7
  Gives warning for below but can be ignored
*/
echo $var1[FALSE];
echo $var1[TRUE];
echo $var1[true];



echo "<br /><br /><br /><br /><br /><br />";
// Example 2
$x = "HI";
$HI = "HOW";
$HOW = "ARE";
$ARE = "YOU";

echo $x . $$x . $ $$x . $ $ $$x; // Output : HIHOWAREYOU
//Same Output : echo $x . $$x . $$$x . $$$$x; in both cases




echo "<br /><br /><br /><br /><br /><br />";
// Example 3
$a = "a";
for ($i = 0; $i < 100; $i++) {
  echo ++$a . " " . strlen($a) . ", ";
}
echo "<br /><br />";
$a = "a1";
for ($i = 0; $i < 100; $i++) {
  echo ++$a . " " . strlen($a) . ", ";
}



echo "<br /><br /><br /><br /><br /><br />";
// Example 4
echo ("A" & "B");
echo ("A" | "B");
echo ("A" ^ "B");
echo (~"B");
echo ~"a";
echo ord(~"a");
