<?php
require "../lang/lang.php";
require "../model/model.php";
require "../view/view.php";
require "functions.php";




function actionNuevoUsuario($conexion, $lang)
{
      if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['registrar'])) {

            $usuario = isset($_REQUEST['usuario']) ? $_REQUEST['usuario'] : "";
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";

            if(!empty($usuario) && !empty($email)){
              $error = 'ok';
              (!is_string($usuario) || !preg_match("/^[a-zA-ZÀ-ÿ0-9]{5,15}$/" , $usuario))? $error = $lang['errorUsuari'] : '';
              (!filter_var($email, FILTER_VALIDATE_EMAIL))? $error = $lang['errorEmail'] : '';

            }else{
              $error = $lang['errorEmpty'];
            }
            if($error = 'ok'){
              $usuario = saneadoreitor($usuario);
              $email = saneadoreitor($email);

              list($rows, $ok) = modeloRegistrarNuevoUsuario($usuario, $email, $conexion);
              //$ok = modeloRegistrarNuevoUsuario($usuario, $email);
              if ($ok) {

                    vistaRegistroCompletado($usuario, $email, $rows, $lang);
              } else {
                    $error = 'El registro ya se encuentra registrado';
                    vistaRegistroIncorrecto($usuario, $email);
            
              }
            }
      }
      else $error
}


if (!isset($_REQUEST['registrar'])) {
      vistaMostrarFormularioRegistro();
} else {
      actionNuevoUsuario($conexion, $langform);
}
