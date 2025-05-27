<?php
  /* Clase para funciones especificas de la tabla especializa */
  class Especialidad {
    private $conn;
    private const TABLE_NAME = "especializa";

    public function __construct($db){
      $this->conn = $db;
    }

    public function read($id){
      $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE id_profesional = " . $id . ";";
      return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
?>