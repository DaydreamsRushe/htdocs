<?php
require_once "../model/connect.php";

function modeloRegistrarNuevoUsuario($usuario, $email, $password, $con)
{
      //lectura.....intenta escribir
      if (empty($usuario) || empty($email) || empty($password)) {
            return [null, false];
      }

      $myrows = [];

      //Verificar si existe usuario o email
      $selectQuery = "SELECT * FROM usuarios WHERE usuario='$usuario' OR email='$email' ";
      $result = $con->query($selectQuery);
      if ($result->num_rows > 0) {
                return [null, false];
      }

      //Verificar si contraseña ya existe
      $selectPasswordQuery = "SELECT password FROM usuarios";
      $result = $con->query($selectPasswordQuery);
      while($row = $result -> fetch_assoc()){
        if (password_verify($password,$row['password'])) {
          return [null, false];
        }
      }

      $hashed_password = password_hash($password, PASSWORD_DEFAULT, ['cost'=>12]);
      $insertQuery = "INSERT INTO usuarios VALUES (NULL,'$usuario','$email','$hashed_password')";
      $result = $con->query($insertQuery);
      if ($result) {
            $selectallQuery = "SELECT * FROM usuarios";
            $result = $con->query($selectallQuery);
            while ($row = $result->fetch_assoc()) {
                  $myrows[] = $row;
            }
            return [$myrows, true];
      } else {
             return [null, false];
      }
}
