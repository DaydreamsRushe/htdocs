<?php
require_once "assets/functions.php";

//vista de resultados de las variables saneadas
$nombre = saneador($_POST['nombre']);
$apellidos = saneador($_POST['apellidos']);
$edad = saneador($_POST['edad']);
$email = saneador($_POST['email']);
$pass = saneador($_POST['pass']);

//si hay errores vuelve a la vista de index con los mensajes de feedback
if ('ok' != $error){
  header("Location:../index.php?error=$error");
}

session_start();
$_SESSION['nombre'] = $nombre;
$_SESSION['apellidos'] = $apellidos;
$_SESSION['edad'] = $edad;
$_SESSION['email'] = $email;
$_SESSION['pass'] = $pass;

require_once "views/feedback.tpl";

?>


