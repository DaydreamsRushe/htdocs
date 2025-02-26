<?php

function pDump($variable){
  echo "<pre>";
  var_dump($variable);
  echo "</pre>";
}

echo date('d-m-Y');
echo "<br>";
echo date('Y-m-d');
echo "<br>";
echo time();
echo "<br>";
echo "raiz quadrara de 10 " . sqrt(10);
echo "<br>";
echo "raiz cuadrada de 10 " . number_format(sqrt(10),2);

echo "<br>";
echo "numero aleatorio entre 10 y 40: " . rand(10, 40);

echo "<br>";
echo "numero piiiiii: " . pi();

echo "<br>";
echo "numero piiiiii: " . number_format(pi(),2);

echo "<br>";
echo "redondear: " . round(7.84345325,2);

$valor = 100.76543;
echo number_format($valor, 4);
echo number_format($valor, 3);
echo number_format($valor, 2);

$nombre="PACO";

echo "<br>";
if(is_string($nombre)){echo "la variable es un string";} 
if(!is_float($nombre)){echo "la variable no es un float";} 
if(!is_numeric($nombre)){echo "la variable no es un numero";} 
if(isset($nombre)){echo "la variable esta definida";} 

echo "<br>";
$frase = "              mi contenido          ";
pDump($frase);

$year = 2024;
echo var_dump($year);
unset($year);//elimina la variable

$texto = "                 hai                ";
if (empty(trim($texto))){
  echo "la variable texto esta vacia";
}else{
  echo "la variable texto tiene contenido";
}

echo "<br>";

$cadena = "12345";
echo strlen($cadena);
echo "<br>";

$frase = "La vida es bella";
echo strpos($frase, "a");//primera posicion en el string del caracter
echo "<br>";

$frase = str_replace("vida", "moto", $frase);
echo $frase;
echo "<br>";

echo strtoupper($frase);
echo "<br>";
echo strtolower($frase);
echo "<br>";

$data1 = "            \tEste texto prueba\t \.   ";
$data2 = "     \r \t pero me ca-   ";
echo $data1 . "<br>";
echo $data2 . "<br>";
$texto = "      hh      ";
$trimmed1 = trim($data1);
$trimmed2 = trim($data2);
echo $trimmed1 . " y " . $trimmed2;


?>