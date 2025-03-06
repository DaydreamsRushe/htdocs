<?php 
/*
Ejercicio 8. Hacer un programa en PHP que tenga un array con 8 numeros enteros no consecutivos ni ordenados y crear una función  que haga lo siguiente*/

//-A: Recorrerlo y mostrarlo al final del bucle imprimiendo la variable que contiene todo el recorrido
$numeros = [76,14,967,12,12,15,7,-1];
$recorrido = "[";
for($i = 0; $i < count($numeros);$i++ ){
  echo $numeros[$i]. "<br>";
  $recorrido .= "$numeros[$i],";
}
$recorrido .= "]";
echo $recorrido ."<br><hr>";
//-------------------------------------------------------------------------
//-B: Ordenarlo de menor a mayor
function pDump($var){
    echo "<pre><code>";
    var_dump($var);
    echo "</code></pre>";
  };
sort($numeros);
pDump($numeros);

//-----------------------------------------------------------------------
//-c: Mostrar su longitud

echo count($numeros)."<br><hr>";
//------------------------------------------------------------------------
//-D,E : Buscar algun elemento (buscar por el parametro que me llegue por la url) y mostrar el indice del elemento que buscamos
echo '<form class="form-inline">
<label >Escribe un elemento a buscar</label>
      <input type="number" name="numeroEntrada"/>
      <button type="submit" value="Buscar">Buscar</button>
      </form>';

if(isset($_GET['numeroEntrada'])){

  echo $_GET['numeroEntrada']."<br>";
  echo array_search($_GET['numeroEntrada'], $numeros)."<br><hr>";

}


?>
