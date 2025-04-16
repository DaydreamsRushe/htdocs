<?php


/* Tutorial sobre $_FILES http://oregoom.com/php/files/  */

header('Content-Type: application/json; charset=UTF-8'); //Indicar que es una aplicacion de JSON
header("Access-Control-Allow-Origin: *"); //Permite acceder desde cualquier origen
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'models/Connection.php';
require_once 'controllers/UsuarioController.php';

//Si es una peticion GET, devolvemos los usuarios
$controller = new UsuarioController();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
  echo $controller->index();
  exit;
}

//Si es una peticion POST, procesamos la accion
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
  //Obtenemos el contenido del body
  $data = json_decode(file_get_contents("php://input"),true);

  //Verificamos que la accion este definida
  if(!isset($data['action'])){
    echo json_encode(['error' => 'Accion no especificada']);
    exit;
  }

  //Procesamos segun la accion
  switch($data['action']){
    case 'create':
      if(!isset($data['nombre_apellidos']) || !isset($data['usuario']) || !isset($data['email']) || !isset($data['password'])){
        echo json_encode(['error' => 'Faltan campos requeridos']);
        exit;
      }

      //Validamos el tipo de usuario
      if(!isset($data['tipo_usuario']) || !in_array($data['tipo_usuario'], [1, 2])){
        $data['tipo_usuario'] = 2; //por defecto
      }

      $result = $controller->create($data);
      
      //Verificamos si el resultado contiene un error
      if(isset($result['error'])){
        http_response_code(400);
        echo json_encode($result);
      }else{
        http_response_code(200);
        echo json_encode($result);
      }
      break;

    case 'update':
      //Validamos que el id este presente
      if(!isset($data['id'])){
        echo json_encode(['error' => 'ID no especificado']);
        exit;
      }

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
};

//Si no es GET ni POST, devolvemos un error
echo json_encode(['error' => 'Metodo no permitido']);
?>