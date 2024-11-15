<?php 
    session_start();
    if(isset($_SESSION['usuario'])){
        require_once "../config/conexion.php";
        $fecha_actual = date('Y-m-d');
        
        // Query para obtener total de tickets vendidos hoy
        $sql = "SELECT COUNT(*) as total_ventas FROM ventas WHERE fechaCompra = '$fecha_actual'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($result);
        $total_ventas = $row['total_ventas'];
        
        // Query para obtener el total de dinero recaudado hoy
        $sql_revenue = "SELECT SUM(precio) as total_dinero FROM ventas WHERE fechaCompra = '$fecha_actual'";
        $result_revenue = mysqli_query($conexion, $sql_revenue);
        $row_revenue = mysqli_fetch_assoc($result_revenue);
        $total_dinero = $row_revenue['total_dinero'];
        
        // Query para obtener total de tickets vendidos por edades
        $sql_children = "SELECT COUNT(*) as total_ninos FROM ventas WHERE id_edad = 1 AND fechaCompra = '$fecha_actual'";
        $result_children = mysqli_query($conexion, $sql_children);
        $row_children = mysqli_fetch_assoc($result_children);
        $total_ninos = $row_children['total_ninos'];
        
        $sql_adults = "SELECT COUNT(*) as total_adultos FROM ventas WHERE id_edad = 2 AND fechaCompra = '$fecha_actual'";
        $result_adults = mysqli_query($conexion, $sql_adults);
        $row_adults = mysqli_fetch_assoc($result_adults);
        $total_adultos = $row_adults['total_adultos'];
        
        $sql_seniors = "SELECT COUNT(*) as total_adultos_mayores FROM ventas WHERE id_edad = 3 AND fechaCompra = '$fecha_actual'";
        $result_seniors = mysqli_query($conexion, $sql_seniors);
        $row_seniors = mysqli_fetch_assoc($result_seniors);
        $total_adultos_mayores = $row_seniors['total_adultos_mayores'];

        // Queries para totales por período
        // Total semana
        $sql_semana = "SELECT COUNT(*) as total_semana, SUM(precio) as dinero_semana 
                       FROM ventas 
                       WHERE fechaCompra >= DATE_SUB('$fecha_actual', INTERVAL 7 DAY)";
        $result_semana = mysqli_query($conexion, $sql_semana);
        $row_semana = mysqli_fetch_assoc($result_semana);
        $total_semana = $row_semana['total_semana'];
        $dinero_semana = $row_semana['dinero_semana'];

        // Total mes
        $sql_mes = "SELECT COUNT(*) as total_mes, SUM(precio) as dinero_mes 
                    FROM ventas 
                    WHERE MONTH(fechaCompra) = MONTH('$fecha_actual') 
                    AND YEAR(fechaCompra) = YEAR('$fecha_actual')";
        $result_mes = mysqli_query($conexion, $sql_mes);
        $row_mes = mysqli_fetch_assoc($result_mes);
        $total_mes = $row_mes['total_mes'];
        $dinero_mes = $row_mes['dinero_mes'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>inicio</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php require_once "menu.php"; ?>
    <script>
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('live-datetime').innerHTML = now.toLocaleDateString('es-ES', options);
        }

        // Update every second
        setInterval(updateDateTime, 1000);
    </script>
    <style>
        .pdf-button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px 0;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .pdf-button:hover {
            background-color: #c82333;
        }
    </style>
    
    <!-- Agregar DateRangePicker y Chart.js -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        .date-range-container {
            margin: 20px 0;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .chart-container {
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        #daterange {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 200px;
        }
        
        .tables-grid {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }
        
        .tables-grid .table-section {
            flex: 1;
            margin: 0; /* Removing individual margins */
        }
        
        .table-container {
            height: 100%;
        }
        
        /* Ajustar ancho de las tablas para que se ajusten mejor */
        .data-table {
            width: 100%;
        }
        
        /* Asegurar que las tablas tengan el mismo alto */
        .table-section .data-table tbody {
            height: calc(100% - 50px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <div class="header-content">
                <div class="title-section">
                    <i class="fas fa-tachometer-alt dashboard-icon"></i>
                    <h1>Panel de Control</h1>
                </div>
                <p class="current-date" id="live-datetime"></p>
                <button onclick="generarPDF()" class="pdf-button">
                    <i class="fas fa-file-pdf"></i>
                    Generar Reporte PDF
                </button>
            </div>
        </div>
        
        <div class="dashboard-content">
            <div class="card primary">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="card-title">Tickets Vendidos Hoy</h5>
                        <h1 class="display-4"><?php echo $total_ventas; ?></h1>
                        <div class="card-trend">
                            <i class="fas fa-chart-line"></i>
                            <span>Ventas del día</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card success">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="card-title">Total en Dinero</h5>
                        <h1 class="display-4">$<?php echo number_format($total_dinero, 2); ?></h1>
                        <div class="card-trend">
                            <i class="fas fa-chart-bar"></i>
                            <span>Ingresos del día</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card info">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="card-title">Tickets Niños</h5>
                        <h1 class="display-4"><?php echo $total_ninos; ?></h1>
                        <div class="card-trend">
                            <i class="fas fa-users"></i>
                            <span>Categoría infantil</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card warning">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="card-title">Tickets Adultos</h5>
                        <h1 class="display-4"><?php echo $total_adultos; ?></h1>
                        <div class="card-trend">
                            <i class="fas fa-users"></i>
                            <span>Categoría adultos</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card danger">
                <div class="card-body">
                    <div class="card-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="card-title">Tickets Adultos Mayores</h5>
                        <h1 class="display-4"><?php echo $total_adultos_mayores; ?></h1>
                        <div class="card-trend">
                            <i class="fas fa-users"></i>
                            <span>Categoría adultos mayores</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tables-grid">
            <div class="table-section">
                <h2 class="section-title">Análisis de Ventas por Categoría</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Categoría</th>
                                <th>Cantidad</th>
                                <th>Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_general = $total_ninos + $total_adultos + $total_adultos_mayores;
                            $categorias = [
                                ['Niños', $total_ninos, '#4299e1'],
                                ['Adultos', $total_adultos, '#48bb78'],
                                ['Adultos Mayores', $total_adultos_mayores, '#ed8936']
                            ];

                            foreach($categorias as $cat) {
                                $porcentaje = $total_general > 0 ? round(($cat[1] * 100) / $total_general, 1) : 0;
                                echo "<tr>";
                                echo "<td class='category-name'><span class='category-dot' style='background-color: {$cat[2]}'></span>{$cat[0]}</td>";
                                echo "<td class='quantity'>{$cat[1]}</td>";
                                echo "<td class='percentage'><div class='progress-bar' style='width: {$porcentaje}%; background-color: {$cat[2]}'></div><span>{$porcentaje}%</span></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Total</strong></td>
                                <td><strong><?php echo $total_general; ?></strong></td>
                                <td><strong>100%</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="table-section">
                <h2 class="section-title">Resumen de Ventas por Período</h2>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Período</th>
                                <th>Total Tickets</th>
                                <th>Total Dinero</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Hoy</strong></td>
                                <td><?php echo $total_ventas; ?></td>
                                <td>$<?php echo number_format($total_dinero, 2); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Esta Semana</strong></td>
                                <td><?php echo $total_semana; ?></td>
                                <td>$<?php echo number_format($dinero_semana, 2); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Este Mes</strong></td>
                                <td><?php echo $total_mes; ?></td>
                                <td>$<?php echo number_format($dinero_mes, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="date-range-container">
            <h2 class="section-title">Análisis por Rango de Fechas</h2>
            <input type="text" id="daterange" name="daterange" />
        </div>
        
        <div class="chart-container">
            <canvas id="ticketsChart"></canvas>
        </div>
    </div>

    <script>
        function generarPDF() {
            window.location.href = 'generar_reporte.php';
        }
        // Update every second
        setInterval(updateDateTime, 1000);
        
        $(function() {
            // Inicializar DateRangePicker
            $('#daterange').daterangepicker({
                startDate: moment().subtract(7, 'days'),
                endDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Cancelar',
                    customRangeLabel: 'Rango Personalizado',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                               'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
                }
            }, actualizarGrafico);
            
            // Función para actualizar el gráfico
            function actualizarGrafico(start, end) {
                fetch(`obtener_datos_grafico.php?start=${start.format('YYYY-MM-DD')}&end=${end.format('YYYY-MM-DD')}`)
                    .then(response => response.json())
                    .then(data => {
                        const ctx = document.getElementById('ticketsChart').getContext('2d');
                        
                        if (window.myChart) {
                            window.myChart.destroy();
                        }
                        
                        window.myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.fechas,
                                datasets: [{
                                    label: 'Tickets Vendidos',
                                    data: data.tickets,
                                    borderColor: '#4299e1',
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Tickets Vendidos por Fecha'
                                    }
                                }
                            }
                        });
                    });
            }
            
            // Cargar gráfico inicial
            actualizarGrafico($('#daterange').data('daterangepicker').startDate, 
                            $('#daterange').data('daterangepicker').endDate);
        });
    </script>
</body>
</html>
<?php 
    }else{
        header("location:../index.php");
    }
?>
