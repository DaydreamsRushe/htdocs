<?php

function pDump($param){
      echo "<pre>".var_dump($param). "</pre>";
}

function saneadoreitor($data){
    return htmlspecialchars(stripslashes(trim($data)));
}