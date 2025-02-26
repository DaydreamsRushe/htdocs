<?php

function pDump($var){
  echo "<pre>";
  var_dump($var);
  echo "</pre>";
}

$resultado = 0;
for ($i = 0; $i <= 10;$i++){
  $resultado = $resultado + $i;
  print("$resultado <br/>");
}
pDump($resultado);
echo "<h1>El resultado final es: $resultado</h1>";



?>

<form action="" method="get">
 <label for="numero">Introduce un numero</label>
 <input type="number" name="numero"/>
 <input type="submit" value="enviar"/>
</form>
 
<?php
if(isset($_GET["numero"]) && is_numeric($_GET["numero"])){
  $numero = $_GET["numero"];
}else{
  $numero = 1;
}

$num = "";
for($contador =0;$contador <=10;$contador++){
  $num .= "$numero x $contador = ". ($numero * $contador) . "<br/>";
}
pDump($num);
echo "<hr>";
$marcas_motos = ["Honda","Yamaha","Suzuki","kawasaki","Ducati"];

echo $marcas_motos[4]. "<br>";
echo "$marcas_motos[2]<br>";

foreach ($marcas_motos as $value){
  echo "$value<br>";
}

echo "<hr>";


foreach($marcas_motos as $key => $value){
  echo ($key + 1) . ": $value<br>";
}

$marcas_motos_asoc = ["Honda" => "Vmax","Yamaha"=>"Rd250","Suzuki"=>"S500","kawasaki"=>"Kamikaze","Ducati"=>"Scarver500"];
echo "<hr>";
foreach($marcas_motos_asoc as $indice => $value){
  echo $indice . ": $value<br>";
}
?>
