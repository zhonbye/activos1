<style>
    body {
        background-color: #f8f9fa;
    }


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

    <!-- 🔹 Sección de Bienvenida Admin -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 rounded-4 shadow-sm d-flex align-items-center justify-content-between"
                style="background: linear-gradient(90deg, #e3f2fd, #ffffff);">
                <div>
                    <h4 class="fw-bold mb-1 text-primary">👋 ¡Bienvenido, {{ Auth::user()->usuario }}!</h4>
                    <p class="text-muted mb-0">Panel de administración y control general</p>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-gear fs-2 text-secondary me-3"></i>
                    <span class="text-muted small">{{ date('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 Tarjetas resumen -->
    <div class="row g-4 mb-4">
        <div class="col-md-2">
            <div class="card card-stats text-white bg-primary shadow-sm h-100 clickable-card"
                data-ruta="{{ route('activos.index') }}">
                <div class="card-body text-center">
                    <i class="bi bi-boxes fs-2"></i>
                    <h6 class="card-title mt-2">Activos Totales</h6>
                    <p class="display-5">{{ $countActivos }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-stats text-white bg-success shadow-sm h-100 clickable-card"
                data-ruta="{{ route('usuarios.index') }}">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-2"></i>
                    <h6 class="card-title mt-2">Usuarios</h6>
                    <p class="display-5">{{ $countUsuarios }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-stats text-white bg-warning shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-building fs-2"></i>
                    <h6 class="card-title mt-2">Unidades</h6>
                    <p class="display-5">{{ $countUnidades }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-stats text-white bg-info shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-briefcase fs-2"></i>
                    <h6 class="card-title mt-2">Categorías</h6>
                    <p class="display-5">{{ $countCategorias }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-stats text-white bg-danger shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-repeat fs-2"></i>
                    <h6 class="card-title mt-2">Movimientos</h6>
                    <p class="display-5">{{ $countMovimientos }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card card-stats text-white bg-dark shadow-sm h-100 clickable-card"
                data-ruta="">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-data fs-2"></i>
                    <h6 class="card-title mt-2">Reportes</h6>
                    <p class="display-5">6</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 Gráficos -->
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
                    <h5 class="card-title mb-3">Movimientos por Usuario</h5>
                    <canvas id="movimientosUsuariosChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card chart-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Activos por Unidad</h5>
                    <canvas id="activosUnidadChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🔹 Scripts -->
<script>
    $(document).ready(function() {
        // Navegación
        $('.clickable-card').on('click', function() {
            const ruta = $(this).data('ruta');
            activarRutaMenu(ruta);
        });

        // Animación base
        const anim = { duration: 1500, easing: 'easeOutQuart' };

        // Activos por Estado
        const ctxEstado = document.getElementById('estadoActivosChart').getContext('2d');
        new Chart(ctxEstado, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($activosPorEstado->toArray())) !!},
                datasets: [{
                    data: {!! json_encode(array_values($activosPorEstado->toArray())) !!},
                    backgroundColor: [
                        'rgba(0,123,255,0.8)',
                        'rgba(40,167,69,0.8)',
                        'rgba(220,53,69,0.8)',
                        'rgba(255,193,7,0.8)',
                        'rgba(33,37,41,0.8)'
                    ]
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } },
                animation: anim
            }
        });

        // Movimientos por Usuario
        const ctxMov = document.getElementById('movimientosUsuariosChart').getContext('2d');
        new Chart(ctxMov, {
            type: 'bar',
            data: {
                labels: {!! json_encode($usuarios) !!},
                datasets: [{
                    label: 'Movimientos realizados',
                    data: {!! json_encode($dataMovimientosUsuarios) !!},
                    backgroundColor: 'rgba(0,123,255,0.8)'
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } },
                animation: anim
            }
        });

        // Activos por Unidad
        const ctxUnidad = document.getElementById('activosUnidadChart').getContext('2d');
        new Chart(ctxUnidad, {
            type: 'bar',
            data: {
                labels: {!! json_encode($unidades) !!},
                datasets: [{
                    label: 'Activos',
                    data: {!! json_encode($dataActivosUnidades) !!},
                    backgroundColor: 'rgba(23,162,184,0.8)'
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                animation: anim
            }
        });
    });
</script>
