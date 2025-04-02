<?php

class ClasePapi{
		public static function metodoPapi(){
			return "<p>Hola desde la class Padre</p>";
		}
    	public function metodoAheredar(){
			return "<p>método desde la ClassPapi que hereda la ClaseHijo</p>";
		}
		public function otrometodo(){
			return "<p>Otro método desde la ClassPapi</p>";
		}
}

class ClaseHijo extends ClasePapi{
			public static function metodoHijo(){
				return parent::metodoPapi();
			}

			public function otrometodo(){
				return "<p>Otro método desde la class ClaseHijo</p>";
			}

}


echo ClaseHijo::metodoHijo();
$otra =new ClaseHijo();
echo $otra->otrometodo();
echo $otra->metodoHijo();
echo $otra->metodoAheredar();

//
echo ClasePapi::metodoPapi();
$otra2 =new ClasePapi();
echo $otra2->otrometodo();

