<?php
session_start();
echo $_SESSION['session_var1'];
echo "<br>";

echo $_SESSION['session_var2'];
echo "<br>";

?>

<a href="intr_variables_sesion.php">Ir a intro de variables de sesion</a> || <a href="uso_var_sesion.php">Ir a uso de variables de sesion</a>
<?php session_destroy(); ?>