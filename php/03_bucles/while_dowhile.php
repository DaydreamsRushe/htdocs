<?php
/* while(condition){
  bloque de instrucciones
} */
$numero = 0;
while($numero <= 10){
  echo $numero;
  if(10 != $numero){
    echo ", ";
  }
  $numero++;
}
echo "<hr>";
?>

<!-- recibimos el valor por get -->
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
echo "<h2>Tabla de multiplicar del numero $numero</h2>";
$cont = 0;
while($cont <= 10){
  echo "$numero x $cont = " . ($numero * $cont). "<br>";
  $cont++;
}
echo "<hr>";

$edad =17;
$contador = 1;
$result = "";

while($edad < 18 && $contador <= 5){
  $result = "NO TIENES ACCESO AL LOCAL PRIVADO edad = $edad <br>";
  $contador++;
}
echo $result;
echo "<hr/>";

// dowhile
do{
echo "NO TIENES ACCESO edad=$edad y el contador vale $contador <br/>";
} while($edad < 18 && $contador <=5);
 ?>