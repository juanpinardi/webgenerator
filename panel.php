<?php 
	require 'conexion.php';
	session_start();

	date_default_timezone_set('America/Argentina/Buenos_Aires');
	$mensaje="";

	  if ( !isset( $_SESSION['email'] ) ) {
    	header("location: login.php");
  	  } 
  	
  	  $email= $_SESSION['email'];

  	  $db = dbConnect();

  	  $usuario = "SELECT `idUsuario` FROM `usuario` WHERE `email` = '$email'";

  	  $consulta = mysqli_query($db, $usuario); 

  	  $idUser = mysqli_fetch_array($consulta,MYSQLI_NUM);

  	  $nomWeb="";

  	 if (isset($_POST['btn'])) {
		$nomWeb=$_POST['nombre'];
		$fechaCreacion= date('Y-m-d H:i:s');


		$db = dbConnect();

		$veri = "SELECT `idUsuario` FROM `webs` WHERE  `dominio` = '$nomWeb'";
		$consulta= mysqli_query($db, $veri);
  	  	
		if(mysqli_num_rows($consulta) > 0) {
			$mensaje="Nombre ya registrado";
		}else{
			$web = "INSERT INTO `webs` (`idWeb`, `idUsuario`, `dominio`, `fechaCreacion`) VALUES (NULL, '$idUser[0]', '$nomWeb', '$fechaCreacion')";

  	  		$consulta2 = mysqli_query($db, $web); 
	 		
  	  		if($consulta2){
		 		
		 		shell_exec('chmod 757 $nomWeb'); 
		 		shell_exec("./wix.sh $nomWeb $nomWeb");
		 		echo '<p>Se registro el dominio correctamente</p>';

			}else{
				$mensaje="Ocurrio un error";
			}
		}
	}
  ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Panel</title>
</head>
<body>
	<h1>Bienvenido a tu panel </h1>
	<style > a{text-decoration: none};</style>
<form method="POST">
		<h2>Generador Web de: 
		<input type="text" name="nombre"> 
		<input type="submit" name="btn" value="Generar Web"></h2>
		<?php echo $mensaje; ?>
		<br>
		<a href="logout.php">Cerrar Sesion</a>  <?php echo $idUser[0];?>
		
</form>
<?php  
	if ($email == "admin@server.com") {

  			echo "<h3>Dominios Creados por los usuarios: </h3>";
  			$ssql = "SELECT * FROM `webs`";
  			$res = mysqli_query($db, $ssql);

  			if ($res->num_rows > 0) {
  				while ($fila = $res->fetch_assoc()) {
  					echo '<a href=' . $fila["dominio"] . '>' . '<h2>' . $fila["dominio"] . '</h2>' . '</a>';
  					echo '<a href=descarga.php?web=' . $fila["dominio"] . '>' . 'descargar ' . '</a> ';
  					echo '<a href=eliminar.php?web=' . $fila["dominio"] . '>' . ' eliminar' . '</a>';
  				}
  	}
  	}else{

	echo "<h3>Dominios Creados: </h3>";

  	$ssql="SELECT * FROM `webs` WHERE webs.idUsuario = '$idUser[0]'";
    $res=mysqli_query($db,$ssql);	
  	if (mysqli_num_rows($res)>0) {
  			while($fila=mysqli_fetch_array($res,MYSQLI_ASSOC)){
	  			echo '<a href='.$fila["dominio"].'>'.'<h2>'.$fila["dominio"].'</h2>'.'</a>';
	  			echo '<a href=descarga.php?web='.$fila["dominio"].'>'.'descargar '.'</a> ';
	  			echo '<a href=eliminar.php?web='.$fila["dominio"].'>'.' eliminar'.'</a>';
  		}
  	}  
}
  ?>
</body>
</html>
