<?php

/* 
 Ejercicio 5. Hacer un programa que muestre todos los numeros entre dos numeros
 * que nos lleguen por la URL($_GET)
 * localhost/php/11-ejercicios - alumnes/ejercicio5.php?num1=2&num2=4
 */

 $numero1 = $_GET['num1'];
 $numero2 = $_GET['num2'];
if($numero1+1 < $numero2){
  for($i = $numero1+1; $i< $numero2; $i++){
    echo $i. "<br>";
  }
}else if($numero1 > $numero2+1){
  for($i = $numero2+1; $i< $numero1; $i++){
    echo $i. "<br>";
  }

}else echo "Los dos son el mismo numero o son numeros consecutivos";
 
?>

