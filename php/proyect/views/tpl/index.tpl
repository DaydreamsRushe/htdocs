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
              <article><a class="head-option" href=""><?php echo $lang['conocenos']; ?></a></article>
              <article>
                <a class="head-option" href=""><?php echo $lang['somos']; ?></a>
              </article>
              <article><a class="head-option" href=""><?php echo $lang['contacto']; ?></a></article>
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
              <li><a class="head-option" href=""><?php echo $lang['conocenos']; ?></a></li>
              <li><a class="head-option" href=""><?php echo $lang['somos']; ?></a></li>
              <li><a class="head-option" href=""><?php echo $lang['contacto']; ?></a></li>
          </nav>
        </div>
      </div>
    </header>
    <!-- FINAL DE CABECERA -->
     <main>
        <div class="presentation-section">
          <div></div>
          <section class="presentacion">
            <h2><?php echo $lang['presenttitle']; ?></h2>
            <h3><?php echo $lang['presentsubtitle']; ?></h3>
            <p><?php echo $lang['presenttext']; ?></p>
            <button class="btn-secondary" id="btn-cuestion"><?php echo $lang['cuestionario']; ?></button>
          </section>
          <div></div>
        </div>
        <div class="presentation-oferta">
          <section class="oferta">
            <img src="assets/img/firsttalk.png" alt="hablemos" name="hablemos"/>
            <article>
              <h2><?php echo $lang['ofertatitle']; ?></h2>
              <p><?php echo $lang['ofertatext']; ?></p>
              <button class="btn-secondary" id="btn-conocenos"><?php echo $lang['conocenos']; ?></button>
            </article>
          </section>
        </div>
     </main>
     <footer>
        <section>
          <article><a class="foot-option" href=""><?php echo $lang['conocenos']; ?></a></article>
          <article>
            <a class="foot-option" href=""><?php echo $lang['somos']; ?></a>
          </article>
          <article><a class="foot-option" href=""><?php echo $lang['contacto']; ?></a></article>
          <article><a class="foot-option"  id="btn-sesion" ><?php echo $lang['inicio']; ?></a></article>
        </section>
     </footer>
  </body>
</html>
