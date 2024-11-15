<?php
require_once '../../vendor/autoload.php';
require_once "../../clases/Conexion.php";
require_once "../../clases/Ventas.php";

use Dompdf\Dompdf;

$objv = new ventas();

$c = new conectar();
$conexion = $c->conexion();    
$idventa = $_GET['idventa'];

$sql = "SELECT ve.id_venta, ve.fechaCompra, ve.id_edad, tic.nombre, tic.precio, tic.descripcion, 
        u.nombre as vendedor
        FROM ventas AS ve
        LEFT JOIN tickets AS tic ON ve.id_ticket = tic.id_ticket
        LEFT JOIN usuarios AS u ON ve.id_usuario = u.id_usuario
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

// Obtener fecha y hora actual en formato 24 horas
date_default_timezone_set('America/El_Salvador'); // Asegura la zona horaria correcta
$fechaActual = date('d/m/Y H:i:s');

$css = '
body {
    font-family: "Courier New", Courier, monospace;
    font-size: 12px;
    width: 302px;
    margin: 0 auto;
}
.header {
    text-align: center;
    margin-bottom: 10px;
}
.table {
    width: 100%;
    margin-bottom: 10px;
}
.table-bordered {
    border-top: 1px dashed #000;
    border-bottom: 1px dashed #000;
}
th, td {
    padding: 5px;
}
.thank-you {
    text-align: center;
    margin-top: 15px;
    font-weight: bold;
}';

$html = '
<!DOCTYPE html>
<html>
<head>
    <title>Ticket de venta</title>
    <style>' . $css . '</style>
</head>
<body>
    <div class="header">
        <h2>Plaza Mundo</h2>
        <p>San Salvador, El Salvador</p>
        <p>Teléfono: 23456789</p>
    </div>
    
    <table class="table">
        <tr>
            <td>Fecha de venta: ' . $fechaActual . '</td>
        </tr>
        <tr>
            <td>N de ticket: ' . $folio . '</td>
        </tr>
        <tr>
            <td>Edad: ' . $objv->nombreEdad($idedad) . '</td>
        </tr>
        <tr>
            <td>Método de pago: Efectivo</td>
        </tr>
        <tr>
            <td>Vendedor: ' . $ver[6] . '</td>
        </tr>
    </table>
    <table class="table table-bordered">
        <tr>
            <th>Nombre producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Descripción</th>
        </tr>';

$total = 0;
$result = mysqli_query($conexion, $sql);
while($mostrar = mysqli_fetch_row($result)) {
    $html .= '
        <tr>
            <td>' . $mostrar[3] . '</td>
            <td>$' . $mostrar[4] . '</td>
            <td>1</td>
            <td>' . $mostrar[5] . '</td>
        </tr>';
    $total += $mostrar[4];
}

$html .= '
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
            <td>$' . $total . '</td>
        </tr>
    </table>
    <div style="font-size: 10px; margin-top: 20px; border-top: 1px dashed #000; padding-top: 10px;">
        <p><strong>Términos y condiciones:</strong></p>
        <p>La entrada a la feria está sujeta a la adquisición de un ticket válido.</p>
    </div>
    <div class="thank-you">
        ¡Gracias por su compra!
    </div>
</body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_venta_$idventa.pdf", array("Attachment" => false));
?>



