<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require_once "controllers/ProfessionalController.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usercontroller = new ProfessionalController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo $usercontroller->index();
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos de la petición
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $data = $_POST;
    }

    // Verificar que la acción esté definida
    if (!isset($data['action'])) {
        echo json_encode(['error' => 'Acción no especificada']);
        exit;
    }

    // Procesar según la acción
    switch ($data['action']) {
        case 'login':
            if (!isset($data['email']) || !isset($data['password'])) {
                echo json_encode(['success' => false, 'error' => 'Email y contraseña requeridos']);
                exit;
            }
            $result = $usercontroller->login($data['email'], $data['password']);
            echo json_encode($result);
            break;

        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
    exit;
}

echo json_encode(['error' => 'Método no permitido']);
?>