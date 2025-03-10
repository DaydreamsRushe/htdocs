<?php
/*
function vistaRegistroCompletado($usuario, $email)
{
?>
<!DOCTYPE html>
<html lang="es">

<head>
      <meta charset="UTF-8">
      <title>Document</title>
</head>

<body>
      <h3>Gracias por registrarse. Dispone del usuario <?php echo $usuario; ?>.</h3>
      <p>Recibirá un correo en la siguiente dirección : <?php echo $email; ?> </p>

</body>

</html>
<?php
}
*/

function vistaRegistroCompletado($usuario, $email)
{
      $div = "<div>";
      if(!empty($rows)){
        foreach ($rows as $value) {
          $div .= "<p>(" . $value['id'] . ") - " . $value['usuario'] . " : " . $value['email'] . "</p>";
        }
        $div .= "</div>"
      }
      $params = [
            "usuario" => $usuario,
            "email" => $email,
            "div" => $div,
      ];
      mostrarTpls($params, "../view/tpls/feedback.tpl");
}

function vistaRegistroIncorrecto($usuario, $email)
{
      _vista_form_registro($usuario, $email, false);
}

function vistaMostrarFormularioRegistro()
{
      _vista_form_registro("", "", true);
}
/* 
function _vista_form_registro($usuario, $email, $primera_vez)
{
?>
<!DOCTYPE html>
<html lang="es">

<head>
      <meta charset="UTF-8">
      <title>Users fichero</title>
      <style type="text/css">
      .error {
            border: 2px solid red;
      }
      </style>

</head>

<body>
      <form method="post" action="../controller/app.php">
            Usuario: <br><input type="text" class="<?php echo !$primera_vez ? 'error' : '' ?>" name="usuario"
                  value="<?php echo $usuario; ?>" /><br><br>
            Email: <br><input type="text" class="<?php echo !$primera_vez ? 'error' : '' ?>" name="email"
                  value="<?php echo $email; ?>" /><br><br>
            <input type="submit" name="registrar" value="Registrar" /><br>

            <?php
                  if (!$primera_vez) {

                        echo "El formulario contiene errores. Corrígelos y vuelve a intentarlo.";
                  }
                  ?>
      </form>

</body>

</html>
<?php

}
 */
function _vista_form_registro($usuario, $email, $primera_vez)
{
      $mensaje_error = "";
      $class_error = "";

      if (!$primera_vez) {
            $class_error = "error";
            $mensaje_error = "El formulario contiene errores. Corrígelos y vuelve a intentarlo.";
      }

      $params = [
            "usuario" => $usuario,
            "email" => $email,
            "class_error" => $class_error,
            "mensaje_error" => $mensaje_error,
      ];

      mostrarTpls($params, "../view/tpls/form.tpl");
}

function mostrarTpls($params, $archivo)
{

      $html = file_get_contents($archivo); //recoje todo el contenido del fichero como texto
      foreach ($params as $key => $value) {
            $html = str_replace("{{::$key::}}", $value, $html);
      }
      echo $html;
}