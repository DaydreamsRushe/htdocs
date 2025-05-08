<?php
  $password = "Admin123";
  $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 14]);

  echo "Contraseña: " . $password . "\n";
  echo "hash: " . $hash . "\n";
?>