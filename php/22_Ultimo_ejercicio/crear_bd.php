<?php
try {
    // Conexión inicial a MySQL sin seleccionar base de datos
    $pdo = new PDO('mysql:host=localhost', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);

    // Leer el contenido del archivo SQL
    $sql = file_get_contents('bd_pruebas.sql');

    // Ejecutar las consultas
    $resultado = $pdo->exec($sql);

    echo "¡Base de datos y tabla creadas correctamente!\n";
    echo "Los usuarios han sido insertados con éxito.\n";

} catch(PDOException $e) {
    echo "Error al ejecutar el script SQL: " . $e->getMessage() . "\n";
}
?> 