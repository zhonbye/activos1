<style>
    /* Destacar inputs inventario */
    .input-activo {
        border: 2px solid #0d6efd !important;
        background-color: #e7f1ff !important;
    }

    #iframeOverlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
    }

    .iframe-container {
        position: relative;
        width: 80vw;
        height: 80vh;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px #000;
    }

    .iframe-container iframe {
        width: 100%;
        height: 100%;
        border-radius: 0 0 8px 8px;
        border: none;
    }

    #iframeOverlay #closeIframe {
        position: absolute;
        top: 8px;
        right: 8px;
        background: red;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 4px 8px;
        font-weight: bold;
        cursor: pointer;
    }



    /* animacion para buscar */
    .dot {
        display: inline-block;
        width: 7px;
        height: 7px;
        margin: 0 1px;
        background-color: #0d6efd;
        border-radius: 50%;
        animation: blink 1s infinite;
    }

    .dot2 {
        animation-delay: 0.2s;
    }

    .dot3 {
        animation-delay: 0.4s;
    }

    @keyframes blink {

        0%,
        80%,
        100% {
            opacity: 0;
        }

        40% {
            opacity: 1;
        }
    }
</style>


<div class="offcanvas offcanvas-end w-75" tabindex="-1" id="offcanvasDetalleActivo">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Detalle del Activo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body" id="detalleActivoBody">
        <!-- Contenido dinámico -->
    </div>
</div>


<!-- Modal Detalle Inventario -->
<div class="modal fade" id="modalDetalleInventario" tabindex="-1" aria-labelledby="modalDetalleInventarioLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:12px; background-color:#fdfdfd;">

            <!-- Header -->
            <div class="modal-header bg-primary bg-opacity-10 border-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-card-list me-2"></i> Detalle del Inventario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            {{-- <div class="modal-body">

                <!-- Info del inventario -->
                <div class="mb-3 p-3 rounded" style="background-color:#e9f2ff;">
                    <h6 class="fw-bold mb-2">Información General</h6>
                    <div class="row g-2">
                        <div class="col-md-3"><strong>Número:</strong> <span id="detalleNumero"></span></div>
                        <div class="col-md-3"><strong>Gestión:</strong> <span id="detalleGestion"></span></div>
                        <div class="col-md-3"><strong>Fecha:</strong> <span id="detalleFecha"></span></div>
                        <div class="col-md-3"><strong>Estado:</strong> <span id="detalleEstado" class="badge"></span>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-md-4"><strong>Usuario:</strong> <span id="detalleUsuario"></span></div>
                        <div class="col-md-4"><strong>Responsable:</strong> <span id="detalleResponsable"></span></div>
                        <div class="col-md-4"><strong>Servicio:</strong> <span id="detalleServicio"></span></div>
                    </div>
                </div>

                <!-- Tabla de detalles -->
                <div class="table-responsive" style="max-height:60vh; overflow-y:auto;">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Activo</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>

                        </thead>
                        <tbody id="tablaDetalleInventario">
                            <!-- Aquí se llenará dinámicamente con AJAX -->
                        </tbody>
                    </table>
                </div>

            </div> --}}

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
            </div>

        </div>
    </div>
</div>



<!-- 🧩 Modal de Filtros de Inventarios -->
<div class="modal fade" id="modalFiltrosInventario" tabindex="-1" aria-labelledby="modalFiltrosInventarioLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color:#fdfdfd; border-radius:12px;">

            <!-- Header -->
            <div class="modal-header bg-primary bg-opacity-10 border-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-funnel-fill me-2"></i> Filtros de Inventarios
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <form id="formFiltrosInventarios" action="{{ route('inventarios.filtrar') }}" method="GET">
                    <input type="hidden" name="busqueda" value="">

                    <!-- 🧾 Identificación -->
                    <div class="mb-4 p-3 rounded" style="background-color:#e9f2ff;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-upc-scan me-1"></i> Identificación
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Número de documento</label>
                                <input type="text" name="numero_documento" class="form-control"
                                    placeholder="Ej: INV-0021">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Gestión</label>
                                <input type="number" name="gestion" class="form-control" placeholder="Ej: 2024">
                            </div>
                        </div>
                    </div>

                    <!-- 🧍‍♂ Responsable y usuario -->
                    <div class="mb-4 p-3 rounded" style="background-color:#b9c8e72d;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-people-fill me-1"></i> Usuario y Responsable
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Usuario</label>
                                <select name="id_usuario" class="form-select">
                                    <option value="all">Todos</option>
                                    {{-- @foreach ($usuarios as $u)
                                        <option value="{{ $u->id }}">{{ $u->nombre }}</option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Responsable</label>
                                <select name="id_responsable" class="form-select">
                                    <option value="all">Todos</option>
                                    {{-- @foreach ($responsables as $r)
                                        <option value="{{ $r->id_responsable }}">{{ $r->nombre }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 🏥 Servicio -->
                    <div class="mb-4 p-3 rounded" style="background-color:#f9cece27;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-building me-1"></i> Servicio
                        </h6>

                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Servicio</label>
                                <select name="id_servicio" class="form-select">
                                    <option value="all">Todos</option>
                                    {{-- @foreach ($servicios as $s)
                                        <option value="{{ $s->id_servicio }}">{{ $s->nombre }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 📦 Estado del inventario -->
                    <div class="mb-4 p-3 rounded" style="background-color:#fff3e68a;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-clipboard2-check me-1"></i> Estado y detalles
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <select name="estado" class="form-select">
                                    <option value="all">Todos</option>
                                    <option value="activo">Activo</option>
                                    <option value="cerrado">Cerrado</option>
                                    <option value="anulado">Anulado</option>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">Observaciones (Inventario)</label>
                                <input type="text" name="observaciones" class="form-control"
                                    placeholder="Buscar por observación">
                            </div>
                        </div>

                        <!-- Opcional: filtrado por detalle_inventarios -->
                        {{-- <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Estado actual del activo</label>
                                <select name="estado_actual" class="form-select">
                                    <option value="all">Todos</option>
                                    <option value="bueno">Bueno</option>
                                    <option value="regular">Regular</option>
                                    <option value="malo">Malo</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Observación de detalle</label>
                                <input type="text" name="observ_detalle" class="form-control" placeholder="Observación del activo">
                            </div>
                        </div> --}}
                    </div>


                    <!-- 🔽 Ordenamiento -->
                    <div class="mb-4 p-3 rounded" style="background-color:#e8f7ff;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-sort-alpha-down me-1"></i> Ordenar resultados
                        </h6>

                        <div class="row g-3">

                            <!-- Ordenar por -->
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

                            <!-- Dirección -->
                            <div class="col-md-6">
                                <label class="form-label">Dirección</label>
                                <select name="direccion" class="form-select">
                                    <option value="asc">Ascendente</option>
                                    <option value="desc" selected>Descendente</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- 📅 Fecha -->
                    <div class="mb-3 p-3 rounded" style="background-color:#f5f5f5;">
                        <button type="button" id="toggleFechas" class="btn btn-outline-primary w-100 mb-3">
                            <i class="bi bi-calendar3"></i> Rango de fechas
                        </button>

                        <div id="rangoFechas" class="d-none">
                            <label class="form-label fw-bold">Fecha del inventario</label>
                            <div class="row g-3">

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
                <button type="reset" form="formFiltrosInventarios" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar
                </button>

                <button type="submit" form="formFiltrosInventarios" class="btn btn-primary">
                    <i class="bi bi-search"></i> Aplicar filtros
                </button>
            </div>

        </div>
    </div>
</div>












<!-- Modal Registrar Activo -->
<div class="modal fade" id="modalRegistrarActivo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--color-fondo); color: var(--color-texto-principal);">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-box-seam me-1"></i> Registrar Activo</h5>
                <button type="button" class="btn-close btn-close-success" data-bs-dismiss="modal"></button>
            </div>


            <!-- Body (incluye Blade de Laravel) -->
            <div class="modal-body">
                {{-- @include('user.inventario.registrar') --}}
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
                <button type="submit" form="form_activo" class="btn btn-success">
                    <i class="bi bi-check2-circle me-1"></i> Guardar Activo
                </button>
            </div>

        </div>
    </div>
</div>








{{-- <div class="row  bg-info0 pb-4 justify-content-center" style="height: 90vh;min-height: 30vh;max-height:94vh"> --}}
    {{-- <div class="main-col col-md-12 col-lg-10 bg-danger order-lg-1 order-1 mb-4 p-1 transition"
         style="position: relative;height: 100%; min-height: 40vh; max-height:100vh display: flex; flex-direction: column; "> --}}
    {{-- <div class="main-col col-md-12 col-lg-11 bg-danger0 order-lg-1 order-1 mb-4 p-1 transition"
        style="position: relative; height: 80vh; min-height: 40vh; max-height: 80vh; display: flex; flex-direction: column; overflow: visible;"> --}}

        {{-- <div class="card p-4 rounded shadow" style="background-color: var(--color-fondo); display: flex; flex-direction: column; height: 100%;"> --}}
        {{-- <div class="card p-4 rounded shadow"
     style="background-color: var(--color-fondo);  display: flex; flex-direction: column; min-height 100vh;height: 100vh;"> --}}











     <div class="row bg-info4 p-4 justify-content-center" style="height: 110vh; min-height: 110vh; max-height: 110vh;">

    <div class="main-col col-md-12 col-lg-11 order-lg-1 bg-dange4r order-1 mb-1 p-1 transition"
        style="position: relative; height: 110vh;max-height: 110vh; display: flex; flex-direction: column; overflow: visible;">

        {{-- <div class="card p-4 rounded shadow"
            style="position: relative;  background-color: var(--color-fondo); display: flex; flex-direction: column; flex: 1 1 auto;"> --}}
    <div class="card p-4 rounded shadow "
            style="background-color: var(--color-fondo); display: flex; flex-direction: column; flex: 1 1 auto;">


            <!-- Título -->
            <h2 class="mb-4 text-center text-primary">
                <i class="bi bi-box-seam me-2"></i>Lista de inventario
            </h2>

            <!-- Botones principales -->
            <div class="d-flex justify-content-end mb-3 gap-2">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarActivo">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Activo
                </button>
                {{-- <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarActivo">
    <i class="bi bi-plus-lg me-1"></i> Registrar Activo
</button> --}}
                <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalFiltrosInventario">
                    <i class="bi bi-funnel-fill me-1"></i> Filtrar
                </button>
                <button class="desactivado btn btn-azul btn-sm">
                    <i class="bi bi-printer-fill me-1"></i> Imprimir
                </button>
            </div>

            <!-- Card de acciones (buscar, importar, exportar, bajas) -->
            <div class="card mb-4 shadow-sm" id="cardInventario"
                style="background-color: #f8f9fa; border-left: 5px solid #0d6efd; padding: 1.5rem;">
                <div class="row g-3 p-3">

                    <!-- 🔍 Input de búsqueda -->
                    <div class="col-md-4">
                        <div class="position-relative">
                            <label class="form-label fw-semibold">Buscar inventario</label>
                            <input type="text" id="buscarInventario"
                                class="form-control form-control-sm rounded-pill shadow-sm px-3"
                                placeholder="Número, gestión, servicio o responsable">

                            <!-- Loading dots -->
                            <div id="loadingDots" class="position-absolute"
                                style="right:12px; top:74%; transform:translateY(-50%); display:none;">
                                <span class="dot dot1"></span>
                                <span class="dot dot2"></span>
                                <span class="dot dot3"></span>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-1"></div>

                    <!-- Botones de acciones -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary btn-sm w-100" id="btnNuevoInventario">
                            <i class="bi bi-plus-circle me-1"></i> Nuevo inventario
                        </button>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-dark btn-sm w-100" id="btnInventariosPasados">
                            <i class="bi bi-archive me-1"></i> Inventarios pasados
                        </button>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-info btn-sm w-100" id="btnActualizarInventarios">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                        </button>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-secondary btn-sm w-100" id="btnFiltrosInventarios"
                            data-bs-toggle="modal" data-bs-target="#modalFiltrosInventario">
                            <i class="bi bi-funnel me-1"></i> Filtros
                        </button>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-success btn-sm w-100" id="btnGenerarPDF">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Generar PDF
                        </button>
                    </div>

                </div>
            </div>












<div class="card mb-4 shadow-sm d-none" id="cardDetalleInventario"
     style="background-color: #f8f9fa; border-left: 5px solid #0d6efd; padding: 1.5rem;">
    {{-- <div class="row g-3 p-3">

        <!-- Número de documento -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">N° Documento</label>
            <p class="form-control form-control-sm" id="detalleNumero">-</p>
        </div>

        <!-- Gestión -->
        <div class="col-md-2">
            <label class="form-label fw-semibold">Gestión</label>
            <p class="form-control form-control-sm" id="detalleGestion">-</p>
        </div>

        <!-- Fecha -->
        <div class="col-md-2">
            <label class="form-label fw-semibold">Fecha</label>
            <p class="form-control form-control-sm" id="detalleFecha">-</p>
        </div>

        <!-- Estado -->
        <div class="col-md-2">
            <label class="form-label fw-semibold">Estado</label>
            <span class="badge bg-secondary" id="detalleEstado">-</span>
        </div>

        <!-- Usuario -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Usuario</label>
            <p class="form-control form-control-sm" id="detalleUsuario">-</p>
        </div>

        <!-- Responsable -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Responsable</label>
            <p class="form-control form-control-sm" id="detalleResponsable">-</p>
        </div>

        <!-- Servicio -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Servicio</label>
            <p class="form-control form-control-sm" id="detalleServicio">-</p>
        </div>

        <!-- Tabla de detalles -->
        <div class="col-12 mt-3">
            <div id="contenidoDetalleInventario" class="table-responsive">
                <!-- Aquí se cargará la tabla de detalles del inventario vía AJAX -->
            </div>
        </div>

    </div> --}}
       <!-- Info del inventario -->
                <div class="mb-3 p-3 rounded" style="background-color:#e9f2ff;">
                    <h6 class="fw-bold mb-2">Información General</h6>
                    <div class="row g-2">
                        <div class="col-md-3"><strong>Número:</strong> <span id="detalleNumero"></span></div>
                        <div class="col-md-3"><strong>Gestión:</strong> <span id="detalleGestion"></span></div>
                        <div class="col-md-3"><strong>Fecha:</strong> <span id="detalleFecha"></span></div>
                        <div class="col-md-3"><strong>Estado:</strong> <span id="detalleEstado" class="badge"></span>
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-md-4"><strong>Usuario:</strong> <span id="detalleUsuario"></span></div>
                        <div class="col-md-4"><strong>Responsable:</strong> <span id="detalleResponsable"></span></div>
                        <div class="col-md-4"><strong>Servicio:</strong> <span id="detalleServicio"></span></div>
                    </div>
                </div>

</div>















            <!-- Contenedor de resultados -->
            {{-- <div id="contenedorResultadosInventarios"
                 class="bg-secondary rounded bg-opacity-10 flex-grow-1"
                 style="overflow-y: auto; padding: 15px;"> --}}



            <!-- Nav tabs -->
            <!-- Pestañas -->
            {{-- <ul class="nav nav-tabs mb-3" id="tabsInventario" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-inventario" data-bs-toggle="tab" data-bs-target="#contenedorResultadosInventarios" type="button" role="tab" aria-controls="contenedorResultadosInventarios" aria-selected="true">
            Inventarios
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link disabled" id="tab-detalle" data-bs-toggle="tab" data-bs-target="#panelDetalleInventario" type="button" role="tab" aria-controls="panelDetalleInventario" aria-selected="false">
            Detalle Inventario
        </button>
    </li>
</ul> --}}
         <ul class="nav nav-pills mb-3 bg-light rounded p-1" id="tabsInventario" role="tablist">
    <li class="nav-item me-2" role="presentation">
        <button class="nav-link active text-dark fw-semibold" id="tab-inventario" data-bs-toggle="tab"
            data-bs-target="#contenedorResultadosInventarios" type="button" role="tab">
            <i class="bi bi-box-seam me-1"></i> Inventarios
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link disabled d-none  text-dark fw-semibold" id="tab-detalle" data-bs-toggle="tab"
            data-bs-target="#panelDetalleInventario" type="button" role="tab" aria-disabled="true">
            <i class="bi bi-card-list me-1"></i> Detalles
        </button>
    </li>
</ul>
<div class="tab-content d-flex flex-column position-relative overflow-auto p-3 bg-da5nger"
     style="height: 65vh max-height: 65vh; min-height: 65vh;">
     
    <!-- Inventarios -->
    <div class="tab-pane fade show active flex-grow-1 bg-info8 position-relative" id="contenedorResultadosInventarios" role="tabpanel">
        <div id="contenedorTablaInventarios"
             class="d-flex flex-column bg-dange3r rounded p-2"
             style="height: 100%; max-height: 100%; overflow-y: auto;">
            <!-- Aquí se cargará la tabla de inventarios dinámicamente -->
        </div>
    </div>

    <!-- Detalle Inventario -->
    <div class="tab-pane fade position-relative" id="panelDetalleInventario" role="tabpanel">
        <div id="contenidoDetalleInventario"
             class="d-flex flex-column bg-dange3r rounded p-2"
             style="height: 100%; max-height: 100%; overflow-y: auto;">
            <!-- Aquí se cargará la tabla de detalles dinámicamente -->
             <div class="table-responsive" style="max-height:60vh; overflow-y:auto;">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Activo</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>

                        </thead>
                        <tbody id="tablaDetalleInventario">
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
    $(document).ready(function() {
        let usandoFechas = false;
        let debounceTimer;









        

$(document).on('click', '.ver-detalles-btn', function() {
    const $btn = $(this);
    const idInventario = $btn.data('id_inventario');
        $('#tab-detalle').removeClass('d-none');

    // Debug: botón activo
    // console.log('Botón clickeado, id inventario:', idInventario);

    // Quitar clase active de otros botones
    $('.ver-detalles-btn').removeClass('active');
    $btn.addClass('active');

    // Habilitar la pestaña detalle si estaba deshabilitada
    $('#tab-detalle').removeClass('disabled');
    const detalleTab = new bootstrap.Tab(document.querySelector('#tab-detalle'));
    detalleTab.show();

    // AJAX al controlador para traer los datos del inventario
    $.get(`${baseUrl}/inventarios/detalle/${idInventario}`, function(res) {
        // console.log('Datos recibidos del AJAX:', res); // 🔹 Verificar en consola

        // Colocar los datos en los labels
        $('#detalleNumero').text(res.numero || '-');
        $('#detalleGestion').text(res.gestion || '-');
        $('#detalleFecha').text(res.fecha || '-');
        // alert($('#detalleNumero').text())
        
        // Estado con color
        let estadoClass = 'bg-secondary';
        if(res.estado === 'vigente') estadoClass = 'bg-success';
        else if(res.estado === 'pendiente') estadoClass = 'bg-primary';
        else if(res.estado === 'finalizado') estadoClass = 'bg-dark';
        $('#detalleEstado').text(res.estado || '-').removeClass().addClass('badge ' + estadoClass);

        $('#detalleUsuario').text(res.usuario || '-');
        $('#detalleResponsable').text(res.responsable || '-');
        $('#detalleServicio').text(res.servicio || '-');

        // Llenar la tabla de detalles
        $('#tablaDetalleInventario').html(res.tablaDetalle || '<tr><td colspan="6" class="text-center">No hay detalles</td></tr>');

        // Mostrar card de detalle
        // $('#cardDetalleInventario').removeClass('d-none');
        // // Opcional: ocultar card principal de inventarios
        // $('#cardInventarios').addClass('d-none');
    }).fail(function(err) {
        // console.error('Error al cargar detalle del inventario:', err);
        mensaje('No se pudo cargar el detalle del inventario.','danger');
    });
});














// Control de cards según pestaña activa
$('#tabsInventario button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    const target = $(e.target).data('bs-target'); // ID de la pestaña que se activó

    if (target === '#contenedorResultadosInventarios') {
        $('#cardInventario').removeClass('d-none');
        $('#cardDetalleInventario').addClass('d-none');
        resetCardDetalleInventario()
    } else if (target === '#panelDetalleInventario') {
        // Mostramos card de detalle y ocultamos inventarios
        $('#cardDetalleInventario').removeClass('d-none');
        $('#cardInventario').addClass('d-none');
    }
});



function resetCardDetalleInventario() {
    $('#detalleNumero').text('-');
    $('#detalleGestion').text('-');
    $('#detalleFecha').text('-');
    $('#detalleEstado').text('-').removeClass().addClass('badge bg-secondary');
    $('#detalleUsuario').text('-');
    $('#detalleResponsable').text('-');
    $('#detalleServicio').text('-');

    // Vaciar tabla de detalles sin tocar la estructura
    $('#tablaDetalleInventario').html('');
}



        // Evento para abrir detalle desde botón
        // $(document).on('click', '.ver-detalles-btn', function() {
        //     const $btn = $(this);

        //     // Quitar clase active de cualquier otro botón
        //     $('.ver-detalles-btn').removeClass('active');

        //     // Poner clase active en este botón
        //     $btn.addClass('active');

        //     // Habilitar la pestaña de detalle si estaba deshabilitada
        //     $('#tab-detalle').removeClass('disabled');

        //     // Mostrar la pestaña de detalle
        //     const detalleTab = new bootstrap.Tab(document.querySelector('#tab-detalle'));
        //     detalleTab.show();
        // });

        // Volver a inventarios
        // $('#btnVolverInventario').on('click', function() {
        //     // Cambiar de nuevo a la pestaña inventario
        //     const inventarioTab = new bootstrap.Tab(document.querySelector('#tab-inventario'));
        //     inventarioTab.show();

        //     // Opcional: deshabilitar nuevamente la pestaña de detalle
        //     $('#tab-detalle').addClass('disabled');
        // });








        // $(document).on('click', '.ver-detalles-btn', function() {
        //     const idInventario = $(this).data('id_inventario');

        //     // Muestra panel de detalle y reduce la tabla principal
        //     $('#tablaInventarios').removeClass('flex-grow-1').addClass('flex-grow-1').css('flex',
        //         '0 0 60%');
        //     $('#panelDetalleInventario').removeClass('d-none').css('flex', '0 0 40%');

        //     // Cargar datos del inventario (puede ser AJAX)
        //     $('#contenidoDetalleInventario').html('<p>Cargando detalles del inventario ' +
        //         idInventario + '...</p>');
        //     // Ejemplo con AJAX:
        //     // $.get('/inventario/detalle/' + idInventario, function(data){
        //     //     $('#contenidoDetalleInventario').html(data);
        //     // });
        // });

        // Botón de volver
        // $('#btnVolverInventario').on('click', function() {
        //     $('#panelDetalleInventario').addClass('d-none');
        //     $('#tablaInventarios').css('flex', '1'); // tabla principal vuelve al 100%
        // });








        // $(document).on('click', '.ver-activo-btn', function() {
        //     const idActivo = $(this).data('id');

        //     // Cargar contenido dinámico del activo
        //     $('#detalleActivoBody').html('<p>Cargando detalles del activo ID ' + idActivo + '...</p>');

        //     // Abrir offcanvas derecho
        //     const offcanvas = new bootstrap.Offcanvas(document.getElementById(
        //         'offcanvasDetalleActivo'));
        //     offcanvas.show();
        // });




        // $(document).on('click', '.ver-detalles-btn', function() {
        //     var id = $(this).data('id_inventario');

        //     $.get(`${baseUrl}/inventarios/detalle/${id}`, function(res) {
        //         // Llenar info general
        //         $('#detalleNumero').text(res.numero);
        //         $('#detalleGestion').text(res.gestion);
        //         $('#detalleFecha').text(res.fecha);
        //         $('#detalleEstado').text(res.estado).removeClass().addClass('badge bg-' + (res
        //             .estado == 'pendiente' ? 'success' : (res.estado == 'finalizado' ?
        //                 'secondary' : 'primary')));
        //         $('#detalleUsuario').text(res.usuario);
        //         $('#detalleResponsable').text(res.responsable);
        //         $('#detalleServicio').text(res.servicio);

        //         // Llenar tabla
        //         $('#tablaDetalleInventario').html(res.tablaDetalle);

        //         // Abrir modal
        //         // $('#modalDetalleInventario').modal('show');
        //     });
        // });








        $('#buscarInventario').on('input', function() {
            const valor = $(this).val().trim();

            // Si el input tiene contenido, mostrar loading
            if (valor.length > 0) {
                $('#loadingDots').show();
            } else {
                $('#loadingDots').hide();
            }

            // Limpiar timer previo
            clearTimeout(debounceTimer);

            // Debounce: espera 3s desde la última tecla antes de disparar búsqueda
            debounceTimer = setTimeout(function() {
                $('#loadingDots').hide(); // Oculta animación cuando termina debounce
                $('#formFiltrosInventarios input[name="busqueda"]').val(valor);
                $('#formFiltrosInventarios').submit(); // AJAX submit
            }, 3000);
        });








        $('#toggleFechas').on('click', function() {
            usandoFechas = !usandoFechas;

            if (usandoFechas) {
                // Activar fechas, desactivar gestión
                $('#rangoFechas').removeClass('d-none');

                $('#fecha_inicio, #fecha_fin').prop('disabled', false);
                $(this).addClass('active'); // opcional para estilo
            } else {
                // Activar gestión, desactivar fechas
                $('#rangoFechas').addClass('d-none');

                $('#fecha_inicio, #fecha_fin').prop('disabled', true);
                $(this).removeClass('active');
            }
        });

        $('#fecha_inicio, #fecha_fin').prop('disabled', true);

        function cargarInventarios(url = null) {
            var form = $('#formFiltrosInventarios');
            var action = url || form.attr('action');

            $.ajax({
                url: action,
                type: 'GET',
                data: form.serialize(),
                success: function(data) {
                    // Actualiza el contenedor de resultados
                    $('#contenedorResultadosInventarios').html(data);
                },
                error: function(xhr) {
                    let mensaje2 = 'Error al cargar inventarios.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje2 = xhr.responseJSON.message;
                    }
                    mensaje(mensaje2, 'danger');
                }
            });
        }

        // Cuando se envía el formulario de filtros
        $('#formFiltrosInventarios').on('submit', function(e) {
            e.preventDefault();
            cargarInventarios();
        });

        // Paginación con AJAX
        $(document).on('click', '#contenedorResultadosInventarios .pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if (url) {
                cargarInventarios(url);
            }
        });











        $(function() {
            $('#formFiltrosInventarios').triggerHandler('submit');
        });


    });
</script>
