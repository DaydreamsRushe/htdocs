<?php
class Usuario {
  private $conn;
  private $table_name = "datos_usuarios";

  public $id;
  public $nombres;
  public $apellidos;

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
    $query = "INSERT INTO " . $this->table_name . " (id, Nombres, Apellidos) VALUES (:id, :nombres, :apellidos)";
    $stmt = $this->conn->prepare($query);

    //Vincular los parametros
    $stmt->bindParam(":id",$next_id);
    $stmt->bindParam(":nombres",$this->nombres);
    $stmt->bindParam(":apellidos",$this->apellidos);

    return $stmt->execute();
  }

  //Actualizar usuario
  public function update() {
    $query = "UPDATE " . $this->table_name . " SET Nombres = :nombres, Apellidos = :apellidos WHERE id = :id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":nombres",$this->nombres);
    $stmt->bindParam(":apellidos",$this->apellidos);
    $stmt->bindParam(":id",$this->id);

    return $stmt->execue();
  }

  public function delete() {
    $query = "DELETE FROM " . $this->table_name . "WHERE id = :id";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":id", $this->id);
    $stmt->execue();

    //Actualizar los IDs restantes
    $sql = "SET @count = 0";
    $this->conn->exec($sql);

    $sql = "UPDATE " . $this->table_name . " SET id = (@count := @count + 1) ORDER BY id";
    $this->conn->exec($sql);

    return true;
  }
}
  
?>