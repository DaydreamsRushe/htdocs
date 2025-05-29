<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="views/css/indexstyle.css" />
    <title><?php echo $lang['title']; ?></title>
  </head>
  <body>
    <header>
      <div class="navbar">
        <div class="head-container">
          <a class="brand" href="index.php">SerenaLive</a>
          <nav class="head-menu">
            <section>
              <article><a class="head-option" href="conoce.php"><?php echo $lang['conocenos']; ?></a></article>
              <article>
                <a class="head-option" href="psicologos.php"><?php echo $lang['somos']; ?></a>
              </article>
              <article><a class="head-option" href="contacto.php"><?php echo $lang['contacto']; ?></a></article>
            </section>
            <section class="form-inline">
              <div name="lang">
                <a href="?lang=cast">es</a> || <a href="?lang=ca">cat</a>
              </div>
              <button type="submit" class="btn-primary" id="btn-sesion">
                <?php echo $lang['inicio']; ?>
              </button>
            </section>
          </nav>
          <nav class="menu-colapsable">
            <label class="show-menu" for="show-menu">&equiv;</label>
            <input type="checkbox" id="show-menu" />
            <ul id="menu">
              <button class="btn btn-primary" id="btn-sesion">
                <?php echo $lang['inicio']; ?>
              </button>
              <li><a class="head-option" href="conoce.php"><?php echo $lang['conocenos']; ?></a></li>
              <li><a class="head-option" href="psicologos.php"><?php echo $lang['somos']; ?></a></li>
              <li><a class="head-option" href="contacto.php"><?php echo $lang['contacto']; ?></a></li>
          </nav>
        </div>
      </div>
    </header>
    <!-- FINAL DE CABECERA -->
     <main>
      <div class="table-container">
          <h2><?php echo $lang['titulolista']; ?></h2>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Foto</th>
                <th><?php echo $lang['nombre']; ?></th>
                <th>Email</th>
                <th><?php echo $lang['especialidad']; ?></th>
              </tr>
            </thead>
            <tbody id="tablaDatos">
            </tbody>
          </table>
        </div>
     </main>
     <footer>
        <section>
          <article><a class="foot-option" href="conoce.php"><?php echo $lang['conocenos']; ?></a></article>
          <article>
            <a class="foot-option" href="psicologos.php"><?php echo $lang['somos']; ?></a>
          </article>
          <article><a class="foot-option" href="contacto.php"><?php echo $lang['contacto']; ?></a></article>
          <article><a class="foot-option"  id="btn-sesion"  href="login.php"><?php echo $lang['inicio']; ?></a></article>
        </section>
     </footer>
     <script src="views/js/psicologos.js"></script>
  </body>
</html>
