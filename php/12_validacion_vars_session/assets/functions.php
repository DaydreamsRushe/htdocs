<?php
function pDump($var){
  echo "<pre>";
  var_dump($var);
  echo "</pre>";
}

function saneador($data){
  trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>