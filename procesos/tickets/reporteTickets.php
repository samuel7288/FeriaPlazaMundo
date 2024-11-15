
<?php 
	require_once "../../clases/Conexion.php";
	$c= new conectar();
	$conexion=$c->conexion();

	$fechaInicio = $_POST['fechaInicio'];
	$fechaFin = $_POST['fechaFin'];

	$sql="SELECT COUNT(*) as total, 
				 SUM(CASE WHEN edad < 12 THEN 1 ELSE 0 END) as ninos,
				 SUM(CASE WHEN edad BETWEEN 12 AND 60 THEN 1 ELSE 0 END) as adultos,
				 SUM(CASE WHEN edad > 60 THEN 1 ELSE 0 END) as adultos_mayores,
				 fecha
		  FROM tickets 
		  WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin'
		  GROUP BY fecha
		  ORDER BY total DESC";
	$result=mysqli_query($conexion,$sql);

	$maxVentas = 0;
	$fechaMaxVentas = '';

	while($ver=mysqli_fetch_assoc($result)) {
		if ($ver['total'] > $maxVentas) {
			$maxVentas = $ver['total'];
			$fechaMaxVentas = $ver['fecha'];
		}
		echo "<tr>
				<td>{$ver['fecha']}</td>
				<td>{$ver['total']}</td>
				<td>{$ver['ninos']}</td>
				<td>{$ver['adultos']}</td>
				<td>{$ver['adultos_mayores']}</td>
			  </tr>";
	}
	echo "<h3>Fecha con Mayor Venta: $fechaMaxVentas con $maxVentas tickets vendidos</h3>";
?>