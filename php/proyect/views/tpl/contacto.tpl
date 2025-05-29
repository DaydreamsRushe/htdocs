<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="views/css/contactstyle.css" />
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
        <div class="general-data">
            <h1>Contacto</h1>
            <section>
                <article>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2992.037957512827!2d2.1314790765499123!3d41.41669469417593!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4981b5fdca4b1%3A0x35e8d1d280af19bd!2sCentre%20d&#39;Innovaci%C3%B3%20i%20Formaci%C3%B3%20Ocupacional%20(CIFO)%20de%20Barcelona%20La%20Violeta!5e0!3m2!1sen!2ses!4v1748457121687!5m2!1sen!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </article>
                <article>
                    <h4>Telefono: </h4><span>+34 555 89 62 11</span>
                    <h4>Email: </h4><span>jlop9810@gmail.com</span>
                    <p>Plaça del Comte de Sert, 25, Sarrià-Sant Gervasi, 08035 Barcelona</p>
                </article>
            </section>
      </div>
      <div class="mensaje-ayuda">
        <h2>¿Necesitas mas ayuda con algo?</h2>
        <p>Contacta con nuestro equipo de ayuda y te responderemos lo antes posible.</p>
            <form action="mailto:jlop9810@gmail.com" method="post" enctype="text/plain">
                <label for="fname" style="margin-top:10px;">Nombre</label>
                <input type="text" id="fname" name="firstname" placeholder="Tu nombre..">
                <label for="lname">Correo electrónico</label>
                <input type="text" id="lname" name="lastname" placeholder="Tu correo..">
                <label for="subject">Asunto</label>
                <textarea id="subject" name="subject" placeholder="Escribe algo.." style="height:200px"></textarea>
                <input class="btn-primary" type="reset" value="Borrar" style="margin-bottom:10px;">
                <input class="btn-primary" type="submit" value="Solicitar información" style="margin-bottom:10px;">
            </form>
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