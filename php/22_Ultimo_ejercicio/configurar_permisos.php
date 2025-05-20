<?php
// Función para configurar los permisos de la carpeta pictures
function configurarPermisosCarpeta() {
    $carpeta = 'pictures';
    
    // Verificar si la carpeta existe
    if (!file_exists($carpeta)) {
        if (!mkdir($carpeta, 0777, true)) {
            die("Error: No se pudo crear la carpeta $carpeta");
        }
    }
    
    // Intentar cambiar los permisos
    if (chmod($carpeta, 0777)) {
        echo "Permisos configurados correctamente para la carpeta $carpeta\n";
    } else {
        echo "Error: No se pudieron configurar los permisos para la carpeta $carpeta\n";
        echo "Puede que necesites ejecutar este script con permisos de administrador\n";
    }
}

// Ejecutar la función
configurarPermisosCarpeta();
?> 