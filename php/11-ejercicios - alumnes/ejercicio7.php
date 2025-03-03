<?php

/* 
 Ejercicio 7. Hacer un programa que muestre todos los numeros IMPARES entre dos numeros
 * que nos lleguen por la URL($_GET)
 * localhost/php/11-ejercicios - alumnes/ejercicio7.php?num1=2&num2=4
 */


$numero1 = $_GET['num1'];
$numero2 = $_GET['num2'];

if($numero1+1 < $numero2){
  if(($numero2 - $numero1)==2 && ($numero1+1)%2 == 0) echo "Los dos numeros no tienen numeros IMPARES entre ellos";
  else{
  for($i = $numero1+1; $i< $numero2; $i++){
    if(($i % 2) != 0)echo $i. "<br>";
  }}
}else if($numero1 > $numero2+1){
  if(($numero1 - $numero2)==2 && ($numero2+1)%2 == 0) echo "Los dos numeros no tienen numeros IMPARES entre ellos";
  else{
  for($i = $numero2+1; $i< $numero1; $i++){
    if(($i % 2) != 0) echo $i. "<br>";
  }
}

}else echo "Los dos son el mismo numero o son numeros consecutivos y por lo tanto no tienen numeros entre ellos";