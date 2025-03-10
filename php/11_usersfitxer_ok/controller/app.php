<?php
require "../model/model.php";
require "../view/view.php";
require "functions.php";



function actionNuevoUsuario()
{
      if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['registrar'])) {

            $usuario = isset($_REQUEST['usuario']) ? $_REQUEST['usuario'] : "";
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";

            $usuario = saneadoreitor($usuario);
            $email = saneadoreitor($email);


            $ok = modeloRegistrarNuevoUsuario($usuario, $email);
            if ($ok) {
             
                  vistaRegistroCompletado($usuario, $email);
                  exit;
            } else {
                  vistaRegistroIncorrecto($usuario, $email);
                  exit;
            }
      }
}


if (!isset($_REQUEST['registrar'])) {
      vistaMostrarFormularioRegistro();
} else {
      actionNuevoUsuario();
}
