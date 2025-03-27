<?php

function sanitize($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

$error = "";
$exito = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

      $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
      $asunto = isset($_REQUEST['asunto']) ? $_REQUEST['asunto'] : "";
      $contenido = isset($_REQUEST['contenido']) ? $_REQUEST['contenido'] : "";

      /*  var_dump($email,$asunto,$contenido);*/

      if (empty($email)) {
            $error .= "Email es un campo obligatorio. <br/>";
      } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error .= "Correo electrónico no válido.<br/>";
      } else {
            $email = sanitize($email);
      }


      if (empty($asunto)) {
            $error .= "Asunto es un campo obligatorio. <br/>";
            //!is_string()
      } else if (strlen($asunto) < 2 || strlen($asunto) > 40) {
            $error .= "Asunto no se ajusta al largo necesario.<br/>";
      } else {
            $asunto = sanitize($asunto);
      }

      if (empty($contenido)) {
            $error .= "Nos interesa el contenido de tu mensaje y es un campo obligatorio. <br/>";
      } else if (strlen($contenido) < 10 || strlen($contenido) > 200) {
            $error .= "Ajusta tu mensaje a un máximo de 200 carácteres.<br/>";
      } else {
            $contenido = sanitize($contenido);
      }

      if ($error != "") {
            $error = '<div class="alert alert-danger" role="alert">TENEMOS ERRORES EN NUESTRO FORMULARIO!<br/>' . $error . '</div>';
            presentoFeedback($error, $exito);
            presentoForm($email, $asunto, $contenido);
      } else {
            $to       = "oscareroles@gmail.com";
            $cabeceras  = "MIME-Version: 1.0 \r\n";

            $cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
            $cabeceras .= "Reply-To: " . $email . "\r\n";
            /*   $cabeceras .= "Cc: oscar@biotaweb.com" . "\r\n"; */
            /*  $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";*/

            if (mail($to, $asunto, $contenido, $cabeceras)) {
                  $exito = '<div class="success alert-success" role="">Correo enviado CORRECTAMENTE!<br/></div>';
                  presentoFeedback("", $exito);
                  presentoForm("", "", "");
            } else {
                  $error = '<div class="alert alert-danger" role="alert">NO HEMOS PODIDO ENVIAR EL CORREO!<br/></div>';
                  presentoFeedback($error, $exito);
                  presentoForm($email, $asunto, $contenido);
            }
      }
} else {
      presentoFeedback("", "");
      presentoForm("", "", "");
}
