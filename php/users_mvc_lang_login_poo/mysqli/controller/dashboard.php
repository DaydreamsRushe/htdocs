<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require_once "../view/lang.php";
require_once "../model/model.php";
require_once "../view/view.php";

class DashboardController {
    private $user;
    private $lang_dashboard;

    public function __construct($lang_dashboard) {
        $this->user = new User();
        $this->lang_dashboard = $lang_dashboard;
    }

    public function handleRequest() {
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['user_id'])) {
            header("Location: app.php");
            exit;
        }

        // Manejar logout
        if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'logout') {
            session_destroy();
            header("Location: app.php");
            exit;
        }

        // Obtener datos del usuario
        $user_id = $_SESSION['user_id'];
        $user_data = $this->user->getUserById($user_id);

        // Mostrar dashboard
        vistaDashboard($user_data, $this->lang_dashboard);
    }
}

// Inicialización y ejecución
$dashboard = new DashboardController($lang_dashboard);
$dashboard->handleRequest(); 