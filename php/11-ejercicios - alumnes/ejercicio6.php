<?php

/* 
 Ejercicio 6. Mostrar una tabla de HTML con las tablas de multiplicar del 1 al 10.
 */

for($i = 0; $i <=10; $i++){
  for($j = 0; $j <=10; $j++){
    echo "$i * $j = ". $i*$j ."<br>";
  }
  echo "<hr><br>";
}

?>