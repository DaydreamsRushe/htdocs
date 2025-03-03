<?php
require 'assets/functions.php';

session_start();
echo $normal_var;
echo "<br>";
echo $_SESSION['session_var1'];
$numero = 355323532532523;
echo "<br>";

$_SESSION['session_var2']=$numero;
pDump($_SESSION);
echo "<br>";
?>

<a href="intr_variables_sesion.php">Ir a intro de variables de sesion</a> || <a href="mas_vars_sesion.php">Ir a mas variables de sesion</a>