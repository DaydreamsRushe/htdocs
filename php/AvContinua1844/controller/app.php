<?php
require "../model/model.php";
require "../assets/functions.php";
require "../assets/gestor.php";
require "../views/view.php";


function actionNuevoUsuario($conexion)
{
      if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['enviar'])) {

            $usuario = isset($_REQUEST['usuari']) ? $_REQUEST['usuari'] : "";
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";

            $usuario = saneadoreitor($usuario);
            $email = saneadoreitor($email);

            list($rows, $ok) = modeloRegistrarNuevoUsuario($usuario, $email, $conexion);
            //$ok = modeloRegistrarNuevoUsuario($usuario, $email);
            if ($ok) {
             
                  vistaRegistroCompletado($usuario, $email, $rows);
            } else {
                  vistaRegistroIncorrecto($usuario, $email);
          
            }
      }
}


if (!isset($_REQUEST['enviar'])) 
{
  vistaMostrarFormularioRegistro();
} else {
  actionNuevoUsuario($conexion);
}
