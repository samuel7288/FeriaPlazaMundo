<?php 
	
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Ventas.php";

	$obj= new ventas();

	echo json_encode($obj->obtenDatosTicket($_POST['idticket']))

 ?>