<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Edades.php";

	$obj= new edades();

	echo json_encode($obj->obtenDatosEdad($_POST['idedad']));

 ?>