<?php

session_start();

if (isset($_GET['lang'])){
	if($_GET['lang']=='cast') {
		$_SESSION['idioma']='cast';
	} else if ($_GET['lang']=='cat') {
		$_SESSION['idioma']='cat';
	}

}	else if(!isset($_SESSION['idioma'])){
		$_SESSION['idioma']='cat';
}
require_once "lang/" . $_SESSION['idioma'] . ".php";

if (isset($_GET['canvi'])) {
    $params = $_SESSION['params'];

    $params = array_merge($params, $lang_feedback);
    montaViews($params, "../view/tpls/feedback.tpl");
    exit;
}

function montaViews($params, $archivo)
{
      $html = file_get_contents($archivo);
      foreach ($params as $key => $value) {
        if(is_array($value)){
          //si es un array, lo pasamos a string
          $value = implode('', $value);
        }
        $html = str_replace("{{::$key::}}", $value, $html);
      }

      echo $html;
}





