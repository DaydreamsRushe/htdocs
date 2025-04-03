<?php

function vistaRegistroCompletado($usuario, $email, $password, $rows,$lang_feedback){
      $div = "";
      if (!empty($rows)) {
            foreach ($rows as $value) {

                  $div .= "<tr><td>" . $value['id'] . "</td><td>" . $value['usuario'] . "</td><td>" . $value['email'] . "</td><td>" . $value['password'] . "</td></tr>";      
            }
            $div .= "</table>";
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

function vistaRegistroIncorrecto($usuario, $email, $password, $lang_form, $error){
      _vista_form_registro($usuario, $email, $password, false, $lang_form, $error);
}

function vistaMostrarFormularioRegistro($lang_form){
      _vista_form_registro("", "","", true, $lang_form, "");
}

function _vista_form_registro($usuario, $email, $password, $primera_vez, $lang_form, $error){
    $div="";
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
    $div = "</div>";
}

// Nuevas funciones para el login
function vistaMostrarLogin($lang_login){
    _vista_login("", true, $lang_login, "");
}

function vistaLoginIncorrecto($usuario, $lang_login, $error){
    _vista_login($usuario, false, $lang_login, $error);
}

function _vista_login($usuario, $primera_vez, $lang_login, $error){
    $mensaje_error = "";
    $class_error = "";
    
    if (!$primera_vez) {
        $class_error = "error";
        $mensaje_error = $error;
    }
    
    $params = [
        "usuario" => $usuario,
        "class_error" => $class_error,
        "mensaje_error" => $mensaje_error,
    ];
    
    $params = array_merge($params, $lang_login);
    montaViews($params, "../view/tpls/login.tpl");
}

// Función para el dashboard
function vistaDashboard($user_data, $lang_dashboard){
    $params = [
        "id" => $user_data['id'],
        "usuario" => $user_data['usuario'],
        "email" => $user_data['email']
    ];
    
    $params = array_merge($params, $lang_dashboard);
    montaViews($params, "../view/tpls/dashboard.tpl");
}

