<?php

$host = "localhost";
$user = "root";
$pass = "";
$bd = "users2025"; 

$con = new mysqli($host, $user, $pass, $bd);

if ($con->connect_errno) {
    die('Error de conexión (' . $con->connect_errno . ') ' . $con->connect_error);
}

