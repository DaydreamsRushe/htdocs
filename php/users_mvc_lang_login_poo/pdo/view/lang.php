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

// Manejo de cambio de idioma
if (isset($_GET['lang'])) {
	// Si hay parámetro canvi, mostramos feedback.tpl
	if (isset($_GET['canvi'])) {
		$params = $_SESSION['params'] ?? [];
		$params = array_merge($params, $lang_feedback);
		montaViews($params, "../view/tpls/feedback.tpl");
	} 
	// Si no hay canvi, redirigimos a la página actual
	else {
		$current_page = $_SERVER['HTTP_REFERER'] ?? 'index.php';
		header("Location: " . $current_page);
	}
	exit();
}

function montaViews($params, $archivo)
{
      $html = file_get_contents($archivo);
      foreach ($params as $key => $value) {
    if (is_array($value)) {
      // Si es un array, lo convertimos a string
      $value = implode('', $value);
    }

            $html = str_replace("{{::$key::}}", $value, $html);
      }

      echo $html;
} 



