<?php

function vistaMostrarFormularioCalculadora(){
  _vista_form_registro();
}


function _vista_form_registro()
{
      $params = [];
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