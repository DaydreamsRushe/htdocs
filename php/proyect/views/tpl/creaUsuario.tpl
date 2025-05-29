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
    <link rel="stylesheet" href="views/css/createstyle.css" />
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
    <main class="container">
      <div class="content-wrapper">
        <div class="form-container">
          <h2><?php echo $lang['creacion']; ?></h2>
          <form id="formUsuario" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="nombre"><?php echo $lang['nombre']; ?>:</label>
              <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Nombre y Apellidos"
              />
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" placeholder="email" />
            </div>
            <div class="form-group">
              <label for="password"><?php echo $lang['contrasenya']; ?>:</label>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Contraseña"
              />
            </div>
            <div class="form-group">
              <label for="tipo_usuario"><?php echo $lang['tipousuario']; ?>:</label>
              <select id="tipo_usuario" name="tipo_usuario">
                <option value="2"><?php echo $lang['profesional']; ?></option>
                <option value="1"><?php echo $lang['paciente']; ?></option>
              </select>
            </div>
            <div class="form-group">
              <label for="foto">Foto de Perfil:</label>
              <input type="file" id="foto" name="foto" accept="image/*" />
            </div>
            <div class="form-actions">
              <button type="submit" id="btnInsertar"><?php echo $lang['crearusuari']; ?></button>
              <button type="button" id="btnBorrar"><?php echo $lang['restablecer']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </main>
    <footer>
        <section>
          <article><a class="foot-option" href="conoce.php"><?php echo $lang['conocenos']; ?></a></article>
          <article>
            <a class="foot-option" href="psicologos.php"><?php echo $lang['somos']; ?></a>
          </article>
          <article><a class="foot-option" href="contacto.php"><?php echo $lang['contacto']; ?></a></article>
          <article><a class="foot-option"  id="btn-sesion" href="login.php"><?php echo $lang['inicio']; ?></a></article>
        </section>
     </footer>
     <script src="views/js/crear.js"></script>
  </body>
</html>