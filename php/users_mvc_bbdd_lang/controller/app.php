<?php
require_once "../view/lang.php";
require_once "../model/model.php";
require_once "../view/view.php";
require "functions.php";

function actionNuevoUsuario($con,$lang_form, $lang_feedback)
{
  if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['registrar'])) {
            $error = '';
            $usuario=is_string($_REQUEST['usuario']) && preg_match('/^[A-Za-z ]{5,15}$/', $_REQUEST['usuario'])? $_REQUEST['usuario'] :'';
            if(empty($usuario)){
              $error = $lang_form['missatge_error'][0];
            }

            $email=is_string($_REQUEST['email']) && filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)? $_REQUEST['email']:'';
            if(empty($email)){
              $error = $lang_form['missatge_error'][1];
            }

            $password=is_string($_REQUEST['pwd']) && strlen($_REQUEST['pwd']) >= 5 && strlen($_REQUEST['pwd'])<= 8 && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['pwd'])? $_REQUEST['pwd']:'';
            if(empty($password)){
              $error = $lang_form['missatge_error'][2];
            }
            
            if(empty($error)){
              $usuario = saneadoreitor($usuario);
              $email = saneadoreitor($email);
              $password = saneadoreitor($password);

              list($rows, $ok) = modeloRegistrarNuevoUsuario($usuario, $email, $password, $con);
              if ($ok) {
                //Nos devuelve el modelo un true
                vistaRegistroCompletado($usuario, $email, $password, $rows,$lang_feedback);
                exit;
              } else {
                $selectQuery = "SELECT * FROM usuarios WHERE usuario='$usuario' OR email='$email'";
                $result = $con->query($selectQuery);
                if($result -> num_rows > 0){
                  $error = $lang_form['missatge_error'][3];
                }else{
                  //Verificar si la contraseña existe
                  $selectPasswordQuery = "SELECT password FROM usuarios";
                  $result = $con->query($selectPasswordQuery);
                  $password_exists = false;
                  while ($row = $result->fetch_assoc()){
                    if(password_verify($password, $row['password'])){
                      $password_exists = true;
                      break;
                    }
                  }
                  if ($password_exists){
                    $error = $lang_form['missatge_error'][3]; //error de contraseña existente
                  }
                }
              }
            }
            vistaRegistroIncorrecto($usuario, $email, $password, $lang_form, $error);
            exit;
    
  }
}

if (!isset($_REQUEST['registrar'])) {
      vistaMostrarFormularioRegistro($lang_form);
} else {
      actionNuevoUsuario($con, $lang_form, $lang_feedback);
}
