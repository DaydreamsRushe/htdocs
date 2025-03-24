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
<footer class="container-fluid">
    <a class="mt-3" href="?lang=ca">Català</a> || <a href="?lang=cast">Castellano</a>
  </footer>
  </body>
</html>