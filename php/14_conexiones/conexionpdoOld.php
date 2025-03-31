<?php
/* require_once "config.php"; */
$typedb = "mysql";
$host = "localhost";
$dbname = "users2025";
$user = "root";
$pw = "";


try {
      $con = new PDO($typedb . ":host=" . $host . ";dbname=" . $dbname . ";charset=UTF8mb4", $user, $pw);

      /*     $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      ); */
      /*   $con = new PDO(DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=UTF8", DB_USER, DB_PASS); */
      echo "OLE!!!";
} catch (PDOException $exception) {
      echo $exception->getMessage();
}
