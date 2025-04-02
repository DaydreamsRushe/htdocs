<?php
require "viewSmarth.php";

class Mobil extends Tel {
	protected $cable = false;

	public function __construct($marca, $model) {
		parent::__construct($marca, $model);
	}
}

?>