<?php

function configurarPermisosCarpeta(){
  $carpeta = "pictures";

  //verificar si la carpeta existe
  if(!file_exists($carpeta)){
    if(!mkdir($carpeta,0777, true)){
      die("Error: no se pudo crear la carpeta $carpeta");
    }
  }

  //intentar cambiar los permisos
  if(chmod($carpeta, 0777)){
    echo "Permisos configurados correctamente para la carpeta $carpeta\n";
  }else{
    echo "Error: no se ha podido configurar los permisos para la carpeta $carpeta\n";
    echo "puede que necesites ejecutar este script con permisos de administrador\n";
  }
}

//Ejecutar la funcion
configurarPermisosCarpeta();

?>