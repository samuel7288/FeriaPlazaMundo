<?php 
require_once "../../clases/Conexion.php";
require_once "../../clases/Ventas.php";

$objv = new ventas();

$c = new conectar();
$conexion = $c->conexion();    
$idventa = $_GET['idventa'];

$sql = "SELECT ve.id_venta, ve.fechaCompra, ve.id_edad, tic.nombre, tic.precio, tic.descripcion
        FROM ventas AS ve
        LEFT JOIN tickets AS tic ON ve.id_ticket = tic.id_ticket
        WHERE ve.id_venta = '$idventa'";

$result = mysqli_query($conexion, $sql);
$ver = mysqli_fetch_row($result);

if ($ver) {
    $folio = $ver[0];
    $fecha = $ver[1];
    $idedad = $ver[2];
} else {
    die("No se encontraron datos para la venta con ID: $idventa");
}
?>  

<!DOCTYPE html>
<html>
<head>
    <title>Reporte de venta</title>
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../../librerias/bootstrap/css/bootstrap.css">
</head>
<body>
<img src="http://localhost/ventasAlmacen/img/ruedafortuna.jpg" width="200" height="200">

    <br>
    <table class="table">
        <tr>
            <td>Fecha: <?php echo $fecha; ?></td>
        </tr>
        <tr>
            <td>Folio: <?php echo $folio; ?></td>
        </tr>
        <tr>
            <td>Edad: <?php echo $objv->nombreEdad($idedad); ?></td>
        </tr>
    </table>

    <table class="table table-bordered">
        <tr>
            <th>Nombre producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Descripción</th>
        </tr>

        <?php 
        $total = 0;
        $result = mysqli_query($conexion, $sql);
        while($mostrar = mysqli_fetch_row($result)):
        ?>
        <tr>
            <td><?php echo $mostrar[3]; ?></td>
            <td><?php echo "$".$mostrar[4]; ?></td>
            <td>1</td>
            <td><?php echo $mostrar[5]; ?></td>
        </tr>
        <?php 
            $total += $mostrar[4];
        endwhile;
        ?>
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
            <td><?php echo "$" . $total; ?></td>
        </tr>
    </table>
</body>
</html>
