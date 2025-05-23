<?php
$users = ["Oscar Eroles", "Santiago Perolillos", "Marta Sanchez", "Mila Torres", "Juanma Sortos", "Manuel Garrido", "Jose Ortega", "Marta Suarez", "Sancho Panza", "Ariana Pequeña"];
$passwords = ["Oscar123@", "Santiago123@", "Marta123@", "Mila123@", "Juanma123@", "Manuel123@", "Jose123@", "Marta123@", "Sancho123@", "Ariana123@"];

// Configuración del coste
$options = ['cost' => 14];

for ($i=0; $i <= 9; $i++) { 
    echo $users[$i] . " - " . password_hash($passwords[$i], PASSWORD_DEFAULT, $options) . "<br>";
}

?>