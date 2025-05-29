<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="views/css/conocestyle.css" />
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
      <div class="presentation-oferta">
          <section class="oferta-first">
            <article>
              <h2>Nuestro objetivo</h2>
              <p>En SerenaLive queremos ser un punto de referencia en la vida de las personas que aspiran a crecer y ayudarlas a alcanzar su bienestar psicologico. Nuestra mision es poder ayudar a conseguir el bienestar mental de todo aquel que lo desee de forma competente.</p>
            </article>
            <img src="assets/img/objetivos.png" alt="hablemos" name="hablemos"/>
          </section>
          <section class="oferta-second">
            <img src="assets/img/tranquilidad.jpg" alt="hablemos" name="hablemos"/>
            <article>
              <h2>Un futuro mejor</h2>
              <p>Nos esforzamos para que el maximo de personas posibles tengan una oportunidad sin importar su situacion o las circumstancias. Todos podemos necesitar ayuda psicologica en algun momento, y nosotros queremos ofrecer esa oportunidad</p>
            </article>
          </section>
          <section class="oferta-third">
            <article>
              <h2>Seguridad</h2>
              <p>Nos tomamos muy en serio el trato a las personas y su bienestar, tanto en la terapia como fuera de ella. Queremos suprimir el estigma relacionado con los problemas de salud mental</p>
            </article>
            <img src="assets/img/bienestar.jpg" alt="hablemos" name="hablemos"/>
            <article>
              <h2>Profesionalidad</h2>
              <p>Nuestros profesionales cuentan con una larga experiencia en distintos campos y situaciones. Trabajamos para asegurar que todas las terapias sean de la mejor calidad para nuestros pacientes.</p>
            </article>
          </section>
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
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        document.querySelector("#btn-sesion").addEventListener("click", () => {
          document.location.href = "login.php";
        });
      });
    </script>
  </body>
</html>
