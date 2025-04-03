<?php
//llama a objetos del modelo.
//recibe los datos de la operacion
require "../model/model.php";
require "../view/view.php";

function validacion(){
  if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['registrar'])){
      $error = ""; //no se usa por ahora
      $numero1 = is_string($_REQUEST['numero1']) && preg_match("/^\d*(\,\d{0,2})?$/", $_REQUEST['numero1'])? (float)str_replace(",",".",$_REQUEST['numero1']) :'';
      $numero2 = is_string($_REQUEST['numero2']) && preg_match("/^\d*(\,\d{0,2})?$/", $_REQUEST['numero2'])? (float)str_replace(",",".",$_REQUEST['numero2']) :'';
      if(empty($numero1) || empty($numero2)){
        vistaMostrarFormularioCalculadora('variables incorrectas');//volvemos a la inicial
        exit; 
      }else{
        if($_REQUEST['op']=="suma" || $_REQUEST['op']=="resta" || $_REQUEST['op']=="mult" || $_REQUEST['op']=="div"){
          $operacion = new Operacion($numero1, $numero2, $_REQUEST['op']);
          echo var_dump($numero1 + $numero2);
          echo var_dump($_REQUEST['op']);
        }else{
          vistaMostrarFormularioCalculadora('operacion incorrecta');
          exit;
        }
        $_SESSION['operacion'] = $operacion;
        vistaMostrarFeedback($operacion);
      }
  }
  
}


if (!isset($_REQUEST['registrar'])) {
  vistaMostrarFormularioCalculadora('');//la aplicacion acaba de empezar y muestra el primer formulario
}else{
  validacion();//se le ha dado al boton de registrar
}

?>