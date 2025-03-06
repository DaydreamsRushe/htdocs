<?php
if("POST" == $_SERVER['REQUEST_METHOD'] && isset($_POST['enviar'])){
  if(!empty($_POST['nombre']) && !empty($_POST['apellidos']) &&
  !empty($_POST['edad']) && !empty($_POST['email']) && !empty($_POST['pass'])){
    $error = 'ok';
    (!is_string($_POST['nombre']) || preg_match("/[0-9]/" , $_POST['nombre']))? $error = 'nombre' : '';
    (!is_string($_POST['apellidos']) || preg_match("/[0-9]/" , $_POST['apellidos']))? $error = 'apellidos' : '';
    (!filter_var($_POST['edad'], FILTER_VALIDATE_INT))? $error = 'edad' : '';
    (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))? $error = 'email' : '';
    (strlen($_POST['pass']) < 5)? $error = 'password':'';
  }else{
    $error = "ERRORUM";
  }
}

require_once "../form_procesado.php";
?>