<?php 
	session_start();
		require ('conexion.php');
		 if (!isset($_SESSION['email'])) {
	 		header("Location: login.php");
	 }

	 if (isset($_GET['web'])) {
	 	$web= $_GET['web'];
	 	if ($_GET['web']) {
	 	$sql="DELETE FROM webs WHERE `webs`.`dominio` = '$web'";
	 	shell_exec("rm -r $web ");
	 	if (file_exists("$web.zip")) {
	 		shell_exec("rm -r $web.zip");

	 	}
	 	shell_exec("rm -r $web ");
	 	mysqli_query($conn,$sql);
	 	header("Location: panel.php");
	 	}
	 }
 ?>