<?php
  class Profesional{
    private $conn;
    private const TABLE_NAME = "usuario";
    private const DEFAULT_PHOTO = 'img/default-user.svg';

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $tipo_usuario;
    public $foto;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read(){
      $query = "SELECT * FROM " . self::TABLE_NAME
    }
  }
?>