<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Edades.php";

	$obj= new edades();


	$datos=array(
			$_POST['nombre'],
			$_POST['edadMin'],
			$_POST['edadMax']			
				);

	echo $obj->agregaEdad($datos);

	
	
 ?>