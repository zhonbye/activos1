{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario - Sistema de Activos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-stats {
            border-radius: 0.75rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card-stats:hover {
            transform: translateY(-3px);
        }
        .badge-status {
            font-size: 0.85rem;
            padding: 0.4em 0.6em;
            border-radius: 0.5rem;
        }
        .table thead th {
            vertical-align: middle;
        }
        .dashboard-header {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<div class="container-fluid p-4">
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <h2 class="fw-bold">Panel de Usuario</h2>
        <span class="text-muted">Bienvenido, Juan Pérez</span>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-stats bg-primary text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Activos Totales</h6>
                        <h3>1,245</h3>
                    </div>
                    <i class="bi bi-box-seam fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-success text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Entregas</h6>
                        <h3>312</h3>
                    </div>
                    <i class="bi bi-hand-thumbs-up fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-warning text-dark p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Traslados</h6>
                        <h3>84</h3>
                    </div>
                    <i class="bi bi-arrow-left-right fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats bg-danger text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Bajas</h6>
                        <h3>27</h3>
                    </div>
                    <i class="bi bi-trash fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Activos Recientes -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Activos Recientes</h5>
            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle"></i> Nuevo Activo</button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Unidad/Servicio</th>
                            <th>Estado Físico</th>
                            <th>Situación</th>
                            <th>Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AMD-EMG-001</td>
                            <td>Computadora Dell</td>
                            <td>Hardware</td>
                            <td>Tecnología</td>
                            <td>Bueno</td>
                            <td><span class="badge bg-success badge-status">Activo</span></td>
                            <td>05/11/2025</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>AMD-EMG-002</td>
                            <td>Proyector Epson</td>
                            <td>Equipos</td>
                            <td>Auditorio</td>
                            <td>Regular</td>
                            <td><span class="badge bg-secondary badge-status">En Uso</span></td>
                            <td>01/10/2025</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>AMD-EMG-003</td>
                            <td>Scanner HP</td>
                            <td>Hardware</td>
                            <td>Archivo</td>
                            <td>Malo</td>
                            <td><span class="badge bg-danger badge-status">Baja</span></td>
                            <td>12/08/2025</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <!-- Más filas de ejemplo -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Panel de Resumen Rápido de Movimientos -->
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card text-white bg-info p-3">
                <h6>Devoluciones Recientes</h6>
                <p class="fs-4 mb-1">15</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-secondary p-3">
                <h6>Inventarios</h6>
                <p class="fs-4 mb-1">23</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark p-3">
                <h6>Documentos Pendientes</h6>
                <p class="fs-4 mb-1">8</p>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}



































{{--
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Usuario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"> --}}

    <style>
        /* body {
            background-color: #f8f9fa;
        } */

        .card-stats {
            border-radius: 12px;
            transition: transform .2s;
        }

        .card-stats:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-weight: 600;
        }

        .display-5 {
            font-size: 2.2rem;
            font-weight: bold;
        }

        .chart-card {
            border-radius: 12px;
        }
    </style>
</head>

{{-- <body> --}}
    <div class="container-fluid py-4">
        <!-- 🔹 Sección de Bienvenida -->
        {{-- <div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm p-3 d-flex flex-row align-items-center"
             style="border-radius:12px; background-color:#e9f2fb;">

            <!-- Icono o foto de usuario -->
            <div class="me-3">
                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                     style="width:60px; height:60px; font-size:1.5rem;">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>

            <!-- Texto de bienvenida -->
            <div class="flex-grow-1">
                <h5 class="mb-1 fw-bold" style="color:#0d6efd;">¡Bienvenido, {{ auth()->user()->name }}!</h5>
                <p class="mb-0 text-muted">Aquí puedes ver tus activos, entregas, traslados y más.</p>
            </div>

            <!-- Botón rápido o icono opcional -->
            <div>
                <i class="bi bi-gear fs-4 text-secondary" title="Configuración"></i>
            </div>
        </div>
    </div>
</div> --}}

        <!-- 🔹 Sección de Bienvenida Usuario -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 rounded-4 shadow-sm d-flex align-items-center justify-content-between"
                    style="background: linear-gradient(90deg, #e3f2fd, #ffffff);">

                    <!-- Bienvenida -->
                    <div>
                        <h4 class="fw-bold mb-1 text-primary">👋 ¡Bienvenido, {{ Auth::user()->usuario }}!</h4>
                        <p class="text-muted mb-0">Panel de control de usuario</p>
                    </div>

                    <!-- Avatar o icono -->
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle fs-2 text-secondary me-3"></i>
                        <!-- Opcional: fecha o estado -->
                        <span class="text-muted small">{{ date('d/m/Y') }}</span>
                    </div>

                </div>
            </div>
        </div>



        <!-- Tarjetas -->
      <div class="row g-4 mb-4">
   <div class="col-md-2">
    <div class="card card-stats text-white bg-primary shadow-sm h-100 clickable-card" data-ruta="{{ route('activos.index') }}">
    <div class="card-body text-center">
        <i class="bi bi-boxes fs-2"></i>
        <h5 class="card-title mt-2">Activos</h5>
        <p class="display-5">{{ $countActivos }}</p>
    </div>
</div>

</div>


    <div class="col-md-2">
        <div class="card card-stats text-white bg-success shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-truck fs-2"></i>
                <h5 class="card-title mt-2">Entregas</h5>
                <p class="display-5">{{ $countEntregas }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card card-stats text-white bg-danger shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-arrow-left-right fs-2"></i>
                <h5 class="card-title mt-2">Traslados</h5>
                <p class="display-5">{{ $countTraslados }}</p>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-2">
        <div class="card card-stats text-white bg-dark shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-x-circle fs-2"></i>
                <h5 class="card-title mt-2">Bajas</h5>
                <p class="display-5">{{ $countBajas }}</p>
            </div>
        </div>
    </div> --}}

    <div class="col-md-2">
        <div class="card card-stats text-white bg-info shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-arrow-counterclockwise fs-2"></i>
                <h5 class="card-title mt-2">Devoluciones</h5>
                <p class="display-5">{{ $countDevoluciones }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="card card-stats text-white bg-secondary shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-card-checklist fs-2"></i>
                <h5 class="card-title mt-2">Inventarios</h5>
                <p class="display-5">{{ $countInventarios }}</p>
            </div>
        </div>
    </div>
</div>

        <!-- Gráficos -->
        <div class="row g-4 mb-4">
            <div class="col-md-5">
                <div class="card chart-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Activos por Estado</h5>
                        <canvas id="estadoActivosChart" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card chart-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Movimientos Último Mes</h5>
                        <canvas id="movimientosChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        {{-- </div> --}}

        <!-- Distribución por servicio -->
        {{-- <div class="row g-4"> --}}
            <div class="col-md-12">
                <div class="card chart-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Activos por Servicio</h5>
                        <canvas id="serviciosChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {

// Cuando se haga clic en cualquier card con data-ruta
$('.clickable-card').on('click', function() {
    const ruta = $(this).data('ruta'); // obtenemos la ruta
    activarRutaMenu(ruta); // llamamos a tu función
});



            // 🎯 Configuración general de animación para reutilizar
            const animacionGeneral = {
                duration: 1500,
                easing: 'easeOutBounce' // puedes probar: 'easeOutQuart', 'easeInOutCubic', etc.
            };

            // 🔹 Activos por Estado (doughnut)
            const ctxEstado = document.getElementById('estadoActivosChart').getContext('2d');
        const labelsEstado = {!! json_encode(array_keys($activosPorEstado->toArray())) !!};
    const dataEstado = {!! json_encode(array_values($activosPorEstado->toArray())) !!};

    const estadoActivosChart = new Chart(ctxEstado, {
        type: 'doughnut',
        data: {
            labels: labelsEstado,
            datasets: [{
                data: dataEstado,
                backgroundColor: [
                    'rgba(0,123,255,0.8)',
                    'rgba(220,53,69,0.8)',
                    'rgba(33,37,41,0.8)',
                    'rgba(40,167,69,0.8)',
                    'rgba(255,193,7,0.8)' // puedes agregar más colores si hay más estados
                ],
                borderColor: [
                    'rgba(0,123,255,1)',
                    'rgba(220,53,69,1)',
                    'rgba(33,37,41,1)',
                    'rgba(40,167,69,1)',
                    'rgba(255,193,7,1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#000',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.7)',
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
            },
            animation: animacionGeneral // tu animación personalizada
        }
    });

            // 🔹 Movimientos último mes (barras)
            const ctxMov = document.getElementById('movimientosChart').getContext('2d');
            new Chart(ctxMov, {
                type: 'bar',
                data: {
labels: {!! json_encode($semanas) !!},
                     datasets: [
                { label: 'Entregas', data: {!! json_encode($dataEntregas) !!}, backgroundColor: 'rgba(0,123,255,0.8)' },
                { label: 'Traslados', data: {!! json_encode($dataTraslados) !!}, backgroundColor: 'rgba(220,53,69,0.8)' },
                //{ label: 'Bajas', data: {!! json_encode($dataBajas) !!}, backgroundColor: 'rgba(33,37,41,0.8)' },
                { label: 'Devoluciones', data: {!! json_encode($dataDevoluciones) !!}, backgroundColor: 'rgba(0,123,255,0.5)' }
            ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        ...animacionGeneral,
                        delay: (context) => context.dataIndex * 150, // retrasa cada barra
                    }
                }
            });

            // 🔹 Activos por Servicio (barras horizontales)
            const ctxServ = document.getElementById('serviciosChart').getContext('2d');
            new Chart(ctxServ, {
                type: 'bar',
                data: {
                     labels: {!! json_encode($servicios) !!},
            datasets: [{ label: 'Activos', data: {!! json_encode($dataServicios) !!}, backgroundColor: 'rgba(0,123,255,0.8)' }]

                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        ...animacionGeneral,
                        delay: (context) => context.dataIndex * 150
                    }
                }
            });
        });
        </script>

{{-- </body> --}}

{{-- </html> --}}
