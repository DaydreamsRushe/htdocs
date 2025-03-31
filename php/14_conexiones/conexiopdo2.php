<?php
class Conexion
{
      private $typedb = "mysql";
      private $host = "localhost";
      private $namedb = "users2025;charset=UTF8mb4";
      private $user = "root";
      private $pw = "";

      public function __construct()
      {
            try {
                  new PDO($this->typedb . ":host=" . $this->host . ";dbname=" . $this->namedb, $this->user, $this->pw);

                  echo "OLEEEE";
            } catch (PDOException $e) {
                  echo "Error de conexión: " . $e->getMessage();
            }
      }
}

$con = new Conexion();
