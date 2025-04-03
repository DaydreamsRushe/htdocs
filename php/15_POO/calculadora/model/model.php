<?php

class Operacion{
  public $numero1=0;
  public $numero2;
  public $tipo;


  public function __construct($numero1, $numero2, $tipo) {
    $this->numero1 = $numero1;
    $this->numero2 = $numero2;
    $this->tipo = $tipo;
  }
  
  public function getNumeroUno(){
    return $this->numero1;
  }

  public function getNumeroDos(){
    return $this->numero2;
  }

  public function getTipo(){
    return $this->tipo;
  }


  public function operar(){
    if($this->tipo == 'suma'){
      return $this->numero1 + $this->numero2;
    }else if($this->tipo == 'resta'){
      return $this->numero1 - $this->numero2;
    }else if($this->tipo == 'mult'){
      return $this->numero1 * $this->numero2;
    }else if($this->tipo == 'div'){
      return $this->numero1 / $this->numero2;
    }
  }
}