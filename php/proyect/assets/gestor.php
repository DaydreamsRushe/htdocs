<?php 

/* En nuestra sesión tendremos un lenguaje definido (catalan o castellano) para traducir todos los textos de las paginas de la aplicación */
session_start();

/* Cuando seleccionamos una lengua en la pagina, esta cambiara a la lengua de nuestra eleccion */
if(isset($_GET['lang'])){

  if("cast" == $_GET['lang']){
    $_SESSION['idioma'] = 'cast';
  }elseif("ca" == $_GET['lang']){
    $_SESSION['idioma'] = "ca";
  }

  /* En el caso de que no se escojiera ninguna, se pone a catalan por defecto */
}elseif(!isset($_SESSION['idioma'])){
  $_SESSION['idioma'] = "ca";
}

require "lang/" .$_SESSION['idioma'] . ".php";

/* Definicion de las funciones que mostraran las diferentes paginas, asociandolas a una variable de lengua */
function indice($lang)
{
  require 'views/tpl/index.tpl';
}

function psicologos($lang)
{
    require 'views/tpl/psicologos.tpl';
}

function login($lang)
{
  require 'views/tpl/login.tpl';
}

function creaUsuario($lang)
{
  require 'views/tpl/creaUsuario.tpl';
}

function profileProfesional($lang)
{
  require 'views/tpl/profileProfesional.tpl';
}

function profileClient($lang)
{
  require 'views/tpl/profileClient.tpl';
}