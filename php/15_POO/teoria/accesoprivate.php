<?php


class AccesoPrivate
{
    private  $adios="Adios. ";//solo accesible desde la misma class
	private static $hola="Hola. "; //solo accesible desde la misma class

	private static function saludar(){
		return "Sí. Te saludo a ti";
	}
	private function despedir(){
		return "Sí. Me despido de ti";
	}
	public static function envio_saludo(){
		return self::$hola." - ".self::saludar();

    }
    public function envio_adios(){
	return $this->adios." - ".$this->despedir();
    }

  }

echo AccesoPrivate::envio_saludo();// solo con propiedades y metodos estaticos

$objeto =new AccesoPrivate();
echo $objeto->envio_saludo();
echo $objeto->envio_adios();
