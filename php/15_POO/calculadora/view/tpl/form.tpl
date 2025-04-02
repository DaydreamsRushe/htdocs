<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/bootstrap/source/css/bootstrap.min.css">
  <title>Calculadora</title>
</head>
<body>
  <h1>Calculadora</h1>
  <form method="POST" class="mt-3 mx-5" action="../controller/app.php">
    <label for="numero1">Numero 1</label>
    <input
        type="text"
        class=""
        name="numero1"
        value=""
      /><br />
    <label for="numero2">Numero 2</label>
    <input
        type="text"
        class=""
        name="numero2"
        value=""
      /><!-- pattern="^\d*(\.\d{0,2})?$" --><br />

      <div>
        <input type="radio" name="op" value="suma">Suma</input>
        <input type="radio" name="op" value="resta">resta</input>
        <input type="radio" name="op" value="mult">multiplicacion</input>
        <input type="radio" name="op" value="div">Division</input>
      </div>
      <input type="submit" class="mt-3 btn btn-primary" name="enviar" value="Registrar" />
  </form>
</body>
</html>