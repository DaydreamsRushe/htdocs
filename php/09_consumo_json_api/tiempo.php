<?php
//(error_reporting(E_ERROR);
//Notificar E_NOTICE tambien puede ser bueno (para informar de variables no inicializadas o capturar errores en nombres de variables)

//Desactivar toda notificación de error
//error_reporting(0)

//Notificar solamente errores de ejecución
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

//Notificar E_NOTICE tambien puede ser bueno ( para informar de variables no inicializadas o capturar errores en nombres de variables...)
//error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

//notificar todos lo errores excepto E_NOTICE
/* Este es el valor predeterminado establecido en php.ini
error_reporting (E_ALL ^ E_NOTICE);


Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);

Notificar todos los errores de PHP
error_reporting(-1);

Lo mismo qu error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

header("Content-type:text/html;charset=\"utf-8\"");*/
//error_reporting(E_ALL ^ E_NOTICE);

function pDump($var){
  echo "<pre>";
  var_dump($var);
  echo "</pre>";
}

$prevision = "";
$error = "";
$apiCode = "044f6f194d9020402735e93570260169";
if($_SERVER["REQUEST_METHOD"]=="GET" && !empty($_GET['ciudad'])){
  $ciudad = $_GET["ciudad"];
  $ciudad = isset($ciudad) ? $ciudad : "";

  $urlContents = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=". $ciudad . "&units=metric&appid=".$apiCode);

  if(!$urlContents){
    $error = "No hemos encontrado la ciudad";
  }else{
    $array = json_decode($urlContents, true);
    pDump($array);

    $prevision = "El tiempo en  " . $ciudad . " es actualmente '" . $array["weather"][0]['description'] . "'";
    $temperaturaEnCelcius = $array['main']['temp'];
    $prevision .= ". La temperatura es " . intval($temperaturaEnCelcius) . "&deg;C";
    $tempMin = $array['main']['temp_min']; 
    $tempMax = $array['main']['temp_max'];
    $prevision .= " oscilando entre " . intval($tempMin) . "&deg;C de minima y " . intval($tempMax) . "&deg;C de maxima.";
  }
}

?>

