<?php 

require_once "../../clases/Conexion.php";
require_once "../../clases/Tickets.php";

$obj= new tickets();

$datos=array(
		$_POST['idTicket'],
	    $_POST['categoriaSelectU'],
	    $_POST['nombreU'],
	    $_POST['descripcionU'],
	    $_POST['cantidadU'],
	    $_POST['precioU']
			);

    echo $obj->actualizaTicket($datos);

 ?>