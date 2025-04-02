<?php

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

?>