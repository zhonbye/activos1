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

                <!-- Bienvenida -->
                <div>
                    <h4 class="fw-bold mb-1 text-primary">👋 ¡Bienvenido,
                        {{ Auth::user()->responsable->cargo->abreviatura }}
                        {{ Auth::user()->responsable->nombre }}!</h4>
                    {{-- <h4 class="fw-bold mb-1 text-primary">👋 ¡Bienvenido, {{ Auth::user()->usuario }}!</h4> --}}
                    <p class="text-muted mb-0">Panel de control del adminstrador</p>
                </div>

                <!-- Avatar o icono -->
                <div class="d-flex align-items-center p-3 px-5 rounded-pill"
                    style="cursor:pointer; background: linear-gradient(90deg, #e3f2fd, #b29dff52);"
                    data-bs-toggle="modal" data-bs-target="#perfilModal">

                    <i class="bi bi-person-circle fs-2 text-secondary me-3"></i>

                    <!-- Columna con usuario y fecha -->
                    <div class="d-flex flex-column">
                        <span class="fw-bold text-primary fs-5">{{ Auth::user()->usuario }}</span>
                        <span class="text-muted small">{{ date('d/m/Y') }}</span>
                    </div>

                </div>



            </div>
        </div>
    </div>

    <!-- 🔹 Tarjetas resumen -->





    <div class="row g-4 mb-4">

            {{-- Activos en Mal Estado --}}
    <div class="col-md-3">
        <div class="card card-stats text-white bg-danger shadow-sm h-100 acta-card"
            data-tipo="mal-estado" data-bs-toggle="tooltip" title="Activos que requieren atención o mantenimiento">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-triangle fs-2"></i>
                <h5 class="card-title mt-2">Activos</h5>
                <small class="card-title mt-0">En Mal Estado</small>
                <p class="display-5">{{ $countMalEstado ?? 0 }}</p>
            </div>
        </div>
    </div>

        {{-- Activos Dados de Baja --}}
        <div class="col-md-3">
            <div class="card card-stats text-white bg-danger shadow-sm h-100 acta-card"
                data-tipo="baja" data-bs-toggle="tooltip" title="Activos dados de baja">
                <div class="card-body text-center">
                    <i class="bi bi-x-octagon fs-2"></i>
                    <h5 class="card-title mt-2">Activos</h5>
                    <small class="card-title mt-0">De Baja</small>
                    <p class="display-5">{{ $countBajas ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Activos Entregados Hoy --}}
        <div class="col-md-3">
            <div class="card card-stats text-white bg-success shadow-sm h-100 acta-card"
                data-tipo="entregados" data-bs-toggle="tooltip" title="Activos entregados hoy">
                <div class="card-body text-center">
                    <i class="bi bi-truck fs-2"></i>
                    <h5 class="card-title mt-2">Activos</h5>
                    <small class="card-title mt-0">Entregados Hoy</small>
                    <p class="display-5">{{ $countEntregadosHoy ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Activos del Área de Activos Fijos --}}
        <div class="col-md-3">
            <div class="card card-stats text-white bg-info shadow-sm h-100 acta-card"
                data-tipo="area" data-bs-toggle="tooltip" title="Activos pertenecientes al área de activos fijos">
                <div class="card-body text-center">
                    <i class="bi bi-building fs-2"></i>
                    <h5 class="card-title mt-2">Activos</h5>
                    <small class="card-title mt-0">Área Fijos</small>
                    <p class="display-5">{{ $countAreaFijos ?? 0 }}</p>
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

        {{-- <div class="col-md-12">
            <div class="card chart-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Activos por Unidad</h5>
                    <canvas id="activosUnidadChart" height="80"></canvas>
                </div>
            </div>
        </div> --}}
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
        // const ctxUnidad = document.getElementById('activosUnidadChart').getContext('2d');
        // new Chart(ctxUnidad, {
        //     type: 'bar',
        //     data: {
        //         labels: {!! json_encode($unidades) !!},
        //         datasets: [{
        //             label: 'Activos',
        //             data: {!! json_encode($dataActivosUnidades) !!},
        //             backgroundColor: 'rgba(23,162,184,0.8)'
        //         }]
        //     },
        //     options: {
        //         indexAxis: 'y',
        //         plugins: { legend: { display: false } },
        //         animation: anim
        //     }
        // });
    });
</script>
