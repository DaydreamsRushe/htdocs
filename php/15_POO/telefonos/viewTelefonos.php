<?php 
require "viewMobil.php";

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

?>