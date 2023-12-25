<?php
/*
  refrance : https://www.youtube.com/watch?v=8WrwhKY40og&ab_channel=ProgrammersBlogSystem
*/
$data = "Hello World";
ob_start();
include("template.php");
$html = ob_get_clean();
ob_end_clean();
file_put_contents("test.txt", $html);
