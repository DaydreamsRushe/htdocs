 <?php

	$typedb = "mysql";
	$host = "localhost";
	$dbname = "pruebas";
	$user = "root";
	$pw = "";


	try {
		/* $options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_EMULATE_PREPARES => true,
		]; */
		$con = new PDO($typedb . ":host=" . $host . ";dbname=" . $dbname . ";charset=UTF8mb4", $user/* , $pw, $options */);
	} catch (PDOException $exception) {
		echo $exception->getMessage();
	}
