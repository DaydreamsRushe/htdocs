<?php
require_once "assets/functions.php";
session_start();

if(isset($_GET['error'])){
  $error = $_GET['error'];

  $nombre = $_SESSION['nombre'];
  $apellidos = $_SESSION['apellidos'];
  $edad = $_SESSION['edad'];
  $email = $_SESSION['email'];
  $pass = $_SESSION['pass'];

  pDump($nombre);
  pDump($apellidos);
  pDump($edad);
  pDump($email);
  pDump($pass);

  echo ('ERRORUM' == $error)? '<strong style="color:red">Introduce todos los datos en todos los campos del formulario</strong>':'';
  echo ('nombre' == $error)? '<strong style="color:red">Introduce bien el nombre</strong>':'';
  echo ('apellidos' == $error)? '<strong style="color:red">Introduce bien los apellidos</strong>':'';
  echo ('edad' == $error)? '<strong style="color:red">Introduce bien la edad</strong>':'';
  echo ('email' == $error)? '<strong style="color:red">Introduce bien el correo electronico</strong>':'';
  echo ('password' == $error)? '<strong style="color:red">Introduce una contraseña de mas de 5 letras</strong>':'';
}
?>

