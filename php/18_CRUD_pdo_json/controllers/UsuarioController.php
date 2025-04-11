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
    $this->usuario->nombres = $data['nombre'];
    $this->usuario->apellidos = $data['apellido'];

    if ($this->usuario->create()){
      return json_encode(['success' => true]);
    }
    return json_encode(['success' => false, 'message' => 'Error al crear el usuario']);
  }

  public function update($data){
    $this->usuario->id = $data['id'];
    $this->usuario->nombres = $data['nombre'];
    $this->usuario->apellidos = $data['apellido'];
    echo "<script>console.log('petty plz');</script>";
    if($this->usuario->update()){
      
      return json_encode(['success' => true]);
    }
    return json_encode(['success' => false, 'message' => 'Error al actualizar el usuario']);
  }

  public function delete($data){
    $this->usuario->id = $data['id'];
    if($this->usuario->delete()){
      return json_encode(['success' => true]);
    }
    return json_encode(['success' => false, 'message' => 'Error al eliminar el usuario']);
  }
}
?>