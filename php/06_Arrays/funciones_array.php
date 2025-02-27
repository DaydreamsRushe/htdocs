<?php
  function pDump($var){
    echo "<pre><code>";
    var_dump($var);
    echo "</code></pre>";
  };

  $cantantes = ['Josele Santiago', 'Justin Sullivan', 'Chrissie Hynde'];
  $numeros = [1,2,3,4,5];
  pDump($numeros);

  //Ordenar

  sort($numeros);
  pDump($numeros);

  pDump($cantantes);

  sort($cantantes);
  pDump($cantantes);

  //Añadir elementos array
  $cantantes[] = "Natos";
  pDump($cantantes);
  array_push($cantantes, "wawooo");
  pDump($cantantes);
  $cantantes[] = "alegria";
  pDump($cantantes);

  //eliminar elementos
  array_pop($cantantes);
  pDump($cantantes);

  unset($cantantes[2]);
  pDump($cantantes);

  //aleatorio
  $indice = array_rand($cantantes);
  echo $cantantes[$indice];

  //Dar la vuelta
  pDump(array_reverse($cantantes));

  //Clonar un array
  $original = [1,2,3,4];
  $copy = array_merge([], $original);
  pDump($original);
  pDump($copy);
?>