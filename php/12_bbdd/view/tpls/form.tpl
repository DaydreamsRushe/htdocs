	<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Users fichero</title>
		<style type="text/css">
			.error{border:2px solid red;}
		</style>

	</head>
	<body>
		<form method="post" action="../controller/app.php">
			Usuario: <br><input type="text" class="{{::class_error::}}" name="usuario" value="{{::usuario::}}" /><br><br>
			Email: <br><input type="text" class="{{::class_error::}}" name="email" value="{{::email::}}" /><br><br>

			<input type="submit" name="registrar" value="Registrar" /><br>
			{{::mensaje_error::}}
			
		</form>
		
	</body>
	</html>