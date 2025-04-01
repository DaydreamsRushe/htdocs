<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require_once "../view/lang.php";
require_once "../model/model.php";
require_once "../view/view.php";
require_once "../model/connect.php";

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: app.php");
    exit;
}

// Obtener datos del usuario
$user_id = $_SESSION['user_id'];
$selectQuery = "SELECT * FROM usuarios2 WHERE id='$user_id'";
$result = $con->query($selectQuery);
$user_data = $result->fetch_assoc();

// Manejar logout
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'logout') {
    session_destroy();
    header("Location: app.php");
    exit;
}

// Mostrar dashboard
vistaDashboard($user_data, $lang_dashboard); 