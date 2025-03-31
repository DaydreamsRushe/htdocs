<?php

$typedb = "mysql";
$host = "localhost";
$user = "root";
$pw = "";
$dbname = new PDO($typedb . ":host=" . $host, $user, $pw);

try {
  $create = $dbname->query("CREATE DATABASE IF NOT EXISTS newusers DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
  echo "Creato";
} catch (PDOException $exception) {
  echo $exception->getMessage();
}

try {
  $create = $dbname->query("USE newusers;");
  $create = $dbname->query("CREATE TABLE  IF NOT EXISTS usuarios (
  id INT(3) PRIMARY KEY AUTO_INCREMENT,
  usuario VARCHAR(20) NOT NULL,
  email VARCHAR(33) NOT NULL
) ENGINE=InnoDB;");
  echo "Creato";
} catch (PDOException $exception) {
  echo $exception->getMessage();
}

try {
  $create = $dbname->query("INSERT INTO usuarios VALUES (NULL,'PEPE', 'emaildepepe'),
(NULL,'Pepiño', 'emaildepeepiño')");
  echo "Creato";
} catch (PDOException $exception) {
  echo $exception->getMessage();
}
