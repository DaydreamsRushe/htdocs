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

// Redirigir a la página anterior manteniendo los parámetros
if (isset($_GET['lang'])) {
	$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../controller/app.php';
	header("Location: " . $referer);
	exit;
}

function montaViews($params, $archivo)
{
	$html = file_get_contents($archivo);
	foreach ($params as $key => $value) {
		if (is_array($value)) {
	
			$value = implode('', $value);
		}
		$html = str_replace("{{::$key::}}", $value, $html);
	}
	echo $html;
} 





