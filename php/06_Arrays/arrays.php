<?php
  function pDump($var){
    echo "<pre><code>";
    var_dump($var);
    echo "</code></pre>";
  };
/* Arrays
Un array es una variable que almacena una colección de datos/valores, bajo un unico nombre.
 */

 $pelicula = "Airbag";
 $peliculas = ['Airbag', 'Abierta hasta el amanecer','The Bad Taste'];
 $cantantes = ['Josele Santiago', 'Justin Sullivan', 'Chrissie Hynde'];

 //Array asociativo
 $personas = ['nombre' => 'Oscar',
 'apellidos' => 'Eroles',
 'web' => 'myweb.com'];

 echo $personas['apellidos'];

 //recorrer con FOR
 echo "<h1>Listadp de peliculas </h1>";
 echo "<ul>";
 for ($i = 0; $i < count($peliculas);$i++){
  echo "<li>" . $peliculas[$i] . "</li>";
 }
 echo "</ul>";


 //recorrer con Foreach

 echo "<h1>Listadp de cantantes </h1>";
 echo "<ul>";
 foreach ($cantantes as $cantante) {
  echo "<li>" . $cantante[$i] . "</li>";
 }
 echo "</ul>";

 //recorrer personas
 echo "<ul>";
 foreach ($personas as $key => $value) {
  echo "<li> Persona: $key = $value </li>";
 }
 echo "</>";
 echo "<br>";

 //Arrays multidimensionales
 $agenda =[
  'uno' => ['nombre' => 'pepe', 'apellido' => 'Pepez', 'email' => 'email@mal.com'],
  ['nombre' => 'pepon', 'email' => 'email22222222@mal.com'],
  ['nombre' => 'Juste', 'email' => 'Velmondo@mal.com'],
  'nombre' => 'solico',
  5,
 ];

 foreach($agenda as $key => $value){
  if(is_array($value)){
    foreach ($value as $indice => $valor){
      echo $indice . " - ". $valor . "<br>";
    }
  }else{
    echo $key . " - " . $value . "<br>";
  }
 }
?>