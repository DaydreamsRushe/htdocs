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
pDump($num)
?>
