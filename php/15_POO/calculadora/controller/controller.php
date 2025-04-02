<?php
//llama a objetos del modelo.
//recibe los datos de la operacion
require "../view/view.php";
require "../model/model.php";

function validacion(){
  if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['registrar'])){
      error = "";
      $numero1 = is_string($_REQUEST['numero1']) && preg_match("/^\d*(\,\d{0,2})?$/", $_REQUEST['numero1'])? (float)str_replace(",",".",$_REQUEST['numero1']) :'';
      $numero2 = is_string($_REQUEST['numero2']) && preg_match("/^\d*(\,\d{0,2})?$/", $_REQUEST['numero2'])? (float)str_replace(",",".",$_REQUEST['numero2']) :'';
      if(empty($numero1)|| empty($numero2)){
        vistaMostrarFormularioCalculadora(); //volvemos a la inicial
      }else{
        if($_REQUEST['op']=="suma"){
          $operacion = new Suma($numero1, $numero2);
        }else if($_REQUEST['op']=="resta"){
          $operacion = new Resta($numero1, $numero2);
        }else if($_REQUEST['op']=="mult"){
          $operacion = new Multi($numero1, $numero2);
        }else if($_REQUEST['op']=="div"){
          $operacion = new Multi($numero1, $numero2);
        }else{
          vistaMostrarFormularioCalculadora();
        }
      }
  }
}


if (!isset($_REQUEST['registrar'])) {
  vistaMostrarFormularioCalculadora();//la aplicacion acaba de empezar y muestra el primer formulario
}else{
  validacion();//se le ha dado al boton de registrar
}

?>