<?php
$host = "localhost";
$user = "root";
$pass = "";
$bd = "users2025";

/* $host = "sql206.byethost3.com";
$user = "b3_33494328";
$pass = "violeta25";
$bd = "b3_33494328_users25"; */

$conexion = new mysqli($host,$user,$pass,$bd);

if ($conexion -> connect_errno){
  die("Errorum de connexion (" . $conexion->connect_errno . ") " . $conexion->connect_error);
}

echo "Enhorabuena... conexion realizada" . $conexion->host_info;
?>