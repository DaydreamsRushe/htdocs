<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
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
  <main class="continer-fluid">
    <?php menu($lang);?>
    <div class="row">
      <div class="col-8">
        <h3><?= $lang['descripcion']; ?></h3>
      </div>
    </div>
  </main>