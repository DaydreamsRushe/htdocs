<?php

class ClasePapi{
  
	const MI_CONSTANTE="Hasta el infinito y mas allá";
	protected $saludo="Hola. Bona tarda"; //accesible desde la propia class y sus clases hijas
		/* protected static $saludo="Hola. Bona tarda";  *///accesible desde la propia class y sus clases hijas

	/* 	protected function metodo_protegido(){  *///accesible desde la propia class y sus clases hijas
		protected static function metodo_protegido(){ //accesible desde la propia class y sus clases hijas
			return "Texto desde el método protegido";
		}
}


class ClaseHijo extends ClasePapi{
		
			public function mostrar(){
	return parent::metodo_protegido().$this->saludo." - ".parent::MI_CONSTANTE; 
		/* 	return parent::metodo_protegido()." - ".parent::$saludo; */
			}
}


/* echo ClaseHijo::mostrar(); */

$objeto =new ClaseHijo();
echo $objeto->mostrar();
