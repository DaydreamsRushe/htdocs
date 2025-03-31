<?php
class Conexion extends PDO
{
      const DB_TYPE = 'mysql';
      const DB_HOST = 'localhost';
      const DB_USER = 'root';
      const DB_PASS = '';
      const DB_NAME = "users2025;;charset=UTF8mb4";

      public function __construct(){

            try {
                  parent::__construct(self::DB_TYPE . ":host=" . self::DB_HOST . ";dbname=" . self::DB_NAME, self::DB_USER, self::DB_PASS);
                  echo "OLEEEE";
            } catch (PDOException $e) {
                  echo "Error de conexión: " . $e->getMessage();
            }
      }
}

$con = new Conexion();
