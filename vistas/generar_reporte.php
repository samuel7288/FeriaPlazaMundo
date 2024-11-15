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

// Preparar el contenido HTML
$html = '
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; color: #333; }
        .info { margin: 20px 0; }
        .categoria { margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Reporte de Ventas del Día</h1>
    <div class="info">
        <p>Fecha: ' . date('d/m/Y') . '</p>
        <p>Total de Tickets Vendidos: ' . $total_ventas . '</p>
        <p>Total en Dinero: $' . number_format($total_dinero, 2) . '</p>
    </div>
    <h2>Desglose por Categoría:</h2>
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
    $html .= '<div class="categoria">' . $categoria[0] . ': ' . $row['total'] . '</div>';
}

$html .= '</body></html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream('Reporte_Ventas_'.date('Y-m-d').'.pdf', array('Attachment' => true));
?>