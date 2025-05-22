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


function indice($lang)
{
  require 'views/tpl/index.tpl';
}

function conocenos($lang)
{
    require 'views/tpl/conocenos.tpl';
}