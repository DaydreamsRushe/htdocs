<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio13-14</title>
</head>
<body>
  <h1>Evaluacion de examenes</h1>
    <form method="POST" action="controller/validator_notas.php">
      <label for="examen1">Examen 1 - Nota:</label><br />
      <input
        type="number"
        name="examen1"
        value="<?= isset($examen1) ? $examen1 : '';?>"
      /><br />

      <label for="examen2">Examen 2 - Nota:</label><br />
      <input
        type="number"
        name="examen2"
        value="<?= isset($examen2) ? $examen2 : '';?>"
      /><br />

      <label for="examen3">Examen 3 - Nota:</label><br />
      <input
        type="number"
        name="examen3"
        value="<?= isset($examen3) ? $examen3 : '';?>"
      /><br />

      <label for="examen4">Examen 4 - Nota:</label><br />
      <input
        type="number"
        name="examen4"
        value="<?= isset($examen4) ? $examen4 : '';?>"
      /><br />

      <label for="examen5">Examen 5 - Nota:</label><br />
      <input
        type="number"
        name="examen5"
        value="<?= isset($examen5) ? $examen5 : '';?>"
      /><br />

      <input type="submit" name="enviar" value="Enviar" />
    </form>
</body>
</html>