<?php
if("POST" == $_SERVER['REQUEST_METHOD'] && isset($_POST['enviar'])){
  if(
    !empty($_POST['examen1']) &&
    !empty($_POST['examen2']) &&
    !empty($_POST['examen3']) &&
    !empty($_POST['examen4']) &&
    !empty($_POST['examen5']) 
    ){
      $error = 'ok';
    }

}

?>