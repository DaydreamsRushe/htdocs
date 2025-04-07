<?php
require_once 'conexion.php';
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>editar</title>
  <link rel="stylesheet" type="text/css" href="hoja.css">
</head>

<body>

  <h1>ACTUALIZAR</h1>
  <p>
    <?php

    if (isset($_REQUEST['bot_actualizar'])) {
      $id = $_REQUEST['id'];
      $nom = $_REQUEST['nom'];
      $ape = $_REQUEST['ape'];
      $sql = "UPDATE datos_usuarios SET Nombres = ? , Apellidos = ? WHERE ID = ?";
      $stmt = $con->prepare($sql);
      $stmt->execute([$nom, $ape, $id]);
      header('location:index.php');
    }
    ?>

  </p>
  <form name="form1" method="post" action="">
    <table width="25%">
      <tr>
        <td></td>
        <td><label for="id"></label>
          <input type="hidden" name="id" id="id" value="<?= $_REQUEST['id']; ?>">
        </td>
      </tr>
      <tr>
        <td>Nombre</td>
        <td><label for="nom"></label>
          <input type="text" name="nom" id="nom" value="<?= $_REQUEST['nom']; ?>">
        </td>
      </tr>
      <tr>
        <td>Apellido</td>
        <td><label for="ape"></label>
          <input type="text" name="ape" id="ape" value="<?= $_REQUEST['ape']; ?>">
        </td>
      </tr>
      <tr>
        <td collspan="2"><input type="submit" name="bot_actualizar" id="bot_actualizar" value="Actualizar"></td>
      </tr>
    </table>
  </form>
</body>
</html>