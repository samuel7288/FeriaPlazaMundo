<?php
session_start();
if(!isset($_SESSION['usuario'])) {
    header("location:../index.php");
    exit;
}

require_once "../vendor/autoload.php";
require_once "../config/conexion.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);

$fecha_actual = date('Y-m-d');

// Obtener datos de la base de datos
$sql = "SELECT COUNT(*) as total_ventas FROM ventas WHERE fechaCompra = '$fecha_actual'";
$result = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($result);
$total_ventas = $row['total_ventas'];

$sql_revenue = "SELECT SUM(precio) as total_dinero FROM ventas WHERE fechaCompra = '$fecha_actual'";
$result_revenue = mysqli_query($conexion, $sql_revenue);
$row_revenue = mysqli_fetch_assoc($result_revenue);
$total_dinero = $row_revenue['total_dinero'];

// Get the CSS content
$css = file_get_contents('../css/styles.css');

// Agregar esta línea antes de crear el HTML para obtener la ruta absoluta
$rutaLogo = $_SERVER['DOCUMENT_ROOT'] . '/FeriaPlazaMundo/img/logo2.jpg';
$logoBase64 = 'data:image/jpg;base64,' . base64_encode(file_get_contents($rutaLogo));

// Preparar el contenido HTML
$html = '
<html>
<head>
    <style>' . $css . '</style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <img src="' . $logoBase64 . '" class="report-logo" alt="Logo">
            <h1 class="report-title">Reporte de Ventas del Día</h1>
        </div>
        <div class="report-info">
            <p><strong>Fecha:</strong> ' . date('d/m/Y') . '</p>
            <p><strong>Total de Tickets Vendidos:</strong> ' . $total_ventas . '</p>
            <p><strong>Total en Dinero:</strong> $' . number_format($total_dinero, 2) . '</p>
        </div>
        <h2 class="report-title">Desglose por Categoría:</h2>
';

// Obtener y mostrar datos por categoría
$categorias = array(
    array("Niños", "id_edad = 1"),
    array("Adultos", "id_edad = 2"),
    array("Adultos Mayores", "id_edad = 3")
);

foreach($categorias as $categoria) {
    $sql = "SELECT COUNT(*) as total FROM ventas WHERE {$categoria[1]} AND fechaCompra = '$fecha_actual'";
    $result = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($result);
    $html .= '<div class="report-category">
                <div class="report-category-title">' . $categoria[0] . '</div>
                Total: ' . $row['total'] . '
              </div>';
}

$html .= '</div></body></html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream('Reporte_Ventas_'.date('Y-m-d').'.pdf', array('Attachment' => true));
?>