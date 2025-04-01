<?php
require_once "../model/connect.php";

function modeloLogin($usuario, $password, $con)
{
    if (empty($usuario) || empty($password)) {
        return [false, null];
    }

    $selectQuery = "SELECT * FROM usuarios2 WHERE usuario='$usuario'";
    $result = $con->query($selectQuery);
    
    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        if (password_verify($password, $user_data['password'])) {
            return [true, $user_data];
        }
    }
    
    return [false, null];
}

function modeloRegistrarNuevoUsuario($usuario, $email, $password, $con)
{
  //lectura.....intenta escribir
  if (empty($usuario) || empty($email) || empty($password)) {
    return [null, false];
  }

    $myrows = [];

    // Verificar si existe usuario o email
    $selectQuery = "SELECT * FROM usuarios2 WHERE usuario='$usuario' OR email='$email'";
    $result = $con->query($selectQuery);
    if ($result->num_rows > 0) {
        return [null, false];
    }

    // Verificar si la contraseña ya existe
    $selectPasswordQuery = "SELECT password FROM usuarios2";
    $result = $con->query($selectPasswordQuery);
    while ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            return [null, false];
        }
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    $insertQuery = "INSERT INTO usuarios2 VALUES (NULL,'$usuario','$email','$hashed_password')";
    $result = $con->query($insertQuery);
    if ($result) {
        $selectallQuery = "SELECT * FROM usuarios2";
        $result = $con->query($selectallQuery);
        while ($row = $result->fetch_assoc()) {
            $myrows[] = $row;
        }
        return [$myrows, true];
    } else {
        return [null, false];
    }
}
