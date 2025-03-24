<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/bootstrap/source/css/bootstrap.min.css">
  <title><?php echo $lang['title']; ?></title>
</head>
<body>
  <header>
    <nav class="navbar navbar-light bg-light justify-content-between">
      <a class="navbar-brand"><?php echo $lang['logo']; ?></a>
      <form class="form-inline">
        <label class="mr-sm-2"><?php echo $lang['cambiar_idioma']; ?></label>
        <select class="custom-select mb-2 mr-sm-2 mb-sm-0" name="lang">
          <option selected><?php echo $lang['opcion_1'] ?></option>
          <option value="cast"><?php echo $lang['opcion_2'] ?></option>
          <option value="ca"><?php echo $lang['opcion_3'] ?></option>
        </select>
        <button type="submit" class="btn btn-primary"><?php echo $lang["cambiar"] ?></button>
      </form>
    </nav>
  </header>
  <form method="POST" class="mt-3 mx-5" action=<?= validacion($lang) ? "controller/app.php": "";?>>
      <label for="usuari"><?php echo $lang['usuari']; ?></label><br />
      <input
        type="text"
        name="usuari"
        value=""
      /><br />

      <label for="email"><?php echo $lang['correu']; ?></label><br />
      <input
        type="text"
        name="email"
        value=""
      /><br />

      <input type="submit" class="mt-3 btn btn-primary" name="enviar" value="Registrar" /> 
    </form>
<?php 
 /* ^[A-ZÀ]{1}[a-zA-ZÀ-ÿ\u00f1\u00d1\s]{2,40}$ */
 if("POST" == $_SERVER['REQUEST_METHOD'] && isset($_POST['enviar'])){
  if(!empty($_POST['usuari']) && !empty($_POST['email'])){
    $error = 'ok';
    (!is_string($_POST['usuari']) || !preg_match("/^[a-zA-ZÀ-ÿ0-9]{5,15}$/" , $_POST['usuari']))? $error = $lang['errorUsuari'] : '';
    (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))? $error = $lang['errorEmail'] : '';
  }else{
    $error = $lang["errorEmpty"];
  }
  echo $error;
}
?>
  <footer class="mx-5 container-fluid">
    <a class="mt-3" href="?lang=ca">Català</a> || <a href="?lang=cast">Castellano</a>
  </footer>
  </body>
</html>
