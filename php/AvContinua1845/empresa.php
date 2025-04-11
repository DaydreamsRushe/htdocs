<?php

/* Realizamos una la conexion al servidor mysqli pero a ninguna base de datos */
$host = "localhost";
$user = "root";
$pass = "";
$bd = ""; 

$con = new mysqli($host, $user, $pass, $bd);

if ($con->connect_errno) {
    die('Error de conexión (' . $con->connect_errno . ') ' . $con->connect_error);
}

echo "La conexion se ha realizado correctamente";

/* Nos deshacemos de la base de datos si ya existia y la creamos de cero */
$selectQuery = "DROP DATABASE IF EXISTS empresa";
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result);

$selectQuery = "CREATE DATABASE empresa DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result) . "Nueva base de datos creada";

$con->query("USE empresa"); 

/* Creamos la nueva tabla */
$selectQuery = "CREATE TABLE personal
(
  codi INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(20) NOT NULL,
  cognoms VARCHAR(40) NOT NULL,
  data_naixement DATE,
  salari DECIMAL(4,2),
  CONSTRAINT unic_nom_cog UNIQUE (nom, cognoms),
  CONSTRAINT sal_pos CHECK(salari>0)
)ENGINE=InnoDB";
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result) . "Tabla de personal creada";

echo "<br><br>";
echo "Empezamos con las inserciones";

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Josep','Font',null,1867.56)";
echo $selectQuery;
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result) . "Insercion sin problemas";

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Jordi','Vila','1979/2/20',1243.06)";
echo $selectQuery;
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result) . "Insercion sin problemas";

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Anna','Torner',null,1243.06)";
echo $selectQuery;
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result) . "Insercion sin problemas";

echo "<br><br>";
$selectQuery ="INSERT INTO personal (nom,cognoms) VALUES ('Miquel','Ferrando');";
echo $selectQuery;
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result) . "Insercion sin problemas";

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Carla',null,'1968/4/13',1765.00)";
echo $selectQuery;
/* $result = $con->query($selectQuery);  */
echo "<br>";
echo "Estos valores no se pueden introducir ya que el apellido es nulo, algo que esta prohibido en la tabla que hemos creado <br> Para solucionarlo, podemos añadir este apellido como un string vacio <br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Carla','','1968/4/13',1765.00)";
echo $selectQuery;
$result = $con->query($selectQuery); 

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Gerard','Codina','1974/5/27',1402.89);";
echo $selectQuery;
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result) . "Insercion sin problemas";

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (6,'Mercè','Vila','1978/6/27',1765.00);";
echo $selectQuery;
/* $result = $con->query($selectQuery);  */
echo "<br>";
echo "Estos valores no se pueden introducir porque ya hemos introducido 6 registros en nuestra tabla. Como el dato 'codi' es la clave primaria y tiene auto-incremento, este ha llegado al valor 6 y al intentar introducir este valor de nuevo nos da error por duplicar la clave primaria <br> Para solucionarlo, alterar el valor del ultimo registro y asi podemos introducir este con el valor deseado <br>";
$selectQuery = "UPDATE personal SET codi = 7 WHERE codi = 6";
echo $selectQuery;
echo "<br>";
$result = $con->query($selectQuery);
echo var_dump($result);
echo "<br>";
$selectQuery ="INSERT INTO personal VALUES (6,'Mercè','Vila','1978/6/27',1765.00);";
echo $selectQuery;
$result = $con->query($selectQuery);

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Anna',null,null,'1973/2/1')";
echo $selectQuery;
echo "<br>";
echo "Estos valores no se pueden introducir porque el apellido es nulo, como en el primer problema que teniamos el valor del salario parece aceptarlo a pesar de tener un formato de fecha ya que lo interpreta como un valor numerico<br> Para solucionarlo, introducimos el apellido como un string vacio, el cual no interfiere con el constraint definido entre el nombre y apellido de los datos <br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Anna','',null,'1973/2/1')";
echo $selectQuery;
echo "<br>";
$result = $con->query($selectQuery);
echo var_dump($result);

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (15,'Marta','Casas',null,null)";
echo $selectQuery;
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result) . "Insercion sin problemas";

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Joel','Codina','1981/2/14',1402.89)";
echo $selectQuery;
$result = $con->query($selectQuery); 
echo "<br>";
echo var_dump($result) . "Insercion sin problemas";

echo "<br><br>";
$selectQuery ="INSERT INTO personal VALUES (null,'Marta','Pérez','1992/2/20',0.00);";
echo $selectQuery;
echo "<br>";
echo "Estos valores no se pueden introducir porque el salario esta tiene una restricción en la que tiene que ser mayor de 0, lo cual significa que no puede tener valor 0 <br> Para solucionarlo, podemos introducir estos valores con 0.01 en el salario, o podemos alterar la tabla para que el salario pueda ser 0, pero no negativo <br>";
$selectQuery ="ALTER TABLE personal DROP CONSTRAINT sal_pos";
echo $selectQuery;
echo "<br>";
$result = $con->query($selectQuery);
$selectQuery ="ALTER TABLE personal ADD CONSTRAINT sal_pos CHECK (salari>=0)";
echo $selectQuery;
echo "<br>";
$result = $con->query($selectQuery);
$selectQuery ="INSERT INTO personal VALUES (null,'Marta','Pérez','1992/2/20',0.00)";
echo $selectQuery;
echo "<br>";
$result = $con->query($selectQuery);
echo var_dump($result);


?>