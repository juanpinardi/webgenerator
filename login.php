<?php 
	require 'conexion.php';
	    
	if (isset($_POST['btn'])) {
		$email=trim($_POST['Email']);
		$contra=$_POST['Contra'];
	 		
		if (empty($email)||  PHP_EOL==$email  ||empty($contra)  ||PHP_EOL ==$contra) {
	    	echo "Campos sin completar";
		} else{
			$db = dbConnect();
			$consulta = mysqli_query ($db, "SELECT * FROM usuario WHERE email = '$email' AND password = '$contra'"); 
			if(!$consulta) {
	    	  	echo mysqli_error($mysqli);
	     	  	exit;
			}if(mysqli_num_rows($consulta) > 0) {
				session_start();
				$_SESSION['email'] = $email;
				header('Location: panel.php');
			} else {
	  			echo " Datos erroneos";
			}
	}	
}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>WebGenerator | Pinardi Juan</title>
</head>
<body>
	<h1>WebGenerator | Pinardi Juan</h1>
	<form method="POST">
		<input type="text" name="Email" placeholder="email">
		<input type="password" name="Contra" placeholder="contraseña">
		<input type="submit" name="btn" value="Iniciar Sesion">
		<h2>No tienes una cuenta?, <a href="register.php">Crear cuenta</a> </h2>
	</form>
</body>
</html>