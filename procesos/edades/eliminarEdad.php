<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Edades.php";

	$obj= new edades();

	
	echo $obj->eliminaEdad($_POST['idedad']);
 ?>