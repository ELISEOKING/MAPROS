<?php
require_once("../Conexion/Conexion.php");
$conn = Connetion::Conexcion();

$stmtMultimedia = $conn->query("SELECT COUNT(*) as total FROM multimedia");
$totalMultimedia = $stmtMultimedia->fetch(PDO::FETCH_ASSOC)['total'];

$stmtFechas = $conn->query("
    SELECT DATE(fecha_seleccion) as fecha, COUNT(*) as total 
    FROM contenidos 
    GROUP BY DATE(fecha_seleccion) 
    ORDER BY fecha ASC
");
$fechas = [];
$totales = [];
while ($row = $stmtFechas->fetch(PDO::FETCH_ASSOC)) {
    $fechas[] = $row['fecha'];
    $totales[] = $row['total'];
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <style>
        .card h2 {
            font-weight: 600;
            font-size: 2.2rem;
        }
        .card h5 {
            font-weight: 500;
            font-size: 1.2rem;
        }
        .card {
            border-radius: 12px;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="body-overlay"></div>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0a47CvuB459su5Io-M3ptqwXeTd2qYeDKuA&s" 
                     class="img-fluid" style="width: 120px;" />
            </h3>
        </div>
        <ul class="list-unstyled components">
            <li class="active">
                <a href="#" class="dashboard"><i class="material-icons">dashboard</i> <span>Dashboard</span></a>
            </li>
            <li><a href="../Home/Contenido.php"><i class="material-icons">date_range</i><span>CONTENIDOS</span></a></li>
            <li><a href="../Home/Ruta.php"><i class="material-icons">library_books</i><span>RUTA</span></a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div id="content">
        <!-- Navbar -->
        <div class="top-navbar">
            <div class="xp-topbar">
                <div class="row">
                    <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                        <div class="xp-menubar">
                            <span class="material-icons text-white">signal_cellular_alt</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="xp-breadcrumbbar text-center">
                <h4 class="page-title">Dashboard</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Sistema</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>

        <!-- Contenido de las tarjetas -->
        <div class="main-content px-3">
            <div class="row">
                <!-- Gráfico de Contenidos -->
                <div class="col-md-8 mb-4">
                    <div class="card p-3 shadow-sm">
                        <h5 class="text-center">Contenidos por Fecha</h5>
                        <canvas id="contenidoChart" height="240"></canvas>
                    </div>
                </div>
                <!-- Gráfico de Multimedia -->
                <div class="col-md-4 mb-4">
                    <div class="card p-3 shadow-sm">
                        <h5 class="text-center">Archivos Multimedia</h5>
                        <h2 class="text-center text-success"><?php echo $totalMultimedia; ?></h2>
                        <canvas id="multimediaChart" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer mt-4">
            <div class="container-fluid">
                <div class="footer-in text-center">
                    <p class="mb-0">&copy; 2025 Sistema — Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Scripts -->
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const fechas = <?php echo json_encode($fechas); ?>;
    const totales = <?php echo json_encode($totales); ?>;
    const totalMultimedia = <?php echo $totalMultimedia; ?>;

    // Chart de Contenidos por fecha
    new Chart(document.getElementById('contenidoChart'), {
        type: 'bar',
        data: {
            labels: fechas,
            datasets: [{
                label: 'Contenidos agregados',
                data: totales,
                backgroundColor: '#007bff',
                borderColor: '#0056b3',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    new Chart(document.getElementById('multimediaChart'), {
        type: 'doughnut',
        data: {
            labels: ['Multimedia'],
            datasets: [{
                data: [totalMultimedia],
                backgroundColor: ['#28a745'],
                borderColor: ['#1e7e34'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

</body>
</html>
