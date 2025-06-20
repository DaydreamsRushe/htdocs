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
    if(empty($data['nombre_apellidos']) || empty($data['usuario']) || empty($data['email']) || empty($data['password'])){
      return ['error' => 'Todos los campos son requeridos'];
    }

    //validar email
    if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
      return ['error' => 'El formato del email no es valido'];
    }

    //Asignar valores
    $this->usuario->nombre_apellidos = $data['nombre_apellidos'];
    $this->usuario->usuario = $data['usuario'];
    $this->usuario->email = $data['email'];
    $this->usuario->password = password_hash($data['password'], PASSWORD_DEFAULT);
    $this->usuario->tipo_usuario = $data['tipo_usuario'] ?? 2;
    $this->usuario->foto = $data['foto'] ?? null;
    
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
    $this->usuario->nombre_apellidos = $data['nombre_apellidos'];
    $this->usuario->usuario = $data['usuario'];
    $this->usuario->email = $data['email'];
    
    if(!empty($data['password'])){
      $this->usuario->password = password_hash($data['password'], PASSWORD_DEFAULT);
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

  public function updateFoto($id, $fotoPath){
    $this->usuario->id = $id;
    $this->usuario->foto = $fotoPath;

    if($this->usuario->updateFoto()){
      return ['mensaje' => 'Foto actualizada correctamente'];
    }
    return['error' => 'No se pudo actualizar la foto'];
  }
}
?>