<?php
//mysql_connect()...PDO::Connect
require_once "connect.php";


function modeloRegistrarNuevoUsuario($usuario, $email, $conexion)
{
      //lectura.....intenta escribir
      if (empty($usuario) || empty($email)) {
            return false;
      }
      
      $myrows = [];

      $selectQuery = "SELECT * FROM usuarios WHERE usuario = '$usuario' OR email='$email'";

      $result = $conexion->query($selectQuery);
      if ($result->num_rows > 0){
        return false;
      } 

      $insertQuery = "INSERT INTO usuarios VALUES (NULL, '$usuario','$email')";
      $result = $conexion->query($insertQuery);

      if($result){
        $selectallQuery = "SELECT * FROM usuarios";
        $result = $conexion->query($selectallQuery);
        while($row = $result->fetch_assoc()){
          $myrows[]=$row;
        }
        
        $conexion->close();
        return [$myrows, true];
      }else{
        return false;
      }

}
