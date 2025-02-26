<?php
$primera_var = "String o literal";
$primer_numero = 50;
$otro_numero = 50.32;
$numero_o_no = "50";

$verdadero_o_no = true;
$falso_o_no = false;

$nombre = "Pepe";
print($primera_var);
echo "<br/>";
echo $primer_numero;
echo "<br/>";

echo $verdadero_o_no;
echo "<br/>";
echo $falso_o_no;

$parrafada = '<h1 style="font-size:30px; font-family:Arial">Ejemplo</h1><p>Donde se prueba la generacion de la pagina desde PHP. Para corregir el problema de los saltos de linea, podemos poner retornos al final de la linea.
<br/>Hemos cambiado la linea<br/>Si queremos bajar a la linea siguiente,<strong>'.$nombre.'</strong> lo hacemoscon un &lt;br/&gt; <br><strong><em>tag</em></strong> de tipo: <code>&lt;br/&gt;</code><code>&lt;br/&gt;</code>...<br/><br/>Observa<br/>como<br/>se<br/>hace. Y fijate que podemos utilizar también texto en múltiples lineas en el codigo PHP, además de incluir tantos <strong><em>tags</em></strong> como deseemos.</p>';

echo $parrafada;

const NOMBRECONSTANTE = "Pepiño";
echo NOMBRECONSTANTE;
$html ="<br/> en HTML.";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Primer documento en Php y HTML</title>
  <style>
    p{
      color:red;
      font-family: Arial, Helvetica, sans-serif;
    }
    pre{
      border: 1px solid black;
      padding: 10px;
      margin: 10px;
      background-color: #EEE;
    }
  </style>
</head>
<body>
  <h1>Introducción a PhP embebido<?php echo $html;?></h1>
  <h2>Introducción a PhP embebido<?= $html;?></h2>
  <?= $primera_var."<br/>" . $primera_var . " - " . $primer_numero . " - ". $otro_numero . " - " . $numero_o_no . " - " . $verdadero_o_no . " - " . $falso_o_no . "<br/>";?>
  <?= "$primera_var <br/> $primera_var  -  $primer_numero  - $otro_numero  -  $numero_o_no  -  $verdadero_o_no  -  $falso_o_no <br/>";
  echo gettype($primer_numero) . "<br>";
  echo gettype($otro_numero) . "<br>";
  echo gettype($numero_o_no) . "<br>";
  echo gettype($verdadero_o_no) . "<br>";
  echo gettype($falso_o_no) . "<br>";

  echo print_r($primera_var) . "<br>";
  echo var_dump($primera_var) . "<br>";

  $nom = "Pepon";
  define('NOMBRE', $nom);
  define('APELLIDO', "Perolillos");
  const OTRACONST = "Peroles";

  echo '<p>' . NOMBRE .' '. APELLIDO . ' y '. OTRACONST. '</p>';
  ?>
  <pre>
    <code>
      <?php 
      $a="Hola";
       echo "<br> 1-", $a ,"<br>","2-$a = Hola<br>", '3-$a = "Hola"<br>', "4-\$a= 'Hola'<br>", "5-\$a = \"Hola\"<br>";
       echo "<hr>" ?> 
    </code>
  </pre>
</body>
</html>