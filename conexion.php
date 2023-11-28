<?php 
	function dbConnect(){
	$con= mysqli_connect("localhost", "adm_webgenerator", "webgenerator2020", "webgenerator");
	return $con;
	}
 ?>