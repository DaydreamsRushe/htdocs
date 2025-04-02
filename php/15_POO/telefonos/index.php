<?php
require "viewTelefonos.php";
/* require "viewMobil.php";
require "viewSmarth.php"; */

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

?>