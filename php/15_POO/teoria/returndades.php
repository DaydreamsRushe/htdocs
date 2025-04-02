<?php


class ReturnDades
{
	public function torna_string($edad){
		if($edad>18){
			$resul="Bravo eres mayor de edad";
		}
		else{
			$resul="Se SIENTEEE!!!! eres menor";
		}
	 return print($resul);
	}

	public function torna_int($num){
		if($num>0){
			$resul=1;
		}
		else{
			$resul=0;
		}
	 return print($resul); //imprimir como return de un método con print, nunca con echo
	}

	public function torna_array($repet){
		$datos=[];
		for($i=0;$i<$repet;$i++){
			$datos[$i]="Repetición: ".$i."<br/>";
				echo($datos[$i]); //imprimir dentro de un método, sin problemas con echo
			}
			return true;
		}

	public function torna_json(){
		$datos=[
			"primero"=>500,
			"segundo"=>"segundo valor",
			"tercero"=>100
		];
		return print(json_encode($datos));
		}

}

$objeto = new ReturnDades();

echo "<pre>";
$objeto->torna_string(19);
echo "</pre><pre>";
$objeto->torna_int(10);
echo "</pre><pre>";
$objeto->torna_array(10);
echo "</pre><pre>";
$objeto->torna_json();
echo "</pre>";
