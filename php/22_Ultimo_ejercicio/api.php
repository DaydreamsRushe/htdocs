<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'models/Connection.php';
require_once 'controllers/UsuarioController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = new UsuarioController();

// Función anónima guardada en una variable para verificar si el usuario está logueado
$verificarSesion = function() {
    if (!isset($_SESSION['userData'])) {
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }
    return $_SESSION['userData'];
};

// Función anónima guardada en una variable para verificar permisos de edición
$verificarPermisosEdicion = function($userData, $requestedId) {
    if ($userData['tipo_usuario'] !== 3 && 
        $userData['tipo_usuario'] !== 1 && 
        $userData['id'] != $requestedId) {
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }
};

// Función anónima guardada en una variable para verificar permisos de eliminación
$verificarPermisosEliminacion = function($userData, $requestedId) {
    if ($userData['tipo_usuario'] !== 3 && 
        ($userData['tipo_usuario'] !== 1 || $userData['id'] == $requestedId)) {
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }
    if ($userData['id'] == $requestedId) {
        echo json_encode(['success' => false, 'error' => 'No puedes eliminarte a ti mismo']);
        exit;
    }
};

// Función anónima guardada en una variable para procesar la subida de archivos
$procesarArchivo = function($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (!in_array($file['type'], $allowedTypes)) {
        return ['error' => 'Tipo de archivo no permitido. Use JPEG, PNG o GIF'];
    }

    if ($file['size'] > $maxSize) {
        return ['error' => 'El archivo es demasiado grande. Máximo 2MB'];
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $extension;
    $target_file = 'pictures/' . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return "pictures/" . basename($target_file);
    }

    return ['error' => 'Error al subir el archivo'];
};

// Procesar peticiones GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo $controller->index();
    exit;
}

// Procesar peticiones POST
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
            $result = $controller->login($data['email'], $data['password']);
            echo json_encode($result);
            break;

        case 'update_foto':
            $userData = $verificarSesion();
            $id = $_POST['id'] ?? '';
            if (empty($id)) {
                echo json_encode(['error' => 'ID no especificado']);
                exit;
            }
            if ($userData['tipo_usuario'] !== 3 && $userData['tipo_usuario'] !== 1 && $userData['id'] != $id) {
                echo json_encode(['error' => 'No autorizado']);
                exit;
            }
            $resultado = $procesarArchivo($_FILES['foto']);
            if (is_string($resultado)) {
                echo json_encode($controller->updateFoto($id, $resultado));
            } else {
                echo json_encode($resultado);
            }
            break;

        case 'create':
            $userData = $verificarSesion();
            if ($userData['tipo_usuario'] !== 3) {
                echo json_encode(['error' => 'No autorizado']);
                exit;
            }
            $createData = [
                'nombre_apellidos' => $_POST['nombre'],
                'usuario' => $_POST['usuario'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'tipo_usuario' => $_POST['tipo_usuario'] ?? 2,
                'foto' => 'img/default-user.svg'
            ];
            if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0) {
                $resultado = $procesarArchivo($_FILES['foto']);
                if (is_string($resultado)) {
                    $createData['foto'] = $resultado;
                } else {
                    echo json_encode($resultado);
                    exit;
                }
            }
            echo json_encode($controller->create($createData));
            break;

        case 'update':
            $userData = $verificarSesion();
            $requestedId = $data['id'];
            $verificarPermisosEdicion($userData, $requestedId);

            if (!isset($data['nombre_apellidos']) || !isset($data['usuario']) || !isset($data['email'])) {
                echo json_encode(['success' => false, 'error' => 'Faltan campos requeridos']);
                exit;
            }

            $updateData = [
                'id' => $requestedId,
                'nombre_apellidos' => $data['nombre_apellidos'],
                'usuario' => $data['usuario'],
                'email' => $data['email']
            ];

            if (isset($data['tipo_usuario']) && ($userData['tipo_usuario'] === 3 || $userData['tipo_usuario'] === 1)) {
                $updateData['tipo_usuario'] = $data['tipo_usuario'];
            }

            echo json_encode($controller->update($updateData));
            break;

        case 'delete':
            $userData = $verificarSesion();
            $requestedId = $data['id'];
            $verificarPermisosEliminacion($userData, $requestedId);
            echo json_encode($controller->delete($data));
            break;

        case 'updateProfile':
            $userData = $verificarSesion();
            $requestedId = $_POST['id'];
            if ($userData['tipo_usuario'] !== 3 && $userData['id'] != $requestedId) {
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                exit;
            }

            $updateData = [
                'id' => $requestedId,
                'nombre_apellidos' => $_POST['nombre'],
                'email' => $_POST['email'],
                'usuario' => $_POST['usuario']
            ];

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $resultado = $procesarArchivo($_FILES['foto']);
                if (is_string($resultado)) {
                    $updateData['foto'] = $resultado;
                } else {
                    echo json_encode($resultado);
                    exit;
                }
            }

            echo json_encode($controller->updateProfile($updateData));
            break;

        case 'changePassword':
            $userData = $verificarSesion();
            $requestedId = $data['id'];
            if ($userData['id'] != $requestedId) {
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                exit;
            }
            echo json_encode($controller->changePassword(
                $requestedId,
                $data['currentPassword'],
                $data['newPassword']
            ));
            break;

        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
    exit;
}

// Si no es GET ni POST, devolvemos un error
echo json_encode(['error' => 'Método no permitido']);
?> 