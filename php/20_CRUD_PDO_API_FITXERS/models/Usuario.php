<?php

class Usuario {
  private $conn;
  private $table_name = "datos_usuarios";

  public $id;
  public $nombre_apellidos;
  public $usuario;
  public $email;
  public $password;
  public $tipo_usuario;
  public $foto;

  public function __construct($db) {
    $this->conn = $db;
  }

  //Obtener todos los usuarios
  public function read() {
    $query = "SELECT * FROM " . $this->table_name . " ORDER BY id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  //Crear usuario
  public function create() {
    //Primero obtener el ultimo ID
    $query_last_id = "SELECT MAX(id) as last_id FROM " . $this->table_name;
    $stmt_last_id = $this->conn->prepare($query_last_id);
    $stmt_last_id->execute();
    $row = $stmt_last_id->fetch(PDO::FETCH_ASSOC);
    $next_id = ($row['last_id'] > 0) ? $row['last_id'] +1 : 1;

    //Insertar el nuevo usuario con el ID calculado
    $query = "INSERT INTO " . $this->table_name . " (id, nombre_apellidos, usuario, email, password, tipo_usuario, foto) VALUES (:id, :nombre_apellidos, :usuario, :email, :password, :tipo_usuario, :foto)";
    $stmt = $this->conn->prepare($query);

    //aseguremonos que la foto sea null si no se proporciona
    if(empty($this->foto)){
      $this->foto = null;
    }
    //Vincular los parametros
    $stmt->bindParam(":id",$next_id);
    $stmt->bindParam(":nombre_apellidos",$this->nombre_apellidos);
    $stmt->bindParam(":usuario",$this->usuario);
    $stmt->bindParam(":email",$this->email);
    $stmt->bindParam(":password",$this->password);
    $stmt->bindParam(":tipo_usuario",$this->tipo_usuario);
    $stmt->bindParam(":foto",$this->foto);

    try{
      if($stmt->execute()){
      return ['mensaje' => "usuario creado correctamente", "id" => $next_id];
    }
    return ['error' => "error al crear usuario"];
    }catch (PDOException $e){
      if($e -> getCode() == 23000){
        return ['error' => "el email ya esta registrado"];
      }
      return ['error' => "Error en la base de datos: " . $e->getMessage()];
    }
  }

  //Actualizar usuario
  public function update() {
    $query = "UPDATE " . $this->table_name . " SET nombre_apellidos = :nombre_apellidos, usuario = :usuario, email = :email";

    //Solo actualizar password si se proporciona uno nuevo
    if(!empty($this->password)){
      $query .= ", password = :password";
    }
    if(isset($this->tipo_usuario)){
      $query .= ", tipo_usuario = :tipo_usuario";
    }
    if(isset($this->foto)){
      $query .=", foto = :foto";
    }

    $query .= " WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":nombre_apellidos",$this->nombre_apellidos);
    $stmt->bindParam(":usuario",$this->usuario);
    $stmt->bindParam(":id",$this->id);
    $stmt->bindParam(":email",$this->email);

    if(!empty($this->password)){
      $stmt->bindParam(":password", $this->password);
    }
    if(isset($this->tipo_usuario)){
      $stmt->bindParam(":tipo_usuario", $this->tipo_usuario);
    }
    if(isset($this->foto)){
      $stmt->bindParam(':foto',$this->foto);
    }

    if($stmt->execute()){
      return true;
    }
    return false;
  }


  //actualizar solo la foto
  public function updateFoto(){
    $query = "UPDATE " . $this->table_name . " SET foto = :foto WHERE id = :id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":foto", $this->foto);
    if($stmt->execute()){
      return true;
    }
    return false;
  }


  //Eliminar usuario
  public function delete() {
    //Primero eliminar el registro
    $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":id", $this->id);
    $stmt->execute();

    //Actualizar los IDs restantes
    $sql = "SET @count = 0";
    $this->conn->exec($sql);

    $sql = "UPDATE " . $this->table_name . " SET id = (@count := @count + 1) ORDER BY id";
    $this->conn->exec($sql);

    return true;
  }
}
  
?>