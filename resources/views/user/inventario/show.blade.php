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
                    <input type="hidden" name="busquedaActivo" value="">

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
                                    <option value="vigente" selected>Vigente</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="finalizado">Finalizado</option>
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
                {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarActivo">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Activo
                </button> --}}
                {{-- <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarActivo">
    <i class="bi bi-plus-lg me-1"></i> Registrar Activo
</button> --}}

            </div>



            {{--             
            <div class="card  p-3 mb-4 shadow-sm d-none h-40 position-relative" id="cardDetalleInventario"
                style="background-color:#e9f2ff7e; border-left: 5px solid #0d6efd;">

                <!-- Info del inventario -->
                <div class=" rounded h-100 w-100 p-4 d-flex flex-column" style="background-color:#e9f2ff;"> --}}

            <!-- Card de acciones (buscar, importar, exportar, bajas) -->
            <div class="card shadow-sm position-relative p-3 d-flex justify-content-center align-items-center mb-4"
                id="cardInventario"
                style="
        background-color: #e9f2ff7e; 
        border-left: 5px solid #0d6efd;
        box-sizing: border-box;
        min-height: 240px;
        max-height: none;
        overflow: visible;
     ">

                <!-- Contenedor interno centrado -->
                <div class="d-flex flex-column justify-content-center  p-4 rounded"
                    style="background-color:#e9f2ff; width: 100%; box-sizing: border-box;">


                    <!-- Aquí va TODO tu contenido -->



                    {{-- <h6 class="fw-bold mb-2">Información General</h6> --}}
                    <div class="row g-2 d-flex align-items-center ps-5">
                        <!-- Info del inventario -->

                        <!-- 🔍 Input de búsqueda -->
                        <div class="col-md-4">


                            <div class="mb-3">
                                <label class="form-label fw-semibold">Buscar inventario</label>
                                <div class="input-group">
                                    <input type="text" id="buscarInventario"
                                        class="form-control form-control-sm rounded-start-pill"
                                        placeholder="Número, gestión, servicio o responsable">
                                    <button class="btn btn-primary btn-sm rounded-end-pill" id="btnBuscarInventario"
                                        type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-semibold">Buscar activo en inventario</label>
                                <div class="input-group">
                                    <input type="text" id="buscarActivo"
                                        class="form-control form-control-sm rounded-start-pill"
                                        placeholder="Código, nombre o detalle del activo">
                                    <button class="btn btn-primary btn-sm rounded-end-pill" id="btnBuscarActivo"
                                        type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>





                        </div>

                        <div class="col-md-4"></div>




                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalFiltrosInventario">
                                <i class="bi bi-funnel-fill me-1"></i> Filtrar
                            </button>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button class="desactivado btn btn-azul btn-sm">
                                <i class="bi bi-printer-fill me-1"></i> Imprimir
                            </button>
                        </div>

                        {{-- <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-secondary btn-sm w-100" id="btnFiltrosInventarios"
                            data-bs-toggle="modal" data-bs-target="#modalFiltrosInventario">
                            <i class="bi bi-funnel me-1"></i> Filtros
                        </button>
                    </div> --}}

                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-success btn-sm w-100" id="btnGenerarPDF">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Generar PDF
                            </button>
                        </div>

                    </div>
                </div>
            </div>





            <div class="card shadow-sm d-none position-relative p-3 d-flex justify-content-center align-items-center mb-4"
                id="cardDetalleInventario"
                style="
        background-color: #e9f2ff7e; 
        border-left: 5px solid #0d6efd;
        box-sizing: border-box;
        min-height: 240px;
        max-height: none;
        overflow: visible;
     ">
                <input type="hidden" id="id_inventario_a" value="">
                <!-- Contenedor interno centrado -->
                <div class="d-flex flex-column justify-content-center fs2 p-4 rounded"
                    style="background-color:#e9f2ff; width: 100%; box-sizing: border-box;">


                    <!-- Aquí va TODO tu contenido -->

                    <div class="row d-flex align-items-center justify-content-start mb-3">
                        <div class="col-md-3">
                            <h4 class="fw-bold mb-0">Información General</h4>
                        </div>
                        {{-- <div class="col-md-6 d-flex align-items-center justify-content-center px-2">
                            <input type="text" id="buscarActivoInventario"
                                class="form-control form-control-sm rounded-start-pill"
                                placeholder="Buscar activo...">
                            <button class="btn btn-primary btn-sm rounded-end-pill" id="btnBuscarActivo"
                                type="button">
                                Buscar
                            </button>
                        </div> --}}
                        <div class="col-md-6 d-flex align-items-center justify-content-center px-2">
                            <div class="input-group" style="max-width: 300px;"> <!-- Limita ancho total -->
                                <input type="text" id="buscarActivoInventario"
                                    class="form-control form-control-sm rounded-start-pill"
                                    placeholder="Codigo, nombre o detalle del activo">
                                <button class="btn btn-primary btn-sm rounded-end-pill" id="btnBuscarActivoDetalle"
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


                        <!-- Input de búsqueda o botones de acción -->
                        {{-- <div class="input-group" style="width: 250px;">
                            
                        </div> --}}
                        {{-- <div class="col-md-1 d-flex align-items-end">
                            
                        </div> --}}
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

                    {{-- 
                    <h4 class="fw-bold mb-2">Información General</h4>
                    <div class="row g-2">
                        <div class="col-md-3"><strong>Número:</strong> <span id="detalleNumero"></span></div>
                        <div class="col-md-3"><strong>Gestión:</strong> <span id="detalleGestion"></span></div>
                        <div class="col-md-3"><strong>Fecha:</strong> <span id="detalleFecha"></span></div>
                        <div class="col-md-3"><strong>Estado:</strong> <span id="detalleEstado"
                                class="badge"></span>
                        </div>
                    </div> --}}
                    {{-- <div class="row g-2 mt-2">
                        <div class="col-md-4"><strong>Usuario:</strong> <span id="detalleUsuario"></span></div>
                        <div class="col-md-4"><strong>Responsable:</strong> <span id="detalleResponsable"></span>
                        </div>
                        <div class="col-md-4"><strong>Servicio:</strong> <span id="detalleServicio"></span></div>
                    </div> --}}
                    <!-- Datos secundarios -->
                    <div class="row g-2">
                        <div class="col-md-4"><strong>Usuario:</strong> <span id="detalleUsuario">-</span></div>
                        <div class="col-md-4"><strong>Responsable:</strong> <span id="detalleResponsable">-</span>
                        </div>
                        <div class="col-md-4"><strong>Servicio:</strong> <span id="detalleServicio">-</span></div>
                    </div>
                </div>

            </div>












            <div class="card shadow-sm d-none position-relative p-3 d-flex justify-content-center align-items-center mb-4"
                id="cardActualizarInventario"
                style="
        background-color: #e9f2ff7e; 
        border-left: 5px solid #0d6efd;
        box-sizing: border-box;
        min-height: 240px;
        max-height: none;
        overflow: visible;
     ">

                <!-- Contenedor interno centrado -->
                <div class="d-flex flex-column justify-content-center  p-4 rounded"
                    style="background-color:#e9f2ff; width: 100%; box-sizing: border-box;">


                    {{-- <div class="card mb-4 shadow-sm d-none" id="cardActualizarInventario"
                style="background-color: #f8f9fa; border-left: 5px solid #0d6efd; padding: 1.5rem;"> --}}

                    <input type="hidden" id="id_inventario_actualizar">
                    <input type="hidden" id="id_inventario_original">


                    {{-- <div class="mb-3 p-3 rounded" style="background-color:#e9f2ff;"> --}}
                    <h6 class="fw-bold mb-3">Información General</h6>

                    <style>
                        /* Inputs más compactos */
                        .input-compact {
                            height: 28px;
                            /* altura total */
                            padding: 2px 8px;
                            /* padding interno */
                            font-size: 0.85rem;
                            /* tamaño de letra más pequeño */
                        }
                    </style>

                    <div class="row g-2">

                        <!-- Número documento -->
                        <div class="col-md-2">
                            <input type="text" class="form-control input-compact" id="numero_documento"
                                placeholder="Número" readonly>
                            <small class="text-muted fst-italic">Generado automáticamente</small>
                        </div>

                        <!-- Gestión -->
                        <div class="col-md-2">
                            <input type="number" class="form-control input-compact" id="gestion"
                                placeholder="Gestión">
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-3">
                            <input type="date" class="form-control input-compact" id="fecha"
                                placeholder="Fecha">
                        </div>

                        <!-- Responsable -->
                        <div class="col-md-4">
                            <input type="text" class="form-control input-compact" id="responsable"
                                placeholder="responsable">
                            {{-- <select class="form-select input-compact" id="id_responsable">
            <option value="">Seleccione...</option>
        </select> --}}
                        </div>

                        <!-- Observaciones -->
                        <div class="col-md-4 mt-1">
                            <input type="text" class="form-control input-compact" id="observaciones"
                                placeholder="Observaciones">
                        </div>

                        <!-- Usuario hidden -->
                        <input type="hidden" id="id_usuario" value="{{ auth()->user()->id_usuario }}">
                    </div>


                </div>

            </div>









            <ul class="nav nav-pills mb-3 bg-light rounded p-1" id="tabsInventario" role="tablist">
                <li class="nav-item me-2" role="presentation">
                    <button class="nav-link active text-dark fw-semibold" id="tab-inventario" data-bs-toggle="tab"
                        data-bs-target="#contenedorResultadosInventarios" type="button" role="tab">
                        <i class="bi bi-box-seam me-1"></i> Inventarios
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link disabled d-none  text-dark fw-semibold" id="tab-detalle"
                        data-bs-toggle="tab" data-bs-target="#panelDetalleInventario" type="button" role="tab"
                        aria-disabled="true">
                        <i class="bi bi-card-list me-1"></i> Detalles
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link disabled d-none  text-dark fw-semibold" id="tab-actualizar"
                        data-bs-toggle="tab" data-bs-target="#panelActualizarInventario" type="button"
                        role="tab" aria-disabled="true">
                        <i class="bi bi-card-list me-1"></i> Actualizar
                    </button>
                </li>
            </ul>
            <div class="tab-content d-flex flex-column position-relative overflow-auto p-3 bg-da5nger"
                style="height: 65vh max-height: 65vh; min-height: 65vh;">

                <!-- Inventarios -->
                <div class="tab-pane fade show active flex-grow-1 bg-info8 position-relative"
                    id="contenedorResultadosInventarios" role="tabpanel">
                    <div id="contenedorTablaInventarios" class="d-flex flex-column bg-dange3r rounded p-2"
                        style="height: 100%; max-height: 100%; overflow-y: auto;">
                        <!-- Aquí se cargará la tabla de inventarios dinámicamente -->
                    </div>
                </div>

                <!-- Detalle Inventario -->
                <div class="tab-pane fade position-relative" id="panelDetalleInventario" role="tabpanel">
                    <div id="contenidoDetalleInventario" class="d-flex flex-column bg-dange3r rounded p-2"
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
                                <tbody id="tablaDetalleInventario">
                                    <!-- Aquí se llenará dinámicamente con AJAX -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade position-relative" id="panelActualizarInventario" role="tabpanel">
                    <div id="contenidoActualizarInventario" class="d-flex flex-column bg-dange3r rounded p-2"
                        style="height: 100%; max-height: 100%; overflow-y: auto;">
                        <!-- Aquí se cargará la tabla de detalles dinámicamente -->
                        <div class="table-responsive" style="max-height:60vh; overflow-y:auto;">
                            <table class="table table-striped mb-0 rounded ">
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
                                <tbody id="tablaActualizarInventario">
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
        let tieneActualizar = false;




        // $(document).on('click', '.ver-detalles-btn', function() {
        //     const $btn = $(this);
        //     const idInventario = $btn.data('id_inventario');
        //     $('#tab-detalle').removeClass('d-none');

        //     // Quitar clase active de otros botones
        //     $('.ver-detalles-btn').removeClass('active');
        //     $btn.addClass('active');

        //     // Habilitar la pestaña detalle si estaba deshabilitada
        //     $('#tab-detalle').removeClass('disabled');
        //     const detalleTab = new bootstrap.Tab(document.querySelector('#tab-detalle'));
        //     detalleTab.show();

        //     // AJAX al controlador para traer los datos del inventario
        //     $.get(`${baseUrl}/inventarios/detalle/${idInventario}`, function(res) {

        //         // Mostrar u ocultar pestaña de actualizar según estado
        //         if (res.estado === 'vigente') {
        //             $('#tab-actualizar').removeClass('disabled d-none');
        //             const actualizarTab = new bootstrap.Tab(document.querySelector('#tab-actualizar'));
        //             // actualizarTab.show(); // Opcional
        //             $('#id_inventario_actualizar').val(res.id_inventario);
        //         } else {
        //             $('#tab-actualizar').addClass('disabled d-none');
        //             $('#id_inventario_actualizar').val('');
        //         }

        //         // Colocar los datos en los labels
        //         $('#detalleNumero').text(res.numero || '-');
        //         $('#detalleGestion').text(res.gestion || '-');
        //         $('#detalleFecha').text(res.fecha || '-');

        //         // Estado con color
        //         let estadoClass = 'bg-secondary';
        //         if (res.estado === 'vigente') estadoClass = 'bg-success';
        //         else if (res.estado === 'pendiente') estadoClass = 'bg-primary';
        //         else if (res.estado === 'finalizado') estadoClass = 'bg-dark';
        //         $('#detalleEstado').text(res.estado || '-').removeClass().addClass('badge ' + estadoClass);

        //         $('#detalleUsuario').text(res.usuario || '-');
        //         $('#detalleResponsable').text(res.responsable || '-');
        //         $('#detalleServicio').text(res.servicio || '-');

        //         // Llenar la tabla de detalles desde res.detalles
        //         const detalles = res.detalles || [];
        //         let tablaHtml = '';

        //         if (detalles.length > 0) {
        //             detalles.forEach((detalle, i) => {
        //                 tablaHtml += '<tr>';
        //                 tablaHtml += `<td>${i+1}</td>`;
        //                 tablaHtml += `<td>${detalle.codigo}</td>`;
        //                 tablaHtml += `<td>${detalle.nombre}</td>`;
        //                 tablaHtml += `<td>${detalle.estado_actual}</td>`;
        //                 tablaHtml += `<td>${detalle.observaciones}</td>`;
        //                 tablaHtml += '<td>';

        //                 // Botón ver (siempre)
        //                 tablaHtml += `
        //                     <button class="btn btn-sm btn-primary opacity-75 ver-activo-btn" 
        //                             title="Ver detalles del activo"
        //                             data-id="${detalle.id_activo}">
        //                         <i class="bi bi-eye"></i>
        //                     </button>
        //                 `;

        //                 // Botón mover (solo si inventario vigente)
        //                 if (res.estado === 'vigente') {
        //                     tablaHtml += `
        //                         <button class="btn btn-sm btn-success mover-activo-btn ms-1"
        //                                 title="Mover / actualizar activo"
        //                                 data-id="${detalle.id_activo}">
        //                             <i class="bi bi-arrow-right-circle"></i>
        //                         </button>
        //                     `;
        //                 }

        //                 // Botón dar de baja (siempre)
        //                 tablaHtml += `
        //                     <button class="btn btn-sm btn-dark baja-activo-btn ms-1"
        //                             title="Dar de baja este activo"
        //                             data-id="${detalle.id_activo}">
        //                         <i class="bi bi-arrow-down-circle"></i>
        //                     </button>
        //                 `;

        //                 tablaHtml += '</td>';
        //                 tablaHtml += '</tr>';
        //             });
        //         } else {
        //             tablaHtml = '<tr><td colspan="6" class="text-center">No hay detalles</td></tr>';
        //         }

        //         // Insertar en la tabla
        //         $('#tablaDetalleInventario').html(tablaHtml);

        //     }).fail(function(err) {
        //         mensaje('No se pudo cargar el detalle del inventario.', 'danger');
        //     });
        // });
        $(document).on('click', '.regresar-activo-btn', function() {

            let idActivo = $(this).data('id');
            let idInventarioVigente = $('#id_inventario_original').val();
            let idInventarioPendiente = $('#cardDetalleInventario').find('input#id_inventario_a').val();
            if (!idActivo || !idInventarioVigente || !idInventarioPendiente) {
                const actualizarTab = new bootstrap.Tab(document.querySelector('#tab-actualizar'));
                actualizarTab.show();
                return;
            }

            let filaClick = $(this).closest('tr');

            // Confirmación
            Swal.fire({
                title: "¿Regresar activo?",
                text: "El activo volverá al inventario vigente.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, regresar",
                cancelButtonText: "Cancelar"
            }).then((result) => {

                if (!result.isConfirmed) return;

                // Loading
                Swal.fire({
                    title: "Procesando...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                // AJAX
                $.ajax({
                    url: "{{ route('inventarios.regresarActivo') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_activo: idActivo,
                        id_inventario_origen: idInventarioVigente,
                        id_inventario_pendiente: idInventarioPendiente
                    },
                    success: function(resp) {

                        Swal.close();

                        if (resp.success) {

                            // 🔥 1️⃣ Eliminar la fila correspondiente en tablaActualizarInventario
                            let filaActualizar = $('#tablaActualizarInventario')
                                .find('.regresar-activo-btn[data-id="' + idActivo +
                                    '"]').closest('tr');
                            filaActualizar.fadeOut(200, function() {
                                $(this).remove();
                            });

                            // 🔥 2️⃣ Activar botón MOVER en tablaDetalleInventario
                            let btnMover = $('.mover-activo-btn[data-id="' +
                                idActivo + '"]');
                            btnMover.prop('disabled', false);

                            // 🔥 3️⃣ Desactivar botón REGRESAR en tablaDetalleInventario
                            let btnRegresarDetalle = $(
                                '.regresar-activo-btn[data-id="' + idActivo +
                                '"]');
                            btnRegresarDetalle.prop('disabled', true);

                            // Mensaje final
                            Swal.fire({
                                title: "Éxito",
                                text: "El activo fue regresado correctamente.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });

                        } else {
                            Swal.fire("Error", resp.mensaje, "error");
                        }
                    },

                    error: function() {
                        Swal.close();
                        Swal.fire("Error", "Ocurrió un error inesperado.", "error");
                    }
                });

            });

        });


        $(document).on('click', '.mover-activo-btn', function() {
            const btnMover = $(this);
            const fila = btnMover.closest('tr');

            const idActivo = btnMover.data('id');
            const idInventarioDestino = $('#cardDetalleInventario').find('input#id_inventario_a').val();
            const idInventarioActual = $('#id_inventario_original').val();

            if (!idActivo || !idInventarioActual || !idInventarioDestino) {
                const actualizarTab = new bootstrap.Tab(document.querySelector('#tab-actualizar'));
                actualizarTab.show();
                return;
            }

            Swal.fire({
                title: 'Moviendo activo...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: `${baseUrl}/inventarios/mover-activo`,
                method: 'POST',
                data: {
                    id_activo: idActivo,
                    id_inventario_actual: idInventarioActual,
                    id_inventario_destino: idInventarioDestino,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    Swal.close();

                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: res.mensaje,
                            timer: 1500, // dura 1.5 segundos
                            showConfirmButton: false
                        });


                        // Desactivar botón MOVER en la fila original
                        btnMover.prop('disabled', true);

                        // Activar botón REGRESAR en la fila original
                        fila.find('.regresar-activo-btn').prop('disabled', false);

                        // Agregar nueva fila en tablaActualizarInventario
                        const d = res.detalle;

                        let nuevaFila = `
                    <tr>
                        <td>${d.numero}</td>
                        <td>${d.codigo}</td>
                        <td>${d.nombre}</td>
                        <td>${d.detalle}</td>
                        <td>
                            <select class="form-select form-select-sm estado-select" data-id="${d.id_detalle}">
                                ${d.estados_html}
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm observacion-input"
                                value="${d.observaciones}" data-id="${d.id_detalle}">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger regresar-activo-btn ms-1"
                                data-id="${d.id_activo}">
                                <i class="bi bi-arrow-left-circle"></i>
                            </button>
                        </td>
                    </tr>
                `;

                        $('#tablaActualizarInventario').append(nuevaFila);

                    } else {
                        Swal.fire('Error', res.mensaje, 'error');
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire('Error', 'Ocurrió un error al mover el activo.', 'error');
                }
            });
        });




        $(document).on('click', '.ver-detalles-btn', function() {
            const $btn = $(this);
            const idInventario = $btn.data('id_inventario');
            $('#tab-detalle').removeClass('d-none');

            // Debug: botón activo
            // console.log('Botón clickeado, id inventario:', idInventario);
            $('#tab-detalle').removeClass('disabled');
            const detalleTab = new bootstrap.Tab(document.querySelector('#tab-detalle'));
            detalleTab.show();
            if ($btn.hasClass('active')) {
                return;
            }
            // Quitar clase active de otros botones
            $('.ver-detalles-btn').removeClass('active');
            $btn.addClass('active');

            // Habilitar la pestaña detalle si estaba deshabilitada




            // AJAX al controlador para traer los datos del inventario
            $.get(`${baseUrl}/inventarios/detalle/${idInventario}`, function(res) {
                if (res.estado === 'vigente') {
                    $('#tab-actualizar').removeClass('disabled d-none');

                    const actualizarTab = new bootstrap.Tab(document.querySelector(
                        '#tab-actualizar'));
                    // actualizarTab.show(); // Si quieres mostrarlo inmediatamente

                    // Guardar id_inventario dentro del input oculto
                    $('#id_inventario_actualizar').val(res.id_inventario);
                    $('#id_inventario_original').val(res.id_inventario);
                    tieneActualizar = false;

                } else {
                    $('#tab-actualizar').addClass('disabled d-none');

                    // Limpiar el input oculto si no es vigente

                    $('#id_inventario_original').val('');
                    $('#id_inventario_actualizar').val('');
                }

                // Colocar los datos en los labels
                $('#detalleNumero').text(res.numero || '-');
                $('#detalleGestion').text(res.gestion || '-');
                $('#detalleFecha').text(res.fecha || '-');
                // alert($('#detalleNumero').text())

                // Estado con color
                let estadoClass = 'bg-secondary';
                if (res.estado === 'vigente') estadoClass = 'bg-success';
                else if (res.estado === 'pendiente') estadoClass = 'bg-primary';
                else if (res.estado === 'finalizado') estadoClass = 'bg-dark';
                $('#detalleEstado').text(res.estado || '-').removeClass().addClass('badge ' +
                    estadoClass);

                $('#detalleUsuario').text(res.usuario || '-');
                $('#detalleResponsable').text(res.responsable || '-');
                $('#detalleServicio').text(res.servicio || '-');

                // Llenar la tabla de detalles
                $('#tablaDetalleInventario').html(res.tablaDetalle ||
                    '<tr><td colspan="7" class="text-center">No hay detalles</td></tr>');

                // Mostrar card de detalle
                // $('#cardDetalleInventario').removeClass('d-none');
                // // Opcional: ocultar card principal de inventarios
                // $('#cardInventarios').addClass('d-none');
            }).fail(function(err) {
                // console.error('Error al cargar detalle del inventario:', err);
                mensaje('No se pudo cargar el detalle del inventario.', 'danger');
            });
        });














        // Control de cards según pestaña activa
        $('#tabsInventario button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            const target = $(e.target).data('bs-target'); // ID de la pestaña que se activó

            if (target === '#contenedorResultadosInventarios') {
                $('#cardInventario').removeClass('d-none');
                $('#cardDetalleInventario').addClass('d-none');
                $('#cardActualizarInventario').addClass('d-none');
            } else if (target === '#panelDetalleInventario') {
                // Mostramos card de detalle y ocultamos inventarios
                $('#cardDetalleInventario').removeClass('d-none');
                $('#cardInventario').addClass('d-none');
                $('#cardActualizarInventario').addClass('d-none');
            } else if (target === '#panelActualizarInventario') {
                // Mostramos card de detalle y ocultamos inventarios
                $('#cardDetalleInventario').addClass('d-none');
                $('#cardInventario').addClass('d-none');
                $('#cardActualizarInventario').removeClass('d-none');
                if (!tieneActualizar) {

                    actualizarInventario()
                }
            }
        });



        function actualizarInventario() {
            // alert(tieneActualizar)
            // Leer idInventario desde input oculto
            const idInventario = $('#id_inventario_actualizar').val();

            if (!idInventario) {
                Swal.fire('Error', 'No hay ID de inventario disponible.', 'warning');
                return;
            }

            // Mostrar mensaje de búsqueda
            Swal.fire({
                title: 'Buscando inventario...',
                text: 'Espere un momento',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            // AJAX al controlador para consultar inventario pendiente
            $.ajax({
                url: `${baseUrl}/inventarios/pendiente/${idInventario}`,
                method: 'GET',
                success: function(res) {
                    Swal.close(); // cerrar "Buscando"

                    if (res.encontrado) {
                        // Inventario pendiente encontrado
                        Swal.fire({
                            title: 'Inventario encontrado',
                            timer: 1000,
                            showConfirmButton: false,
                            icon: 'success'
                        });

                        // Poner valores en inputs del inventario
                        $('#numero_documento').val(res.numero || '-');
                        $('#gestion').val(res.gestion || '-');
                        $('#fecha').val(res.fecha || '-');
                        $('#responsable').val(res.responsable || '');
                        $('#observaciones').val(res.observaciones || '');
                        $('#id_usuario').val(res.usuario || '');
                        $('#id_inventario_actualizar').val(res.id_inventario);

                        // Insertar tabla que ya viene desde el controlador
                        $('#tablaActualizarInventario').html(res.tablaDetalle);

                        // Opcional: mostrar el tab si estaba oculto
                        const actualizarTab = new bootstrap.Tab(document.querySelector(
                            '#tab-actualizar'));
                        actualizarTab.show();
                        //                         const $tabEl = $('#panelActualizarInventario-tab');
                        // if ($tabEl.length) {
                        //     const actualizarTab = new bootstrap.Tab($tabEl[0]);
                        //     actualizarTab.show();
                        // }else {
                        //     console.warn('#panelActualizarInventario-tab no encontrado');
                        // }
                        $('input#id_inventario_a').val(res.id_inventario);
                        tieneActualizar = true;
                    } else {

                        Swal.fire({
                            title: 'No se encontró inventario pendiente',
                            text: '¿Deseas generar uno automáticamente?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, generar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (!result.isConfirmed) {
                                // El usuario canceló → detener ejecución
                                return;
                            }

                            // 🔹 Solo se ejecuta si el usuario confirma
                            $.post(`${baseUrl}/inventarios/generar`, {
                                id_inventario: idInventario,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            }, function(resGenerado) {

                                Swal.close();

                                if (resGenerado && resGenerado.inventario) {
                                    Swal.fire({
                                        title: 'Inventario generado',
                                        text: 'Se creó un inventario pendiente automáticamente.',
                                        timer: 1000,
                                        showConfirmButton: false,
                                        icon: 'success'
                                    });

                                    const nuevo = resGenerado.inventario;

                                    // Poner valores del nuevo inventario
                                    $('#detalleNumero').text(nuevo
                                        .numero_documento || '-');
                                    $('#detalleGestion').text(nuevo.gestion || '-');
                                    $('#detalleFecha').text(nuevo.fecha || '-');
                                    $('#id_inventario_actualizar').val(nuevo
                                        .id_inventario);
                                    tieneActualizar = true;
                                    $('input#id_inventario_a').val(nuevo
                                        .id_inventario);

                                    // Tabla vacía inicial
                                    $('#tablaDetalleInventario').html(
                                        '<tr><td colspan="7" class="text-center">No hay detalles aún</td></tr>'
                                    );
                                } else {
                                    Swal.fire('Error',
                                        'No se pudo generar el inventario pendiente.',
                                        'error');
                                }
                            }).fail(function() {
                                Swal.close();
                                Swal.fire('Error',
                                    'Ocurrió un error al generar el inventario pendiente.',
                                    'error');
                            });
                        });

                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire('Error', 'Ocurrió un error al consultar el inventario.', 'error');
                }
            });
        }






        function resetCardDetalleInventario() {
            $('#detalleNumero').text('-');
            $('#detalleGestion').text('-');
            $('#detalleFecha').text('-');
            $('#detalleEstado').text('-').removeClass().addClass('badge bg-secondary');
            $('#detalleUsuario').text('-');
            $('#detalleResponsable').text('-');
            $('#detalleServicio').text('-');
            $('#tab-detalle').addClass('d-none');

            // Vaciar tabla de detalles sin tocar la estructura
            $('#tablaDetalleInventario').html('');


            //tbala de actualizar
            $('#numero_documento').val('-');
            $('#gestion').val('-');
            $('#fecha').val('-');
            $('#responsable').val('');
            $('#observaciones').val('');
            $('#id_usuario').val('');
            $('#id_inventario_actualizar').val('');

            // Insertar tabla que ya viene desde el controlador
            $('#tablaActualizarInventario').html('');

            $('#tab-actualizar').addClass('d-none');
            tieneActualizar = false;
        }

        $(document).on('click', '#btnBuscarActivoDetalle', function() {
            const valor = $('#buscarActivoInventario').val().trim().toLowerCase();

            $('#tablaDetalleInventario tr').each(function() {
                const fila = $(this);
                // Tomamos columnas 1, 2 y 3 (índices 0, 1, 2)
                // const col1 = fila.find('td:eq(0)').text().toLowerCase();
                const col1 = fila.find('td:eq(1)').text().toLowerCase();
                const col2 = fila.find('td:eq(2)').text().toLowerCase();
                const col3 = fila.find('td:eq(3)').text().toLowerCase();

                if (col1.includes(valor) || col2.includes(valor) || col3.includes(valor)) {
                    fila.show();
                } else {
                    fila.hide();
                }
            });
        });

        $('#btnBuscarActivo').on('click', function() {
            const busqueda = $('#buscarActivo').val().trim();
            // const idInventario = $('#id_inventario_actualizar').val(); // id del inventario actual

            $('#formFiltrosInventarios input[name="busquedaActivo"]').val(busqueda);

            // Enviar el formulario (puede ser AJAX o submit normal)
            $('#formFiltrosInventarios').submit();
        });



        // Botón buscar inventario
        $('#btnBuscarInventario').on('click', function() {
            const valor = $('#buscarInventario').val().trim();

            // if (valor.length === 0) {
            //     Swal.fire('Aviso', 'Ingresa un valor para buscar.', 'warning');
            //     return;
            // }

            // Opcional: mostrar algún indicador de carga
            // $('#loadingIndicator').show();

            // Asignar valor al input oculto del formulario
            $('#formFiltrosInventarios input[name="busqueda"]').val(valor);

            // Enviar el formulario (puede ser AJAX o submit normal)
            $('#formFiltrosInventarios').submit();
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

            resetCardDetalleInventario()
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
