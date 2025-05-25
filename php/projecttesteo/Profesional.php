<?php
  class Profesional{
    private $conn;
    private const TABLE_NAME = "profesional";
    private const DEFAULT_PHOTO = 'img/default-user.svg';

    public $id;
    public $nombre;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read(){
      $query = "SELECT * FROM " . self::TABLE_NAME . " ORDER BY user_id;";
      return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
  }
?>