<?php

function muestraNombres(){
  $result = "Oscar perolillos pepepepepepepepep";
  print($result);
}

muestraNombres();
echo "<br><hr>";

function calculadora($num1, $num2, $negrita = false){
  $suma=$num1 +$num2;
  $resta=$num1 - $num2;
  $mult= $num1 * $num2;
  $div=$num1 / $num2;

  $cadena_texto ="";

  if($negrita){
    $cadena_texto .= "<strong>";
  }

  $cadena_texto .= "Suma de $num1 y $num2 = $suma <br>";
  $cadena_texto .= "Resta de $num1 y $num2 = $resta <br>";
  $cadena_texto .= "Multiplicacion de $num1 y $num2 = $mult <br>";
  $cadena_texto .= "Division de $num1 y $num2 = $div <br>";

  if($negrita){
    $cadena_texto .= "</strong>";
  }
  $cadena_texto .= "<hr>";
  return $cadena_texto;
}

$numero1 = 10;
$numero2 = 20;
echo calculadora($numero1, $numero2, $negrita = true);

function getNombre($nombre){
  $texto = "el nombte es $nombre";
  return $texto;
}
function getApellido($apellido){
  $texto = "el apellido es $apellido";
  return $texto;
}
function setNombreApellidos($nombre, $apellidos){
  $texto = getNombre($nombre). " y " . getApellido($apellidos). "<br>";
  return print($texto);
}
setNombreApellidos("pep","Pfundote");
echo getNombre("maturbado");
echo getApellido("y tanto");

$saludo = function (){
  echo "sup";
};

$saludo();
echo "<br>";

$nom = "Pepe";
$cognoms ="Pepez";

$saludodos = function(){
  global $nom, $cognoms;
  $result ="Hola $nom $cognoms";
  return print($result);
};

echo "<br>";
$saludodos();
echo "<hr><br>";

$saludar = fn() => "Holaquease <br>";
echo $saludar();
echo "<hr><br>";

?>