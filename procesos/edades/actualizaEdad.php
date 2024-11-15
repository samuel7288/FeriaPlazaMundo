<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Edades.php";

	$obj= new edades();


	$datos=array(
			$_POST['idedadU'],
			$_POST['nombreU'],
			$_POST['edadMinU'],
			$_POST['edadMaxU']	
				);

	echo $obj->actualizaEdad($datos);

	
	
 ?>