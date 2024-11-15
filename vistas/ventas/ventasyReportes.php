<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Ventas.php";

	$c= new conectar();
	$conexion=$c->conexion();

	$obj= new ventas();

	$sql="SELECT id_venta,
				fechaCompra,
				id_edad
			from ventas group by id_venta";
	$result=mysqli_query($conexion,$sql); 
	?>

<!DOCTYPE html>
<html>
<head>
	<title>Reportes y ventas</title>
	<link rel="stylesheet" type="text/css" href="../../css/styles.css">
	<link rel="stylesheet" type="text/css" href="../../librerias/bootstrap/css/bootstrap.css">
</head>
<body>
<h4>Reportes y ventas</h4>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
				<caption><label>Ventas :)</label></caption>
				<tr>
					<td>Folio</td>
					<td>Fecha</td>
					<td>Edad</td>
					<td>Total de compra</td>
					<td>Ticket</td>
				</tr>
		<?php while($ver=mysqli_fetch_row($result)): ?>
				<tr>
					<td><?php echo $ver[0] ?></td>
					<td><?php echo $ver[1] ?></td>
					<td>
						<?php
							if($obj->nombreEdad($ver[2])==" "){
								echo "S/C";
							}else{
								echo $obj->nombreEdad($ver[2]);
							}
						 ?>
					</td>
					<td>
						<?php 
							echo "$".$obj->obtenerTotal($ver[0]);
						 ?>
					</td>
					<td>
						<a href="../procesos/ventas/crearReportePdf.php?idventa=<?php echo $ver[0] ?>" class="btn btn-danger btn-sm">
							Ticket <span class="glyphicon glyphicon-file"></span>
						</a>	
					</td>
				</tr>
		<?php endwhile; ?>
			</table>
		</div>
	</div>
	<div class="col-sm-1"></div>
</div>
</body>
</html>