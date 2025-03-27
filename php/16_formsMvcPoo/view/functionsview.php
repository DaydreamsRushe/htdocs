<?php


function presentoFeedback($error, $exito)
{
      $params = [
            "error" => $error,
            "exito" => $exito
      ];
      montaViews($params, "../view/feedback.tpl");
}

function presentoForm($email, $asunto, $contenido)
{
      $params = [
            "email" => $email,
            "asunto" => $asunto,
            "contenido" => $contenido
      ];

      montaViews($params, "../view/form.tpl");
}


function montaViews($params, $archivo)
{
      $html = file_get_contents($archivo);
      foreach ($params as $key => $value) {
            $html = str_replace("{{#$key#}}", $value, $html);
      }
      echo $html;
}
