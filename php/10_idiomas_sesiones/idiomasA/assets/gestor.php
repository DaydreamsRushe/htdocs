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


function cabecera($lang)
{
  require 'vistas/cabecera.tpl';
}

function menu($lang)
{
  echo '<a href="index.php">' . $lang['m1'] . '</a>  ||  <a href="producto.php">' . $lang['m2'] . '</a>';
}

function principal ($lang)
{
  require "vistas/principal.tpl";
}

function footer($lang){
  require "vistas/footer.tpl";
}

function footer2($lang)
{
  require "vistas/footer2.tpl";
}
?>

