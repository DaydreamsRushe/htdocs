<?php
require_once 'conexion.php';
$id = $_REQUEST['id'];
$con->query("DELETE FROM datos_usuarios WHERE ID = '$id'");
header("location:index.php");
