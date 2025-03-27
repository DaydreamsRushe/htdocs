<?php

/**
 * Este código evaluará el servidor para determinar el coste permitido.
 * Se establecerá el mayor coste posible sin disminuir demasiando la velocidad
 * del servidor. 8-10 es una buena referencia, y más es bueno si los servidores
 * son suficientemente rápidos. El código que sigue tiene como objetivo un tramo de
 * ≤ 50 milisegundos, que es una buena referencia para sistemas con registros interactivos.
 */
/* $timeTarget = 1; // 50 milisegundos

$coste = 14;
do {
    $coste++;
    $inicio = microtime(true);
    $pw = password_hash("acjgf,mb,mbtriutrdt", PASSWORD_DEFAULT, ["cost" => $coste]);
    $fin = microtime(true);
} while (($fin - $inicio) < $timeTarget);

echo "Coste apropiado encontrado: " . $coste . "<br>";
echo "encriptado: " . $pw . "<br>"; 
*/
$pw = password_hash("rasmbbuerdorf", PASSWORD_DEFAULT, ["cost" => 10]);
echo "encriptado: " . $pw . "<br>";

if (password_verify('rasmbbjjerdorf', $pw)) {
    var_dump(password_verify('rasmbbuerdorf', $pw));
    echo 'La contraseña es válida!';
} else {
    echo 'La contraseña no es válida.';
}
