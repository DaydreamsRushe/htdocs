<?php
  require_once 'models/connection.php';
  require_once 'models/profesional.php';

  class ProfessionalController {
    private $db;
    private $usuario;
    private const REGEX = ['nombre' => '/^[a-zA-ZÀ-ÿñÑçÇ\s]{5,30}$/u',
        'usuario' => '/^[a-zA-Z0-9]{5,8}$/',
        'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/'
    ];
    public function __construct(){
      $connection = new Connection();
      $this->bd = $connection->getConnection();
      $this->usuario = new Profesional($this->db);
    }
    
    public function index() {
      return json_encode($this->usuario->read());
    }

  }
?>