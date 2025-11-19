<div class="modal fade" id="modalFiltrosActas" tabindex="-1" aria-labelledby="modalFiltrosActasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color:#fdfdfd; border-radius:12px;">

            <!-- Header -->
            <div class="modal-header bg-primary bg-opacity-10 border-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-funnel-fill me-2"></i> Filtros de Actas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="formFiltrosActas" action="{{ route('movimientos.filtrar') }}" method="GET">
                    <input type="hidden" name="busqueda" value="">
                    <input type="hidden" name="busquedaActivo" value="">

                    <!-- Identificación -->
                    <div class="mb-4 p-3 rounded" style="background-color:#e9f2ff;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-upc-scan me-1"></i> Identificación
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Número de documento</label>
                                <input type="text" name="numero_documento" class="form-control"
                                    placeholder="Ej: ENT-0021">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gestión</label>
                                <input type="number" name="gestion" class="form-control" placeholder="Ej: 2024">
                            </div>
                        </div>
                    </div>

                    <!-- Tipo de acta -->
                    <div class="mb-4 p-3 rounded" style="background-color:#dff0d8;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-journal-text me-1"></i> Tipo de Acta y Estado
                        </h6>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tipo de Acta</label>
                                <select name="tipo_acta" class="form-select" id="tipoActaFiltro">
                                    <option value="all">Todos</option>
                                    <option value="entrega">Entrega</option>
                                    <option value="devolucion">Devolución</option>
                                    <option value="traslado">Traslado</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Estado</label>
                                <select name="estado" class="form-select">
                                    <option value="all">Todos</option>
                                    {{-- <option value="vigente" selected>Vigente</option> --}}
                                    <option value="pendiente">Pendiente</option>
                                    <option value="finalizado">Finalizado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios -->
                    <div class="mb-4 p-3 rounded" style="background-color:#f9cece27;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-building me-1"></i> Servicio
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6" id="divServicioOrigen">
                                <label class="form-label">Servicio Origen</label>
                                <select name="id_servicio_origen" class="form-select">
                                    <option value="all">Todos</option>
                                    @foreach ($servicios as $s)
                                        <option value="{{ $s->id_servicio }}">{{ $s->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6" id="divServicioDestino">
                                <label class="form-label">Servicio Destino</label>
                                <select name="id_servicio_destino" class="form-select">
                                    <option value="all">Todos</option>
                                    @foreach ($servicios as $s)
                                        <option value="{{ $s->id_servicio }}">{{ $s->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Estado -->
                    {{-- <div class="mb-4 p-3 rounded" style="background-color:#fff3e68a;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-clipboard2-check me-1"></i> Estado
                        </h6>
                        <div class="row">

                        </div>
                    </div> --}}


                    <!-- Ordenamiento -->
                    <div class="mb-4 p-3 rounded" style="background-color:#e8f7ff;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-sort-alpha-down me-1"></i> Ordenar resultados
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Ordenar por</label>
                                <select name="ordenar_por" class="form-select">
                                    <option value="fecha">Fecha</option>
                                    <option value="gestion">Gestión</option>
                                    <option value="numero_documento">Número de documento</option>
                                    <option value="estado">Estado</option>
                                    <option value="created_at">Fecha de registro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Dirección</label>
                                <select name="direccion" class="form-select">
                                    <option value="asc">Ascendente</option>
                                    <option value="desc" selected>Descendente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Rango de fechas -->
                    <div class="mb-4 p-3 rounded" style="background-color:#f5f5f5;">
                        <button type="button" id="toggleFechasActas" class="btn btn-outline-primary w-100 mb-3">
                            <i class="bi bi-calendar3"></i> Rango de fechas
                        </button>

                        <div id="rangoFechasActas" class="d-none">
                            <label class="form-label fw-bold">Fecha del acta</label>
                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Desde</label>
                                    <input type="date" name="fecha_inicio" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Hasta</label>
                                    <input type="date" name="fecha_fin" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="reset" form="formFiltrosActas" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar
                </button>
                <button type="submit" form="formFiltrosActas" class="btn btn-primary">
                    <i class="bi bi-search"></i> Aplicar filtros
                </button>
            </div>

        </div>
    </div>
</div>


{{-- <a href="{{ route('movimientos.pdf') }}" class="btn btn-danger btn-sm" target="_blank">
    <i class="bi bi-file-earmark-pdf"></i> PDF
</a> --}}


<div class="row bg-info4 p-4 justify-content-center" style="height: 130vh; min-height: 130vh; max-height: 130vh;">

    <div class="main-col col-md-12 col-lg-11 order-lg-1 bg-dange4r order-1 mb-1 p-1 transition"
        style="position: relative; height: 130vh; max-height: 130vh; display: flex; flex-direction: column; overflow: visible;">
        <div class="card p-4 rounded shadow "
            style="background-color: var(--color-fondo); display: flex; flex-direction: column; flex: 1 1 auto;">

            <!-- Título -->
            <h2 class="mb-4 text-center text-primary">
                <i class="bi bi-file-earmark-text me-2"></i>Lista de Actas
            </h2>

            <!-- Card de acciones (buscar, filtros, exportar) -->
            <div class="card shadow-sm position-relative p-3 d-flex justify-content-center align-items-center mb-4"
                id="cardActas"
                style="
        background-color: #e9f2ff7e;
        border-left: 5px solid #0d6efd;
        box-sizing: border-box;
        min-height: 240px;
        max-height: none;
        overflow: visible;
     ">
                <div class="d-flex flex-column justify-content-center p-4 rounded"
                    style="background-color:#e9f2ff; width: 100%; box-sizing: border-box;">

                    <div class="row g-2 d-flex align-items-center ps-5">

                        <!-- 🔍 Input de búsqueda -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Buscar acta</label>
                                <div class="input-group">
                                    <input type="text" id="buscarActa"
                                        class="form-control form-control-sm rounded-start-pill"
                                        placeholder="Número, gestión o responsable">
                                    <button class="btn btn-primary btn-sm rounded-end-pill" id="btnBuscarActa"
                                        type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4"></div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalFiltrosActas">
                                <i class="bi bi-funnel-fill me-1"></i> Filtrar
                            </button>
                        </div>
{{-- 
                        <div class="col-md-1 d-flex align-items-end">
                            <button class="desactivado btn btn-azul btn-sm">
                                <i class="bi bi-printer-fill me-1"></i> Imprimir
                            </button>
                        </div> --}}

                      <div class="col-md-2 d-flex align-items-end">
    <a href="{{ route('movimientos.pdf') }}" class="btn btn-danger btn-sm w-100" target="_blank">
        <i class="bi bi-file-earmark-pdf me-1"></i> Generar PDF
    </a>
</div>



                    </div>
                </div>
            </div>

            <!-- Detalle Acta -->
            <div class="card shadow-sm d-none position-relative p-3 d-flex justify-content-center align-items-center mb-4"
                id="cardDetalleActa"
                style="
        background-color: #e9f2ff7e;
        border-left: 5px solid #0d6efd;
        box-sizing: border-box;
        min-height: 240px;
        max-height: none;
        overflow: visible;
     ">
                <input type="hidden" id="id_acta_a" value="">
                <div class="d-flex flex-column justify-content-center fs2 p-4 rounded"
                    style="background-color:#e9f2ff; width: 100%; box-sizing: border-box;">

                    <div class="row d-flex align-items-center justify-content-start mb-3">
                        <div class="col-md-3">
                            <h4 class="fw-bold mb-0">Información General</h4>
                        </div>
                        <div class="col-md-6 d-flex align-items-center justify-content-center px-2">
                            <div class="input-group" style="max-width: 300px;">
                                <input type="text" id="buscarDetalleActa"
                                    class="form-control form-control-sm rounded-start-pill"
                                    placeholder="Código, nombre o detalle">
                                <button class="btn btn-primary btn-sm rounded-end-pill" id="btnBuscarDetalleActa"
                                    type="button">
                                    Buscar
                                </button>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex align-items-center justify-content-end">
                            <button class="desactivado btn btn-azul btn-sm">
                                <i class="bi bi-printer-fill me-1"></i> Imprimir
                            </button>
                        </div>
                    </div>

                    <!-- Datos principales -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-3"><strong>Número:</strong> <span id="detalleNumero">-</span></div>
                        <div class="col-md-3"><strong>Gestión:</strong> <span id="detalleGestion">-</span></div>
                        <div class="col-md-3"><strong>Fecha:</strong> <span id="detalleFecha">-</span></div>
                        <div class="col-md-3">
                            <strong>Estado:</strong>
                            <span id="detalleEstado" class="badge bg-info text-dark">-</span>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-4"><strong>Usuario:</strong> <span id="detalleUsuario">-</span></div>
                        <div class="col-md-4"><strong>Responsable:</strong> <span id="detalleResponsable">-</span>
                        </div>
                        <div class="col-md-4"><strong>Servicio:</strong> <span id="detalleServicio">-</span></div>
                    </div>
                </div>
            </div>

            <!-- Pestañas -->
            {{-- <ul class="nav nav-pills mb-3 bg-light rounded p-1" id="tabsActas" role="tablist">
                <li class="nav-item me-2" role="presentation">
                    <button class="nav-link active text-dark fw-semibold" id="tab-actas" data-bs-toggle="tab"
                        data-bs-target="#contenedorResultadosActas" type="button" role="tab">
                        <i class="bi bi-file-earmark-text me-1"></i> Actas
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link  d-none3 text-dark fw-semibold" id="tab-detalle"
                        data-bs-toggle="tab" data-bs-target="#panelDetalleActa" type="button" role="tab"
                        aria-disabled="true">
                        <i class="bi bi-card-list me-1"></i> Detalle
                    </button>
                </li>
            </ul> --}}

            <div class="tab-content d-flex flex-column position-relative overflow-auto p-3 bg-da5nger"
                style="height: 87vh; max-height: 87vh; min-height: 87vh;">

                <!-- Lista de Actas -->
                <div class="tab-pane fade show active flex-grow-1 bg-info8 position-relative"
                    id="contenedorResultadosActas" role="tabpanel">
                    <div id="contenedorTablaActas" class="d-flex flex-column bg-dange3r rounded p-2"
                        style="height: 100%; max-height: 100%; overflow-y: auto;">
                        <!-- Aquí se cargará la tabla de actas dinámicamente -->
                    </div>
                </div>

                <!-- Detalle Acta -->
                <div class="tab-pane fade position-relative" id="panelDetalleActa" role="tabpanel">
                    <div id="contenidoDetalleActa" class="d-flex flex-column bg-dange3r rounded p-2"
                        style="height: 100%; max-height: 100%; overflow-y: auto;">
                        <!-- Aquí se cargará la tabla de detalles dinámicamente -->
                        <div
                            style="height: 70vh; max-height: 70vh; overflow-y: auto; overflow-x: hidden; position: relative;">
                            <table class="table table-striped mb-0 rounded">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nº</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Detalle</th>
                                        <th>Estado</th>
                                        <th>Observaciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaDetalleActa">
                                    <!-- Aquí se llenará dinámicamente con AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<script>
    
    function cargarActas(url = null) {
        var form = $('#formFiltrosActas'); // tu formulario de filtros de actas
        var action = url || form.attr('action');

        // Si tienes alguna función para resetear detalles, la puedes usar aquí
        // resetCardDetalleActa(); // opcional, si manejas un panel de detalles

        $.ajax({
            url: action,
            type: 'GET',
            data: form.serialize(),
            success: function(data) {
                // Actualiza el contenedor de resultados de actas
                $('#contenedorResultadosActas').html(data);
            },
            error: function(xhr) {
                let mensaje2 = 'Error al cargar actas.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje2 = xhr.responseJSON.message;
                }
                mensaje(mensaje2, 'danger'); // función global para mostrar alertas
            }
        });
    }
    
    $(document).ready(function() {








// Botón buscar acta
$('#btnBuscarActa').on('click', function() {
    const valor = $('#buscarActa').val().trim();   // input de texto
    $('#formFiltrosActas input[name="busqueda"]').val(valor); // asignar al hidden
    $('#formFiltrosActas').submit(); // enviar el formulario
});





        $('#modalFiltrosActas').on('submit', function(e) {
            e.preventDefault();
            cargarActas();
        });
        $(function() {
            $('#modalFiltrosActas').triggerHandler('submit');
        });
    // Cuando se envía el formulario de filtros de actas
    $('#formFiltrosActas').on('submit', function(e) {
        e.preventDefault();
        cargarActas();
    });





 $(document).on('click', '#contenedorResultadosActas .pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if (url) {
                cargarActas(url);
            }
        });
$('#formFiltrosActas').on('reset', function(e) {
    $divOrigen.show();
            $divDestino.show();
});


    // Toggle rango de fechas
    $('#toggleFechasActas').on('click', function() {
        $('#rangoFechasActas').toggleClass('d-none');
    });

    // Mostrar/ocultar servicios según tipo de acta
    const $tipoActaSelect = $('#tipoActaFiltro');
    const $divOrigen = $('#divServicioOrigen');
    const $divDestino = $('#divServicioDestino');

    function actualizarServicios() {
        const tipo = $tipoActaSelect.val();
        if (tipo === 'entrega') {
            $divOrigen.hide();
            $divDestino.show();
        } else if (tipo === 'devolucion') {
            $divOrigen.show();
            $divDestino.hide();
        } else if (tipo === 'traslado') {
            $divOrigen.show();
            $divDestino.show();
        } else {
            // Todos
            $divOrigen.show();
            $divDestino.show();
        }
    }

    $tipoActaSelect.on('change', actualizarServicios);
    actualizarServicios(); // Ejecutar al cargar la página
});

</script>
