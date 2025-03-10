<?php
  require_once "./ejercicio12_A.php";
  require_once "./ejercicio12_B.php";
  require_once "./ejercicio12_C.php";

  $jueguitos = [$genero1 => $juegos1, $genero2 => $juegos2, $genero3 => $juegos3];
  
  function pDump($var){
    echo "<pre><code>";
    var_dump($var);
    echo "</code></pre>";
  };

  print_r($jueguitos);
?>