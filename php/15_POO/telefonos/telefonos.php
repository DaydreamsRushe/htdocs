<?php 
class Tel {
	public $marca;
	public $model;
	protected $cable = true; 
	protected $comunicacio;

	public function __construct($marca, $model) {
		$this->marca = $marca;
		$this->model = $model;
		$this->comunicacio = ($this->cable) ? 'Cable' : 'Inalàmbric';
	}
	
	public function trucada() {
		print('<p>Estic trucant !!!!!</p>');
	}
	
	public function mes_info() {
		print("<ul>
				<li>Marca <b>{$this->marca}</b></li>
				<li>Model <b>{$this->model}</b></li>
				<li>Cable o inalàmbric<b>{$this->comunicacio}</b></li>
			</ul>");
	}	
}

class Mobil extends Tel {
	protected $cable = false;

	public function __construct($marca, $model) {
		parent::__construct($marca, $model);
	}
}

final class Smarth extends Mobil {
	public $cable = false;
	public $internet = true;
	public $con = true;

	public function __construct($marca, $model) {
		parent::__construct($marca, $model);
       	$this->con =  ($this->internet) ? 'amb connexió Wifi' : 'sense internet';
	}

	public function mes_info_smarth() {
		print("<ul>
				<li>Móbil  <b>{$this->con}</b></li>
			</ul>");
	}
}
echo '<h1>Evolució del Telèfon</h1>';

echo '<h2>Telèfon:</h2>';
$tel_casa = new Tel('Panasonic', 'KX-TS550');
$tel_casa->trucada();
$tel_casa->mes_info();

echo '<h2>Mòbil:</h2>';
$mi_mobil = new Mobil('Nokia', '5120');
$mi_mobil->trucada();
$mi_mobil->mes_info();

echo '<h2>SmarthPhone:</h2>';
$tel_sp = new Smarth('Motorola', 'G3');
$tel_sp->trucada();
$tel_sp->mes_info();
$tel_sp->mes_info_smarth();