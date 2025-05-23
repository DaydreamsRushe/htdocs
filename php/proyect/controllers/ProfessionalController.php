<?php
  require_once 'models/connection.php';
  require_once 'models/profesional.php';

  class ProfessionalController {
    private $db;
    private $usuario;
    private $especialidad;
    private const REGEX = ['nombre' => '/^[a-zA-ZÀ-ÿñÑçÇ\s]{5,30}$/u',
        'usuario' => '/^[a-zA-Z0-9]{5,8}$/',
        'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#*])[a-zA-Z\d!@#*]{6,10}$/'
    ];
    public function __construct(){
      $connection = new Connection();
      $this->bd = $connection->getConnection();
      $this->usuario = new Profesional($this->db);
      $this->especialidad = new Especialidad($this->db);
    }
    
    public function index() {
      $datos_profesional = json_encode($this->usuario->read());
      return ["profesional" => $datos_profesional, "especialidad" => json_encode($this->especialidad->read($datos_profesional["id"]))];
    }

  }
?>