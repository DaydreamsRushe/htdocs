<?php
require "../lang/lang.php";
require "../model/model.php";
require "../view/view.php";
require "functions.php";



function actionNuevoUsuario($conexion)
{
      if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['registrar'])) {

            $usuario = isset($_REQUEST['usuario']) ? $_REQUEST['usuario'] : "";
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


if (!isset($_REQUEST['registrar'])) {
      vistaMostrarFormularioRegistro();
} else {
      actionNuevoUsuario($conexion);
}
