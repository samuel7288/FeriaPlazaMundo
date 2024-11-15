<?php
session_start();
if(!isset($_SESSION['usuario'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

require_once "../config/conexion.php";

$start = mysqli_real_escape_string($conexion, $_GET['start']);
$end = mysqli_real_escape_string($conexion, $_GET['end']);

// Obtener datos reales de la base de datos - usando DATE() para comparación exacta
$sql = "SELECT DATE(fechaCompra) as fecha, COUNT(*) as total 
        FROM ventas 
        WHERE DATE(fechaCompra) BETWEEN DATE('$start') AND DATE('$end') 
        GROUP BY DATE(fechaCompra) 
        ORDER BY fecha";

$result = mysqli_query($conexion, $sql);
$datos_reales = [];
while($row = mysqli_fetch_assoc($result)) {
    $datos_reales[$row['fecha']] = intval($row['total']);
}

// Obtener el total real de tickets vendidos hoy
$hoy = date('Y-m-d');
$sql_hoy = "SELECT COUNT(*) as total_ventas FROM ventas WHERE DATE(fechaCompra) = '$hoy'";
$result_hoy = mysqli_query($conexion, $sql_hoy);
$row_hoy = mysqli_fetch_assoc($result_hoy);
$total_ventas_hoy = $row_hoy['total_ventas'];

// Generar array de todas las fechas en el rango
$fechas = [];
$tickets = [];
$fecha_actual = new DateTime($start);
$fecha_fin = new DateTime($end);

while($fecha_actual <= $fecha_fin) {
    $fecha_str = $fecha_actual->format('Y-m-d');
    $fechas[] = $fecha_str;
    
    if($fecha_str === $hoy) {
        // Para el día actual, usar el total del día actual
        $tickets[] = $total_ventas_hoy;
    } 
    elseif(isset($datos_reales[$fecha_str])) {
        // Usar datos reales exactos de ese día
        $tickets[] = $datos_reales[$fecha_str];
    } 
    else {
        // Solo generar datos simulados para fechas anteriores al día actual
        if($fecha_str < $hoy) {
            $day = $fecha_actual->format('N');
            $week = ceil($fecha_actual->format('d') / 7);
            
            $base = rand(100, 500);
            $day_factor = ($day >= 6) ? 2.5 : 1;
            $week_factor = 1 + ($week * 0.2);
            
            $total = min(
                round($base * $day_factor * $week_factor * (1 + (rand(-20, 20) / 100))),
                83333
            );
            
            $tickets[] = $total;
        } else {
            // Para fechas futuras, mostrar 0
            $tickets[] = 0;
        }
    }
    
    $fecha_actual->modify('+1 day');
}

$response = [
    'fechas' => $fechas,
    'tickets' => $tickets
];

header('Content-Type: application/json');
echo json_encode($response);
?>