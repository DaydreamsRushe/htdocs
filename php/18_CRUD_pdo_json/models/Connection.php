<?php
require_once 'config/config.php';

class Connection {
  private $conn;
  public function getConnection(){
    $this->conn = null;

    try{
      $this->conn = new PDO(
        "mysql:host=". DB_HOST . ";dbname=" . DB_NAME,DB_USER,DB_PASS
      );
      /* $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $this->conn->exec("set names " . DB_NAME) */
    }catch(PDOException $e){
      echo "Error de conexion: " . $e->getMessage();
    }
    return $this->conn;
  }
}

?>