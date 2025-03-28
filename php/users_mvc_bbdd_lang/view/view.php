<?php

function vistaRegistroCompletado($usuario, $email, $rows,$lang_feedback){
      $div = "";
      if (!empty($rows)) {
            foreach ($rows as $value) {
               /*    $div .= "<p>(" . $value['id'] . ") - " . $value['usuario'] . "  :  " . $value['email'] . "</p>"; */
                  $div .= "<tr><td>" . $value['id'] . "</td><td>" . $value['usuario'] . "</td><td>" . $value['email'] . "</td></tr>";
    
                  
            }
            /* $div .= "</table>"; */
      }
      $params = [
            "usuario" => $usuario,
            "email" => $email,
            "password" => $password,
            "div" => $div,
      ];
        $_SESSION['params'] = $params;
        $params = array_merge($params, $lang_feedback);
          montaViews($params, "../view/tpls/feedback.tpl");
}

function vistaRegistroIncorrecto($usuario, $email, $password,$lang_form, $error){
      _vista_form_registro($usuario, $email, $password, false, $lang_form, $error);
}

function vistaMostrarFormularioRegistro($lang_form){
      _vista_form_registro("", "", "", true,$lang_form, "");
}

function _vista_form_registro($usuario, $email, $password, $primera_vez, $lang_form, $error){

      $mensaje_error = "";
      $class_error = "";
      if (!$primera_vez) {
            $class_error = "error";
            $mensaje_error = $error;

      }
      $params = [
            "usuario" => $usuario,
            "email" => $email,
            "password" => $password,
            "class_error" => $class_error,
            "mensaje_error" => $mensaje_error,
      ];
      $params = array_merge($params, $lang_form);
      montaViews($params, "../view/tpls/form.tpl");
}

