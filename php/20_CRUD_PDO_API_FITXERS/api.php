<?php
/* En el desarrollo de aplicaciones web a menudo es necesario permitir que los usuarios suban archivos al servidor para almacenarlos */

/* Tutorial sobre $_FILES http://oregoom.com/php/files/  */

header('Content-Type: application/json; charset=UTF-8'); //Indicar que es una aplicacion de JSON
header("Access-Control-Allow-Origin: *"); //Permite acceder desde cualquier origen
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'models/Connection.php';
require_once 'controllers/UsuarioController.php';

/* $maxSize = 2 * 1024 * 1024; */
//Si es una peticion GET, devolvemos los usuarios
$controller = new UsuarioController();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
  echo $controller->index();
  exit;
}

//Si es una peticion POST, procesamos la accion
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  //verificamos si hay archivos subidos
  if(isset($_FILES["foto"])){
    $action = $_POST['action'] ?? '';
    if($action === 'update_foto'){
      $id=$_POST['id'] ?? '';
      if(empty($id)){
        echo json_encode(['error' => 'ID no especificado']);
        exit;
      }

      $file = $_FILES['foto'];
      $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
      $maxSize = 2 * 1024 * 1024; //2MB de informacion

      if(!in_array($file['type'], $allowedTypes)){
        echo json_encode(['error' => 'Tipo de archivo no permitido. USE JPEG, PNG o GIF']);
        exit;
      }
      if($file['size'] > $maxSize){
        echo json_encode(['error' => 'El archivo es demasiado grande. Maximo 2MB']);
        exit;
      }

      $extension = pathinfo($file['name'], PATHINFO_EXTENSION);//solo queremos la extension
      $newFileName = uniqid() . '.' . $extension; //es una funcion de PHP que genera un identificador unico basado en la marca de tiempo actual en mocrosegundos. Por ejemplo, puede generar algo como 675767657658b325b36b7.
      $target_file='pictures/' . $newFileName;

      if(move_uploaded_file($file['tmp_name'], $target_file)){
        $foto_path = "pictures/" . basename($target_file);
        $resultado = $controller->updateFoto($id, $foto_path);
        echo json_encode($resultado);
      }else {
        echo json_encode(['error' => 'Error al subir el archivo']);
      }
      exit;
    }else if ($action === 'create'){
      //Procesamos la creacion de usuario con foto
      if(!isset($_POST['nombre_apellidos']) || !isset($_POST['usuario']) || !isset($_POST['email']) || !isset($_POST['password'])){
        echo json_encode(['error' => 'Faltan campos requeridos']);
        exit;
      }

      $file= $_FILES['foto'];
      $foto_path = 'img/default-user.svg'; //Establecemos la ruta por defecto

      //si hay foto procesamos
      if($file['size'] > 0){
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $maxSize = 2 * 1024 * 1024; //2MB de informacion

        if(!in_array($file['type'], $allowedTypes)){
          echo json_encode(['error' => 'Tipo de archivo no permitido. USE JPEG, PNG o GIF']);
          exit;
        }

        if($file['size'] > $maxSize){
          echo json_encode(['error' => 'La foto es demasiado grande']);
          exit;
        }
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid() . '.' . $extension; 
        $target_file='pictures/' . $newFileName;

        if(move_uploaded_file($file['tmp_name'], $target_file)){
          $foto_path = "pictures/" . basename($target_file);
        }else {
          echo json_encode(['error' => 'Error al subir el archivo']);
          exit;
        }
      }
      //preparamos los datos del usuario
      $data = [
        'nombre_apellidos' => $_POST['nombre_apellidos'],
        'usuario' => $_POST['usuario'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'tipo_usuario' => $_POST['tipo_usuario'] ?? 2,
        'foto' => $foto_path
      ];

      $result = $controller->create($data);
      if(isset($result['error'])){
        http_response_code(400);
      }else{
        http_response_code(200);
      }
      echo json_encode($result);
      exit;
    }
  }else if(isset($_POST['action']) && $_POST['action'] === 'create'){
    //procesamos la creacion de usuario sin foto
    if(!isset($_POST['nombre_apellidos']) || !isset($_POST['usuario']) || !isset($_POST['email']) || !isset($_POST['password'])){
      echo json_encode(['error' => 'Faltan campos requeridos']);
      exit;
    }

    $data = [
        'nombre_apellidos' => $_POST['nombre_apellidos'],
        'usuario' => $_POST['usuario'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'tipo_usuario' => $_POST['tipo_usuario'] ?? 2,
        'foto' => 'img/default-user.svg'
    ];
    $result = $controller->create($data);
      if(isset($result['error'])){
        http_response_code(400);
      }else{
        http_response_code(200);
      }
      echo json_encode($result);
      exit;
  }
  //para otras acciones, obtenemos el contenido del body
  $data = json_decode(file_get_contents("php://input"),true);

  //Verificamos que la accion este definida
  if(!isset($data['action'])){
    echo json_encode(['error' => 'Accion no especificada']);
    exit;
  }

  //Procesamos segun la accion
  switch($data['action']){
    case 'update':
      //Validamos que el id este presente
      if(!isset($data['id'])){
        echo json_encode(['error' => 'ID no especificado']);
        exit;
      }

      //Converimos el compo nombre a nombre_apellidos para mantener consistencia
      /* if(isset($data['nombre'])){
        $data['nombre_apellidos'] = $data['nombre'];
        unset($data['nombre']);
      } */

      $result = $controller->update($data);
      
      //Verificamos si el resultado tiene un error
      if(isset($result['error'])){
        http_response_code(400);
        echo json_encode($result);
      }else{
        http_response_code(200);
        echo json_encode($result);
      }
      break;

    case 'delete':
      if(!isset($data['id'])){
        echo json_encode(['error' => 'ID no especificado']);
        exit;
      }
      $result = $controller->delete($data);
      
      //Verificamos si el resultado tiene un error
      if(is_string($result)){
        $result = json_decode($result, true);
      }
      echo json_encode($result);
      break;

    default:
      echo json_encode(['error' => 'Accion no valida']);
      break;
  }
  exit;
}

//Si no es GET ni POST, devolvemos un error
echo json_encode(['error' => 'Metodo no permitido']);
?>