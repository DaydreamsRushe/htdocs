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
    $query = "INSERT INTO " . $this->table_name . " (id, nombre_apellidos, usuario, email, password, tipo_usuario) VALUES (:id, :nombre_apellidos, :usuario, :email, :password, :tipo_usuario)";
    $stmt = $this->conn->prepare($query);

    //Vincular los parametros
    $stmt->bindParam(":id",$next_id);
    $stmt->bindParam(":nombre_apellidos",$this->nombre_apellidos);
    $stmt->bindParam(":usuario",$this->usuario);
    $stmt->bindParam(":email",$this->email);
    $stmt->bindParam(":password",$this->password);
    $stmt->bindParam(":tipo_usuario",$this->tipo_usuario);

    if($stmt->execute()){
      return true;
    }
    return false;
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

    if($stmt->execute()){
      return true;
    }
    return false;
  }

  //Eliminar usuario
  public function delete() {
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