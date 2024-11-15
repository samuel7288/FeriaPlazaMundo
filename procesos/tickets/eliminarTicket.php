<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Tickets.php";
$idtic=$_POST['idticket'];

	$obj=new tickets();

	echo $obj->eliminaTicket($idtic);

 ?>