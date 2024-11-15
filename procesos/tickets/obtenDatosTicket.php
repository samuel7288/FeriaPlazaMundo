<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Tickets.php";

	$obj= new tickets();


	$idtic=$_POST['idtic'];

	echo json_encode($obj->obtenDatosTicket($idtic));

 ?>