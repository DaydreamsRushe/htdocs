<?php

class Conexion extends PDO
{
      private $typedb = "mysql";
      private $host = "localhost";
      private $namedb = "users2025";
      private $user = "root";
      private $pw = "";

      public function __construct(){

            try {
                  parent::__construct($this->typedb . ":host=" . $this->host . ";dbname=" . $this->namedb . ";charset=UTF8mb4", $this->user, $this->pw);

                  echo "OLEEEE";
            } catch (PDOException $e) {
                  echo "Error de conexión: " . $e->getMessage();
            }
      }
}

$con = new Conexion();
