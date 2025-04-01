<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

require_once "../view/lang.php";
require_once "../model/model.php";
require_once "../view/view.php";
require "functions.php";

function actionLogin($con, $lang_login)
{
    if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'Login') {
        $error = '';
        $usuario = is_string($_REQUEST['usuario']) && preg_match('/^[A-Za-z0-9]{5,15}$/', $_REQUEST['usuario']) ? $_REQUEST['usuario'] : '';
        if (empty($usuario)) {
            $error = $lang_login['mensaje_error'];
        }

        $password = is_string($_REQUEST['pwd']) ? $_REQUEST['pwd'] : '';
        if (empty($password)) {
            $error = $lang_login['mensaje_error'];
        }

        if (empty($error)) {
            $usuario = saneadoreitor($usuario);
            $password = saneadoreitor($password);

            list($ok, $user_data) = modeloLogin($usuario, $password, $con);
            if ($ok) {
                $_SESSION['user_id'] = $user_data['id'];
                $_SESSION['usuario'] = $user_data['usuario'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = $lang_login['mensaje_error'];
            }
        }

        vistaLoginIncorrecto($usuario, $lang_login, $error);
        exit;
    }
}

function actionNuevoUsuario($con, $lang_form, $lang_feedback) //FUNCION para nuevos usuarios registrados
{
    if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['registrar'])) {
        $error = '';
        $usuario = is_string($_REQUEST['usuario']) && preg_match('/^[A-Za-z0-9 ]{5,15}$/', $_REQUEST['usuario']) ? $_REQUEST['usuario'] : '';
        if (empty($usuario)) {
            $error = $lang_form['missatge_error'][0];
        }

        $email = is_string($_REQUEST['email']) && filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL) ? $_REQUEST['email'] : '';
        if (empty($email)) {
            $error = $lang_form['missatge_error'][1];
        }

        $password = is_string($_REQUEST['pwd']) && strlen($_REQUEST['pwd']) >= 5 && strlen($_REQUEST['pwd']) <= 8 && preg_match('/[a-zA-Z0-9]$/', $_REQUEST['pwd']) ? $_REQUEST['pwd'] : '';
        if (empty($password)) {
            $error = $lang_form['missatge_error'][2];
        }

        if (empty($error)) {
            $usuario = saneadoreitor($usuario);
            $email = saneadoreitor($email);
            $password = saneadoreitor($password);

            list($rows, $ok) = modeloRegistrarNuevoUsuario($usuario, $email, $password, $con);
            if ($ok) {
                vistaRegistroCompletado($usuario, $email, $password, $rows, $lang_feedback);
                exit;
            } else {
                $selectQuery = "SELECT * FROM usuarios2 WHERE usuario='$usuario' OR email='$email'";
                $result = $con->query($selectQuery);
                if ($result->num_rows > 0) {
                    $error = $lang_form['missatge_error'][3];
                } else {
                    $selectPasswordQuery = "SELECT password FROM usuarios2";
                    $result = $con->query($selectPasswordQuery);
                    $password_exists = false;
                    while ($row = $result->fetch_assoc()) {
                        if (password_verify($password, $row['password'])) {
                            $password_exists = true;
                            break;
                        }
                    }
                    if ($password_exists) {
                        $error = $lang_form['missatge_error'][3];
                    }
                }
            }
        }

        vistaRegistroIncorrecto($usuario, $email, $password, $lang_form, $error);
        exit;
    }
}

if (isset($_REQUEST['action'])) { //Decidimos que ve el usuario
    if ($_REQUEST['action'] === 'Login') {//El usuario ya registrado entra
        actionLogin($con, $lang_login);
    } elseif ($_REQUEST['action'] === 'register') { //el usuario sin registrar va a registrarse
        vistaMostrarFormularioRegistro($lang_form);
    } elseif ($_REQUEST['action'] === 'NuevoUsuario') { //se registra el nuevo usuario
        actionNuevoUsuario($con, $lang_form, $lang_feedback);
    }
} else {
    vistaMostrarLogin($lang_login); //pagina inicial de login
}
