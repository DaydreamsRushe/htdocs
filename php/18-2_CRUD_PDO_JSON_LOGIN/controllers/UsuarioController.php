<?php

require_once 'models/Connection.php';
require_once 'models/Usuario.php';

class UsuarioController{
  private $db;
  private $usuario;

  public function __construct(){
    $connection = new Connection();
    $this->db = $connection->getConnection();
    $this->usuario = new Usuario($this->db);
  }

  public function index(){
    $stmt = $this->usuario->read();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($usuarios);
  }

  public function create($data){
    if(empty($data['nombre']) || empty($data['apellido']) || empty($data['email']) || empty($data['password'])){
      return ['error' => 'Todos los campos son requeridos'];
    }

    //validar email
    if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
      return ['error' => 'El formato del email no es valido'];
    }

    //Asignar valores
    $this->usuario->nombres = $data['nombre'];
    $this->usuario->apellidos = $data['apellido'];
    $this->usuario->email = $data['email'];
    $this->usuario->password = pasword_hash($data['password'], PASSWORD_DEFAULT, ["cost" => 14]);
    $this->usuario->tipo_usuario = $data['tipo_usuario'] ?? 2;
    
    if ($this->usuario->create()){
      return ['mensaje' => 'Usuario creado correctamente'];
    }
    return ['error' => 'No se pudo crear el usuario'];
  }

  public function update($data){
    if(empty($data['id'])){
      return['error' => 'ID es requerido'];
    }
    //Validar email
    if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
      return ['error' => 'El formato del email no es valido'];
    }

    $this->usuario->id = $data['id'];
    $this->usuario->nombres = $data['nombre'];
    $this->usuario->apellidos = $data['apellido'];
    $this->usuario->email = $data['email'];
    if(!empty($data['password'])){
      $this->usuario->password = password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => 14]);
    }

    if(isset($data['tipo_usuario'])){
      $this->usuario->tipo_usuario = $data['tipo_usuario'];
    }

    if($this->usuario->update()){
      return ['mensaje' => 'Usuario editado correctamente'];
    }
    return ['error' => 'No se pudo actualizar el usuario'];
  }

  public function delete($data){
    $this->usuario->id = $data['id'];
    if($this->usuario->delete()){
      return ['mensaje' => 'Usuario eliminado correctamente'];
    }
    return ['error' => 'No se pudo eliminar el usuario'];
  }
}
?>