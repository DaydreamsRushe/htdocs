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

function conoce($lang)
{
  require 'views/tpl/conoce.tpl';
}

function contacto($lang)
{
  require 'views/tpl/contacto.tpl';
}