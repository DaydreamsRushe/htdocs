<?php
require_once 'conexion.php';

// Procesamos el formulario de inserción
if (isset($_REQUEST['crear'])) {
    $nom = $_REQUEST['nom'];
    $ape = $_REQUEST['ape'];

    $sql = "INSERT INTO datos_usuarios (Nombres,Apellidos) VALUES (?,?)";
    $stmt = $con->prepare($sql);
    $stmt->execute([$nom, $ape]);
    header("location:index.php");
    exit; // Importante: terminar la ejecución después del redirect
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>CRUD</title>
  <link rel="stylesheet" type="text/css" href="hoja.css">

</head>
<body>

  <?php
  //Leer o READ
  $stmt = $con->query("SELECT * FROM datos_usuarios");
  $registros = $stmt->fetchAll();

  ?>
  <h1>CRUD<span class="subtitulo"> Create Read Update Delete</span></h1>

  <table width="80%" border="1">
    <th>
      <td class="primera_fila">Id</td>
      <td class="primera_fila">Nombre</td>
      <td class="primera_fila">Apellido</td>
      <td class="sin"></td>
      <td class="sin"></td>
    </th>
    <?php
    foreach ($registros as $dato) {
      echo '
      <tr>
      <td>' . $dato['id'] . '</td>
      <td>' . $dato['Nombres'] . '</td>
      <td>' . $dato['Apellidos'] . '</td>
      <td class="bot">
      <a href="borrar.php?id=' .  $dato['id'] . '"><input type="button" name="del" id="del" value="Borrar"></a></td>
      <td class="bot"><a href="editar.php?id=' . $dato['id'] . '&nom=' . $dato['Nombres'] . '&ape=' . $dato['Apellidos'] . '"><input type="button" name="up" id="up" value="Actualizar"></a></td>
      </tr>
      ';
    }
    ?>

    <form method="POST" action="">
    <tr>
      <td></td>
      <td><input type='text' name='nom' class='centrado'></td>
      <td><input type='text' name='ape' class='centrado'></td>
      <td colspan="2" class='bot'><input type='submit' name='crear' id='crear' value='Insertar'></td>
    </tr>
  </form>
   </table>
</body>
</html>