<?php
session_start();

if(isset($_GET['lang'])){

  if("cast" == $_GET['lang']){
    $_SESSION['idioma'] = 'cast';
  }elseif("ca" == $_GET['lang']){
    $_SESSION['idioma'] = "ca";
  }

}elseif(!isset($_SESSION['idioma'])){
  $_SESSION['idioma'] = "ca";
}

require "lang/" .$_SESSION['idioma'] . ".php";

function validacion($lang)
{
  if("POST" == $_SERVER['REQUEST_METHOD'] && isset($_POST['enviar'])){
    if(!empty($_POST['usuari']) && !empty($_POST['email'])){
      $error = 'ok';
      (!is_string($_POST['usuari']) || !preg_match("/^[a-zA-ZÀ-ÿ0-9]{5,15}$/" , $_POST['usuari']))? $error = $lang['errorUsuari'] : '';
      (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))? $error = $lang['errorEmail'] : '';

    }else{
      $error = $lang['errorEmpty'];
    }
    return $error;
  }
}

?>