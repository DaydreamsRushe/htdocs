<?php 

//Ejemplo 1
$color = "verde";
if("rojo"==$color){
  echo "EL COLOR ES ROJO";
}else{
  echo "el color es $color";
}
echo "<br>";

//Ejemplo 2
$nombre = "Perico Perolilleros";
$ciudad = "Almeria";
$continente = "Europa";
$edad = 9;
$mayoria_edad = 18;

if($edad >= $mayoria_edad){
  echo "<h1>$nombre es  mayor de edad";
  if("Madrid"==$ciudad){
    echo "<h2> No vive en Madrid</h2>";
  }else{
    echo "<h2> No vive en Madrid</h2>";
  }
}else{
  echo "<h2>$nombre NO es mayor de edad</h2>";
}

if("Madrid"==$ciudad){
  echo "<h2>Vive en $ciudad</h2>";
}else{}
  /*...*/


//Ejemplo 3
$dia = 2;
if(1==$dia){
  echo "LUNES";
}elseif(2==$dia){
  echo "MARTES";
}elseif(3==$dia){
  echo "MIERCOLES";
}elseif(4==$dia){
  echo "JUEVES";
}elseif(5==$dia){
  echo "VIERNES";
}elseif(6==$dia){
  echo "SABADO";
}elseif(7==$dia){
  echo "DOMINGO";
}

echo "<br>";

switch($dia){
  case 1:
    echo "LUNES";
    break;
  case 2:
    echo "MARTES";
    break;
  case 3:
    echo "MIERCOLES";
    break;
  case 4:
    echo "JUEVES";
    break;
  case 5:
    echo "VIERNES";
    break;
  case 6:
    echo "SABADO";
    break;
  case 7:
    echo "DOMINGO";
    break;
}

//Ejemplo 4

$edad1 = 18;
$edad2 = 67;
$edad_oficial = 17;

if($edad_oficial >= $edad1 && $edad_oficial <= $edad2){
  echo "ESTA EN EDAD DE TRABAJAR";
}else{
  echo "NO PUEDE TRABAJAR";
}

echo "<hr>";

$pais = "Vanuato";
echo $pais == "MExico" || $pais == "Colombia" || $pais == "Costa Rica" ? "En $pais se habla Español" : "En $pais NO SE HABLA ESPAÑOL, TARUGO"

?>