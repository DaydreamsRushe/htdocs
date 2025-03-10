<?php
//mysql_connect()...PDO::Connect

function modeloRegistrarNuevoUsuario($usuario, $email)
{
      //lectura.....intenta escribir
      if (empty($usuario) || empty($email)) {
            return false;
      }

      $salida = "";

      $usuarios = fopen("../model/usuarios.txt", "a+"); //funcion para abrir y crear si no existe un fichero. El modo (a+) nos situa al final del mismo y nos permite añadir datos
      $usuarios = file("../model/usuarios.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); //ignora las lineas vacias

      foreach ($usuarios as $linea) {
            list($user, $em) = explode(" : ", $linea);//user:email
            //si alguna variable de list, es = al $usuario o $email, devolvemos false a controller
            if (($usuario === $user)||($email === $em)) return false;
            //si no devolvemos false, el valor del fichero es el mismo + la nueva linea
            //$salida .= $linea . PHP_EOL
            $salida .= $linea . "\n";
      }

      $salida .= "$usuario : $email";

      file_put_contents("../model/usuarios.txt", $salida);

      echo nl2br($salida);


      return true;


}
