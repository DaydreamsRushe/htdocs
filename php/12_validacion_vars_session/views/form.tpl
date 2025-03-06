<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Validacion de formularios</title>
  </head>
  <body>
    <h1>Validar formularios en PHP</h1>
    <form method="POST" action="controller/validator.php">
      <label for="nombre">Nombre</label><br />
      <input
        type="text"
        name="nombre"
        value="<?= isset($nombre) ? $nombre : '';?>"
      /><br />

      <label for="apellidos">Apellidos</label><br />
      <input
        type="text"
        name="apellidos"
        value="<?= isset($apellidos) ? $apellidos : '';?>"
      /><br />

      <label for="edad">Edad</label><br />
      <input
        type="text"
        name="edad"
        value="<?= isset($edad) ? $edad : '';?>"
      /><br />

      <label for="email">Correo</label><br />
      <input
        type="text"
        name="email"
        value="<?= isset($email) ? $email : '';?>"
      /><br />

      <label for="pass">Contraseña</label><br />
      <input
        type="password"
        name="pass"
        value="<?= isset($pass) ? $pass : '';?>"
      /><br />

      <input type="submit" name="enviar" value="Enviar" />
    </form>
  </body>
</html>
