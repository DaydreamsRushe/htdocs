<?php

class Operacion{
  protected $numero1=0;
  protected $numero2=0;
}

class Suma extends Operacion{
  public $tipo = "suma";

  public function __construct($numero1, $numero2) {
    parent::$numero1 = $numero1;
    parent::$numero2 = $numero2;
  }

  public function operar(){
    return parent::$numero1 + parent::$numero2;
  }
}

class Resta extends Operacion{
  public $tipo = "resta";

  public function __construct($numero1, $numero2) {
    parent::$numero1 = $numero1;
    parent::$numero2 = $numero2;
  }

  public function operar(){
    return parent::$numero1 - parent::$numero2;
  }
}

class Multi extends Operacion{
  public $tipo = "multiplicacion";

  public function __construct($numero1, $numero2) {
    parent::$numero1 = $numero1;
    parent::$numero2 = $numero2;
  }

  public function operar(){
    return parent::$numero1 * parent::$numero2;
  }
}
class Divs extends Operacion{
  public $tipo = "division";

  public function __construct($numero1, $numero2) {
    parent::$numero1 = $numero1;
    parent::$numero2 = $numero2;
  }

  public function operar(){
    return parent::$numero1 / parent::$numero2;
  }
}

?>