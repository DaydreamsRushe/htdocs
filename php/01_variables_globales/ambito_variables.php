<?php 
/* Variables globales: Son las que se declaran fuera de una funcion y estan disponibles tanto fuera como dentro usando la palabra global o la palabra superglobal $GLOBALS['nombrevariable'].

Variables locales: Son las que se definen dentro de una funcion y no pueden ser usadas fuera de la función. Estan disponibles dentro de la funcion a no ser que hagamos un return y se muestren como resultado devuelto por la funcion.*/

$fo2;
$foo = "Contenido de ejemplo";
function test(){
  global $fo2;
  $foo="variable local";

  echo "{$foo} en el ambito global: {$GLOBALS["foo"]}<br>";
  echo '$foo en el ambito simple:'. $foo. '<br>';
  echo "$fo2 en el ambito global: $fo2 <br>";
}

$fo2="Contenido de ejemplo con global";
test();

$frase = "Ni tan genio ni tan mediocre";
$frasedos = "NNNNNNno";
echo $frase. " - ". $frasedos;

function pruebaAmbito(){
  global $frase;
  global $frasedos;

  echo "<h1>". $frase ." - " . $frasedos . "</h1>";
  echo "<h1>" . $GLOBALS['frase'] . " - " . $GLOBALS['frasedos'] . "<h1>";
  $year = 2023;
  print $year;
}

echo "<br/>";
echo pruebaAmbito();
echo "<br/>";

function pAmbitoParametros($frase, $frasedos){
  echo "<h1>" . $frase . " - " . $frasedos . " - ";
}
echo "<br>";
echo pAmbitoParametros($frase, $frasedos);
echo "<br>";

$nombre = "Perico Parolillos";
$edad = 19;
$mayoria_edad = 18;

if($edad >= $mayoria_edad){
  echo "<h2>$nombre es mayor de edad</h2>";
}else{
  echo "<h2>$nombre es menor de edad</h2>";
}
?> 