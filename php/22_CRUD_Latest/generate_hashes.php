<!-- <?php
/* $password1 = "OscarEroles";
$password2 = "SantiagoPerolillos";

$hash1 = password_hash($password1, PASSWORD_DEFAULT);
$hash2 = password_hash($password2, PASSWORD_DEFAULT);

echo "Hash para Oscar Eroles: " . $hash1 . "\n";
echo "Hash para Santiago Perolillos: " . $hash2 . "\n"; */
?>  -->
<?php
$password1 = "OscarEroles";
$password2 = "SantiagoPerolillos";
$password3 = "Admin123@";

// Configuración del coste
$options = ['cost' => 14];

$hash1 = password_hash($password1, PASSWORD_DEFAULT, $options);
$hash2 = password_hash($password2, PASSWORD_DEFAULT, $options);
$hash3 = password_hash($password3, PASSWORD_DEFAULT, ['cost' => 14]);

echo "Hash para Oscar Eroles: " . $hash1 . "<br/>";
echo "Hash para Admin: " . $hash3 . "<br/>";





?>