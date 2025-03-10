<?php

/* 
Ejercicio 4. Recoger dos numeros por la url(Parametros GET) y hacer todas las 
 * operaciones basicas de una calculadora(suma, resta, multiplicaion y division)
 * de esos dos numeros.
 * Se puede probar con: localhost/php/11-ejercicios - alumnes/ejercicio4.php?num1=2&num2=4
 */

 $numero1 = $_GET['num1'];
 $numero2 = $_GET['num2'];

 echo "$numero1 + $numero2 = ". $numero1+$numero2 ."<br>
 $numero1 - $numero2 = ".$numero1-$numero2."<br>
 $numero1 * $numero2 = ".$numero1*$numero2."<br>
 $numero1 / $numero2 = ".$numero1/$numero2."<br>"

?>