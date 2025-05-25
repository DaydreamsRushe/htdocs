<?php
  require_once 'connection.php';
  require_once 'Profesional.php';
  require_once 'especialidad.php';
  require_once 'usuario.php';

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
      $this->db = $connection->getConnection();
      $this->usuario = new Usuario($this->db);
      $this->especialidad = new Especialidad($this->db);
    }
    
    public function index() {
  
      $datos_profesional = $this->usuario->readProfesionals();
      $datos = [];
      foreach ($datos_profesional as $profesional) {
        $d = ["id" => $profesional["id"], "nombre" => $profesional["usuario"], "email" => $profesional["email"] , "foto" => $profesional["foto"], "especialidades" => []];
        $e = [];
        foreach ($this->especialidad->read($d["id"]) as $especial) {
          array_push($e, $especial["especialidad"]);
        }
        $d["especialidades"] = $e; 
        array_push($datos, $d);
      };
      return json_encode($datos);
    }

  }/* , "especialidad" => json_encode($this->especialidad->read($datos_profesional["id"])) */
?>