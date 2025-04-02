<?php


class AccesoStatic
{
	
	public static $nom="Pepe "; // accesible desde toda la aplicación
	const MI_CONSTANTE="Hasta el infinito y mas allá";

	public static function saludar(){
		return "Sí. Te saludo a ti";
	}

/* 	public static function mostrar(){ */
	public function mostrar(){ 
		return self::$nom." - ".self::MI_CONSTANTE." - ".self::saludar();
	}

}

/* echo AccesoStatic::mostrar(); */// solo con propiedades y metodos estaticos
echo AccesoStatic::saludar(); // solo con propiedades y metodos estaticos
echo AccesoStatic::$nom;// solo con propiedades y metodos estaticos
echo AccesoStatic::MI_CONSTANTE;// solo con propiedades y metodos estaticos

$objeto =new AccesoStatic();
echo $objeto->mostrar(); // los metodos static pueden ser llamadosde las dos maneras
echo $objeto->saludar();
/* echo $objeto->nom;
echo $objeto->MI_CONSTANTE; */
/* Paamayim Nekudotayim podría, en un principio, parecer una extraña elección para bautizar a un doble dos-puntos. Sin embargo, mientras se escribía el Zend Engine 0.5 (que utilizó PHP 3), asi es como el equipo Zend decidió bautizarlo. En realidad, significa doble dos-puntos - en Hebreo! */
