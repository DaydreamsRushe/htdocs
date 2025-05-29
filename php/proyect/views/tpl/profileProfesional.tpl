<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="views/css/profile.css" />
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
              <button type="submit" class="btn-primary" id="btn-cerrar">
                <?php echo $lang['cerrar']; ?>
              </button>
            </section>
          </nav>
          <nav class="menu-colapsable">
            <label class="show-menu" for="show-menu">&equiv;</label>
            <input type="checkbox" id="show-menu" />
            <ul id="menu">
              <button class="btn btn-primary" id="btn-cerrar">
                <?php echo $lang['cerrar']; ?>
              </button>
              <li><a class="head-option" href="conoce.php"><?php echo $lang['conocenos']; ?></a></li>
              <li><a class="head-option" href="psicologos.php"><?php echo $lang['somos']; ?></a></li>
              <li><a class="head-option" href="contacto.php"><?php echo $lang['contacto']; ?></a></li>
          </nav>
        </div>
      </div>
    </header>
    <main class="container">
      <section class="personal-data" id="personal-data">
        <div class="form-container" id="personal-container">
        </div>
      </section>
      <section id="client-list">
        <div class="form-container">
          <h3>Lista de pacientes asignados</h3>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Diagnostico</th>
                <th>Medicacion</th>
              </tr>
            </thead>
            <tbody id="tablaClient"></tbody>
          </table>
        </div>
      </section>
    </main>
    <footer>
        <section>
          <article><a class="foot-option" href="conoce.php"><?php echo $lang['conocenos']; ?></a></article>
          <article>
            <a class="foot-option" href="psicologos.php"><?php echo $lang['somos']; ?></a>
          </article>
          <article><a class="foot-option" href="contacto.php"><?php echo $lang['contacto']; ?></a></article>
        </section>
     </footer>
     <script src="views/js/profileProfesional.js"></script>
  </body>
</html>