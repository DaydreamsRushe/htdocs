<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


require_once "controllers/ProfessionalController.php";

/* Iniciamos una sesion */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Creamos el controlador que nos ayude a conectar con la base de datos */
$usercontroller = new ProfessionalController();

/* Funcion para validar los archivos para las fotos que se han seleccionado y las guarda en una carpeta "pictures" donde se puedan encontrar cada vez que se quieran mostrar */
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
    /* Se les da un nombre nuevo y unico */
    $target_file = 'pictures/' . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return "pictures/" . basename($target_file);
    }

    return ['error' => 'Error al subir el archivo'];
};

/* Si se accede a la api con un GET, esta siempre llama a la funcion index del controlador */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo $usercontroller->index();
    exit;
}


/* Si se accede con POST. Se recojeran los datos que se han enviado desde cliente, los cuales incluyen la accion a seguir */
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
      /* Accion de login, donde si los campos de mail y password no estan vacios, se llamara a la funcion login del controlador */
        case 'login':
            if (!isset($data['email']) || !isset($data['password'])) {
                echo json_encode(['success' => false, 'error' => 'Email y contraseña requeridos']);
                exit;
            }
            $result = $usercontroller->login($data['email'], $data['password']);
            echo json_encode($result);
            break;

            /* Accion de creacion de usuarios, donde los datos obtenidos indican los datos a introducir en la base de datos */
        case 'create':            
            $createData = [
                'nombre' => $data['nombre'],
                'email' => $data['email'],
                'password' => $data['password'],
                'tipo_usuario' => $data['tipo_usuario'] ?? 1,
                'foto' => 'img/default-user.svg'
            ];
            /* En el caso de tene una foto añadida, se validara tamaño y formato */
            if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0) {
                $resultado = $procesarArchivo($_FILES['foto']);
                if (is_string($resultado)) {
                    $createData['foto'] = $resultado;
                } else {
                    echo json_encode($resultado);
                    exit;
                }
            }
            echo json_encode($usercontroller->create($createData));
            break;
            /* Accion para devolver los clientes asociados a un id de profesional */
        case 'client-list':
            echo $usercontroller->clients($data['id']);
            break;
          /* Si no hay accion reconocida, se trata de un error */
        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
    exit;
}

echo json_encode(['error' => 'Método no permitido']);
?>