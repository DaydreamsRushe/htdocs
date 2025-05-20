<?php
$password = "Admin123!"; // Nueva contraseña para el administrador
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 14]);

echo "Contraseña: " . $password . "\n";
echo "Hash: " . $hash . "\n";
?> 