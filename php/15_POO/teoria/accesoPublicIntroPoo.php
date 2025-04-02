<?php

#Codi Imperatiu
$automobil1 = [
  "marca" => "SuperTrack",
  "model" => "TheBest"
];

$automobil2 = [
  "marca" => "HiperTrack",
  "model" => "The one"
];

function mostrar($automobil)
{
  echo "<p>Hola! sòc un $automobil[marca], model $automobil[model]</p>";
}
mostrar($automobil1);
mostrar($automobil2);


//POO

class Automovil{
	#PROPIEDADES:
	#Son las características que puede tener un Objeto.
//public private protected
	public $marca;
	public $modelo;

	
	#MÉTODO
	#Es el algoritmo asociado a un objeto que indica la capacidad de lo que éste puede hacer. La  única  diferencia  entre  método  y  función,  es que  llamamos  método  a las  funciones  de  una clase   (en    POO),   mientras   que   llamamos funciones,  a  los  algoritmos  de  la  programación estructurada. en este caso, no hay constructor, por tanto no puedo editar el modo abreviado o promocionar
  public function getMarca($marca)
  {
    $this->marca =$marca;
 
  }
  public function getModelo($modelo)
  { 
    $this->modelo =$modelo;
  }
  public function setDatos()
  {
    echo "<p>Hola! soy un {$this->marca}, modelo {$this->modelo}</p>";
  }
}

#OBJETO
#Una entidad provista de métodos o mensajes a los cuales responde propiedades con valores concretos

$b = new Automovil();
$b -> getMarca("Toyota");
$b -> getModelo("Corolla");
$b -> setDatos();

$b = new Automovil();
$b ->getMarca("Hyundai");
$b -> getModelo("Accent Vision");
$b -> setDatos(); 

$b = new Automovil();
$b ->getMarca("Mazda");
$b -> getModelo("2");
$b -> setDatos();



//convertirlo en __construct(){}
#Principios de la POO que se cumplen en este ejemplo:

#ABSTRACCIÓN: Nuevos tipos de datos (el que tu quieras, tu lo creas)
#ENCAPSULACIÓN: Organizar el código en grupos lógicos
#OCULTAMIENTO: Ocultar detalles de implementación y exponer sólo los detalles que sean necesarios para el resto del sistema

#CLASE:
#Una clase es un modelo abstracto  que se utiliza para crear objetos que comparten un mismo comportamiento, estado e identidad.

class Persona
{
  public $nombre;
  public $edad;
  public $altura;
  //metodos para la class persona, tambien puedo usar un método mágico o método que inicializa y construye ya un objeto.
  //método mágico es un metodo del sistema, ya existe como tal se escribe como function 

  public function __construct($nom, $edad, $altura)
  {
    $this->nombre = $nom;
    $this->edad = $edad;
    $this->altura = $altura;
  }
  public function setDatos()
  {
    echo $this->nombre . " tengo  " . $this->edad . "años y mido " . $this->altura . "cms.<br>";
    echo "$this->nombre tengo $this->edad años y mido $this->altura cms.<br>";
    echo "{$this->nombre} tengo {$this->edad} años y mido {$this->altura} cms.<br>";
  }
}
//inicialización de la persona




$per2 = new Persona('Ana', "20", "1,60");
$per1 = new Persona('Juan', "27", "1,75");
$per1->setDatos();
$per2->setDatos();
$otravar = "Pepito";
echo "$otravar es mi nombre<br/>";
echo "{$otravar} es mi nombre<br/>";
