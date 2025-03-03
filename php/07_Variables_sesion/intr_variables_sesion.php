<?php
require 'assets/functions.php';

echo $normal_var;

session_start();
$_SESSION['session_var1'] = "yo soy una variable de sesión";
pDump($_SESSION);
echo "<br>";
echo $_SESSION['session_var1'];
echo "<br>";
$_SESSION['session_var2'];

pDump($_SESSION);
?>

<a href="uso_var_sesion.php">Ir a uso de variables de sesion</a> || <a href="mas_vars_sesion.php">Ir a mas variables de sesion</a>