<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'connection.php';
require_once "ProfessionalController.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usercontroller = new ProfessionalController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo $usercontroller->index();
    exit;
}

?>