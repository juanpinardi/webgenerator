<?php 
	require 'conexion.php';
	session_start();
	
	date_default_timezone_set('America/Argentina/Buenos_Aires');

	$mensaje="";
	
	if (isset($_POST['btn'])) {
		
	 $email= trim($_POST['Email']);
     $contra = $_POST['Contra'];
     $recontra = $_POST['reContra'];
     $fechaRegistro = date('Y-m-d H:i:s');
     	
   	
      $db= dbConnect();

   	  $usuario = "SELECT `idUsuario` FROM `usuario` WHERE `email` = '$email'";

  	  $consulta = mysqli_query($db, $usuario); 
 

	if (empty($email)||  PHP_EOL==$email  ||empty($contra)  ||PHP_EOL ==$contra ||empty($recontra) || PHP_EOL==$recontra) {
            echo "Campos sin completar";
        } else if ($contra != $recontra){
            echo "Las contraseñas no coinciden";
        } else if (mysqli_num_rows($consulta) > 0) {
        	$mensaje="El email ya esta registrado";
        } 
        else {
           
            $insert= "INSERT INTO usuario (idUsuario, email, password, fechaRegistro) VALUES (NULL, '$email', '$contra', '$fechaRegistro');";
            $db = dbConnect();
            $response = $db->query($insert);

            header('Location: login.php');
        }		
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registrarte es simple.</title>
</head>
<body>

<form method="POST">
		<h2>Registrarte es simple.</h2>
		<input type="text" name="Email" placeholder="Email">
		<input type="password" name="Contra" placeholder="Contraseña">
		<input type="password" name="reContra" placeholder="Repetir Contraseña">
		<input type="submit" name="btn" value="Registrarse">

		 <?php echo $mensaje;  ?>
</form>
</body>
</html>