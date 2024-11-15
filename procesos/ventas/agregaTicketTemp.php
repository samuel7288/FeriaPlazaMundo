<?php 
	session_start();
	require_once "../../clases/Conexion.php";

	$c= new conectar();
	$conexion=$c->conexion();

	$idedad=$_POST['edadVenta'];
	$idticket=$_POST['ticketVenta'];
	$descripcion=$_POST['descripcionV'];
	$cantidad=$_POST['cantidadV'];
	$precio=$_POST['precioV'];

	$sql="SELECT nombre 
			from edad 
			where id_edad='$idedad'";
	$result=mysqli_query($conexion,$sql);

	$c=mysqli_fetch_row($result);

	$nedad=$c[1]." ".$c[0];

	$sql="SELECT nombre 
			from tickets 
			where id_ticket='$idticket'";
	$result=mysqli_query($conexion,$sql);

	$nombreticket=mysqli_fetch_row($result)[0];

	$ticket=$idticket."||".
				$nombreticket."||".
				$descripcion."||".
				$precio."||".
				$nedad."||".
				$idedad;

	$_SESSION['tablaComprasTemp'][]=$ticket;

 ?>