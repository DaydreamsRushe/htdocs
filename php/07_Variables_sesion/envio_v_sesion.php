<?php
function volver(){
  echo "SE SIENTE, TE QUERIAS COLAR"
  header('Location: crea_sesiones.php');
}

if(!isset($_GET['enviar'])){
  volver();
}

if((isset($_GET['nombre']) && empty($_GET['nombre'])) || (isset($_GET['mail']) && empty($_GET['mail']))){
  volver();
  exit();
}else{
  $nombre = $_GET['nombre'];
  $mail = $_GET['mail'];

  $myArray = ['nombre' => $_GET['nombre'], 'mail' => $_GET['mail']];

  foreach ($myArray as $key => $value) {
    echo "<li> $key = $value </li>";
  }
  session_start();

  setcookie("nombre",$nombre, time()+ (60*60*24*365));
  $_SESSION['nombre']=$nombre;
  $_SESSION['mail']=$mail;
  header("refresh:10;url=verifica_sesion.php");

}

if(!isset($_SESSION['nombre']) || !isset($_SESSION))



?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificacion sesiones</title>
</head>
<body>
  <h1>Datos recibidos</h1>
  <p>Nombre: <?= $_SESSION['nombre']; ?></p>
  <p>Correo: <?= $_SESSION['mail']; ?></p>
  <?php session_destroy(); ?>

  <p>
    <a href="crea_sesiones.php">Volver al formulario</a>
  </p>

</body>
</html>