<?php
  require_once "assets/libreria.php";
  require "views-vistas/header.tpl";
?>

<main>
  <h2>Esta es la pagina que gestiona nuestra información de Empresa</h2>
  <p>Diferentes contenidos php, javascript o html</p>
  <p><?= $content_nosotros ?></p>
</main>

<?php
  require 'views-vistas/footer.tpl';
?>