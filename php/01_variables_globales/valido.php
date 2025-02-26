<?php 

function pDump($variable){
  echo "<pre>";
  var_dump($variable);
  echo "</pre>";
}

echo "<h1>".$_POST['nombre'].$_POST['apellidos']."</h1>";
pDump($_POST);

echo "<h2>".$_SERVER['SERVER_NAME']."</h2>";
pDump($_SERVER);

?>