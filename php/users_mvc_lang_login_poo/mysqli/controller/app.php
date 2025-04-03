<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

require_once "../view/lang.php";
require_once "../model/model.php";
require_once "../view/view.php";
require "functions.php";

class AppController {
    private $user;
  /*   private $lang_login; */
/*     private $lang_form;
    private $lang_feedback; */

    public function __construct(private $lang_login, private $lang_form, private $lang_feedback) {
        $this->user = new User();
/*         $this->lang_login = $lang_login;
        $this->lang_form = $lang_form;
        $this->lang_feedback = $lang_feedback; */
    }

    public function actionLogin() {
        if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['action']) && $_REQUEST['action'] === 'Login') {
            $error = '';
            $usuario = is_string($_REQUEST['usuario']) && preg_match('/^[A-Za-z0-9 ]{5,15}$/', $_REQUEST['usuario']) ? $_REQUEST['usuario'] : '';
            if (empty($usuario)) {
                $error = $this->lang_login['mensaje_error'];
            }

            $password = is_string($_REQUEST['pwd']) ? $_REQUEST['pwd'] : '';
            if (empty($password)) {
                $error = $this->lang_login['mensaje_error'];
            }

            if (empty($error)) {
                $usuario = saneadoreitor($usuario);
                $password = saneadoreitor($password);

                list($ok, $user_data) = $this->user->login($usuario, $password);
                if ($ok) {
                    $_SESSION['user_id'] = $user_data['id'];
                    $_SESSION['usuario'] = $user_data['usuario'];
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = $this->lang_login['mensaje_error'];
                }
            }

            vistaLoginIncorrecto($usuario, $this->lang_login, $error);
            exit;
        }
    }

    public function actionNuevoUsuario() {
        if (("POST" === $_SERVER["REQUEST_METHOD"]) && isset($_REQUEST['registrar'])) {
            $error = '';
            $usuario = is_string($_REQUEST['usuario']) && preg_match('/^[A-Za-z0-9 ]{5,15}$/', $_REQUEST['usuario']) ? $_REQUEST['usuario'] : '';
            if (empty($usuario)) {
                $error = $this->lang_form['missatge_error'][0];
            }

            $email = is_string($_REQUEST['email']) && filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL) ? $_REQUEST['email'] : '';
            if (empty($email)) {
                $error = $this->lang_form['missatge_error'][1];
            }

            $password = is_string($_REQUEST['pwd']) && strlen($_REQUEST['pwd']) >= 5 && strlen($_REQUEST['pwd']) <= 8 && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['pwd']) ? $_REQUEST['pwd'] : '';
            if (empty($password)) {
                $error = $this->lang_form['missatge_error'][2];
            }

            if (empty($error)) {
                $usuario = saneadoreitor($usuario);
                $email = saneadoreitor($email);
                $password = saneadoreitor($password);

                list($rows, $ok) = $this->user->register($usuario, $email, $password);
                if ($ok) {
                    vistaRegistroCompletado($usuario, $email, $password, $rows, $this->lang_feedback);
                    exit;
                } else {
                    $error = $this->lang_form['missatge_error'][3];
                }
            }

            vistaRegistroIncorrecto($usuario, $email, $password, $this->lang_form, $error);
            exit;
        }
    }

    public function handleRequest() {
        if (isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] === 'Login') {
                $this->actionLogin();
            } elseif ($_REQUEST['action'] === 'register') {
                vistaMostrarFormularioRegistro($this->lang_form);
            } elseif ($_REQUEST['action'] === 'NuevoUsuario') {
                $this->actionNuevoUsuario();
            }
        } else {
            vistaMostrarLogin($this->lang_login);
        }
    }
}

// Inicialización y ejecución
$app = new AppController($lang_login, $lang_form, $lang_feedback);
$app->handleRequest();
