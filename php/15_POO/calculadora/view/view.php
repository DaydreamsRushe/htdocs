<?php
/* require "../model/model.php"; */

function vistaMostrarFormularioCalculadora($error){
  _vista_form_registro($error);
}

function vistaMostrarFeedback($operacion){
  $params=[
    'numero1' => $operacion->getNumeroUno(),
    'numero2' => $operacion->getNumeroDos(),
    'tipoop'  => $operacion->getTipo(),
    'resultado' => $operacion->operar()
  ];
  writeTpl($params, "../view/tpl/feedback.tpl");
}

function _vista_form_registro($error)
{
      $params = ['mensajeerror' => $error];
      writeTpl($params, "../view/tpl/form.tpl");
}

function writeTpl($params, $archivo){

      $html = file_get_contents($archivo); //recoje todo el contenido del fichero como texto
      foreach ($params as $key => $value) {
            $html = str_replace("{{::$key::}}", $value, $html);
      }
      echo $html;
}


?>