<style>
    /* Destacar inputs activos */
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



{{--

<!-- 🧩 Modal de filtros -->
<div class="modal fade" id="modalFiltros" tabindex="-1" aria-labelledby="modalFiltrosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: var(--color-fondo); color: var(--color-texto-principal);">

            <!-- Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalFiltrosLabel"><i class="bi bi-funnel-fill me-2"></i>Filtros de
                    búsqueda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-0">

                <form id="formFiltrosActivos" action="{{ route('activos.filtrar') }}" method="GET">

                    <!-- 🧾 Sección 1: Identificación -->
                    <div class="mb-4">
                        <h6 class="fw-bold border-bottom pb-1 mb-3"><i class="bi bi-upc-scan me-1"></i> Identificación
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="filtro_codigo" class="form-label">Código</label>
                                <input type="text" id="filtro_codigo" name="codigo" class="form-control"
                                    placeholder="Ej: AMD-003">
                            </div>
                            <div class="col-md-4">
                                <label for="filtro_nombre" class="form-label">Nombre</label>
                                <input type="text" id="filtro_nombre" name="nombre" class="form-control"
                                    placeholder="Nombre del activo">
                            </div>
                            <div class="col-md-4">
                                <label for="filtro_detalle" class="form-label">Detalle</label>
                                <input type="text" id="filtro_detalle" name="detalle" class="form-control"
                                    placeholder="Palabras clave">
                            </div>
                        </div>
                    </div>

                    <!-- 🏷 Clasificación -->
                    <div class="mb-4">
                        <h6 class="fw-bold border-bottom pb-1 mb-3"><i class="bi bi-tags-fill me-1"></i> Clasificación
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="filtro_categoria" class="form-label">Categoría</label>
                                <select id="filtro_categoria" name="categoria" class="form-select">
                                    <option value="all" selected>Todos</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="filtro_unidad" class="form-label">Unidad de Medida</label>
                                <select id="filtro_unidad" name="unidad" class="form-select">
                                    <option value="all" selected>Todos</option>
                                    @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad->id_unidad }}">{{ $unidad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ⚙️ Estado y orden -->
                    <div class="mb-4">
                        <h6 class="fw-bold border-bottom pb-1 mb-3"><i class="bi bi-gear-wide-connected me-1"></i>
                            Estado y Orden</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="filtro_estado" class="form-label">Estado físico</label>
                               <select id="filtro_estado" name="estado" class="form-select">
    <option value="all" selected>Todos</option>
    @foreach ($estados as $estado)
        <option value="{{ $estado->id_estado }}">{{ $estado->nombre }}</option>
    @endforeach
</select>

                            </div>
                            <div class="col-md-4">
                                <label for="ordenar_por" class="form-label">Ordenar por</label>
                                <select id="ordenar_por" name="ordenar_por" class="form-select">
                                    <option value="created_at" selected>Fecha de creación</option>
                                    <option value="codigo">Código</option>
                                    <option value="nombre">Nombre</option>
                                    <option value="detalle">Detalle</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="direccion" class="form-label">Dirección</label>
                                <select id="direccion" name="direccion" class="form-select">
                                    <option value="desc" selected>Descendente</option>
                                    <option value="asc">Ascendente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 📅 Rango de fechas -->
                    <div>
                        <button type="button" class="btn btn-outline-primary w-100 mb-3" id="toggleFechas">
                            <i class="bi bi-calendar3"></i> Mostrar / Ocultar rango de fechas
                        </button>

                        <div id="rangoFechas" class="d-none">
                            <label class="form-label fw-bold mb-2">Rango de fechas</label>
                            <div class="row g-3 mb-3">

                                <!-- Fecha Inicio -->
                                <div class="col-12 col-md-6">
                                    <label for="fecha_inicio" class="form-label small text-muted">Fecha Inicio</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                        value="2017-01-01">

                                    <!-- Slider para inicio -->
                                    <input type="range" id="slider_start" value="0" min="0"
                                        max="100" step="1" class="form-range mt-1">
                                </div>

                                <!-- Fecha Fin -->
                                <div class="col-12 col-md-6">
                                    <label for="fecha_fin" class="form-label small text-muted">Fecha Fin</label>
                                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control"
                                        value="{{ date('Y-m-d') }}">

                                    <!-- Slider para fin -->
                                    <input type="range" id="slider_end" value="100" min="0"
                                        max="100" step="1" class="form-range mt-1">
                                </div>



                                {{-- <!-- Fecha Inicio --> <div class="col-12 col-md-6"> <label for="fecha_inicio" class="form-label small text-muted">Fecha Inicio</label> <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="2017-01-01"> <!-- Slider para fecha_inicio --> <input type="range" id="slider_start" value="0" min="0" max="100" step="1" class="form-range mt-1"> </div> <!-- Fecha Fin --> <div class="col-12 col-md-6"> <label for="fecha_fin" class="form-label small text-muted">Fecha Fin</label> <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="{{ date('Y-m-d') }}"> <!-- Slider para fecha_fin --> <input type="range" id="slider_end" value="100" min="0" max="100" step="1" class="form-range mt-1"> </div> </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="reset" form="formFiltrosActivos" id="btnLimpiarActivos" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar
                </button>
                <button type="submit" form="formFiltrosActivos" class="btn btn-primary">
                    <i class="bi bi-search"></i> Aplicar filtros
                </button>
            </div>

        </div>
    </div>
</div> --}}


<!-- 🧩 Modal de filtros -->
<div class="modal fade" id="modalFiltros" tabindex="-1" aria-labelledby="modalFiltrosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #fdfdfd; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-primary bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalFiltrosLabel">
                    <i class="bi bi-funnel-fill me-2"></i>Filtros de búsqueda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">

                <form id="formFiltrosActivos" action="{{ route('activos.filtrar') }}" method="GET">

                    <!-- 🧾 Sección 1: Identificación -->
                    <div class="mb-4 p-3 rounded" style="background-color: #e9f2ff;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-upc-scan me-1"></i> Identificación
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="filtro_codigo" class="form-label">Código</label>
                                <input type="text" id="filtro_codigo" name="codigo" class="form-control"
                                    placeholder="Ej: AMD-003">
                            </div>
                            <div class="col-md-4">
                                <label for="filtro_nombre" class="form-label">Nombre</label>
                                <input type="text" id="filtro_nombre" name="nombre" class="form-control"
                                    placeholder="Nombre del activo">
                            </div>
                            <div class="col-md-4">
                                <label for="filtro_detalle" class="form-label">Detalle</label>
                                <input type="text" id="filtro_detalle" name="detalle" class="form-control"
                                    placeholder="Palabras clave">
                            </div>
                        </div>
                    </div>

                    <!-- 🏷 Clasificación -->
                    {{-- <div class="mb-4 p-3 rounded" style="background-color: #f0f7e8;"> --}}
                    <div class="mb-4 p-3 rounded" style="background-color: #b9c8e72d;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-tags-fill me-1"></i> Clasificación
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="filtro_categoria" class="form-label">Categoría</label>
                                <select id="filtro_categoria" name="categoria" class="form-select">
                                    <option value="all" selected>Todos</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="filtro_unidad" class="form-label">Unidad de Medida</label>
                                <select id="filtro_unidad" name="unidad" class="form-select">
                                    <option value="all" selected>Todos</option>
                                    @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad->id_unidad }}">{{ $unidad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ⚙️ Estado y orden -->
                    {{-- <div class="mb-4 p-3 rounded" style="background-color: #fff3e668;"> --}}
                    <div class="mb-4 p-3 rounded" style="background-color: #f9cece27;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-gear-wide-connected me-1"></i> Estado y Orden
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="filtro_estado" class="form-label">Estado físico</label>
                                <select id="filtro_estado" name="estado" class="form-select">
                                    <option value="all" selected>Todos</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado->id_estado }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="ordenar_por" class="form-label">Ordenar por</label>
                                <select id="ordenar_por" name="ordenar_por" class="form-select">
                                    <option value="created_at" selected>Fecha de creación</option>
                                    <option value="codigo">Código</option>
                                    <option value="nombre">Nombre</option>
                                    <option value="detalle">Detalle</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="direccion" class="form-label">Dirección</label>
                                <select id="direccion" name="direccion" class="form-select">
                                    <option value="desc" selected>Descendente</option>
                                    <option value="asc">Ascendente</option>
                                </select>
                            </div>

                            <!-- 🔹 Nuevo input: Estado Situacional -->
                            <div class="col-md-4 mt-3">
                                <label for="estado_situacional" class="form-label">Estado Situacional</label>
                                <select id="estado_situacional" name="estado_situacional" class="form-select">
                                    <option value="all" selected>Todos</option>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                    <option value="baja">De Baja</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- 📅 Rango de fechas -->
                    <div class="mb-3 p-3 rounded" style="background-color: #f5f5f5;">
                        <button type="button" class="btn btn-outline-primary w-100 mb-3" id="toggleFechas">
                            <i class="bi bi-calendar3"></i> Mostrar / Ocultar rango de fechas
                        </button>

                        <div id="rangoFechas" class="d-none">
                            <label class="form-label fw-bold mb-2">Rango de fechas</label>
                            <div class="row g-3 mb-3">

                                <!-- Fecha Inicio -->
                                <div class="col-12 col-md-6">
                                    <label for="fecha_inicio" class="form-label small text-muted">Fecha Inicio</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                        value="2017-01-01">
                                    <input type="range" id="slider_start" value="0" min="0"
                                        max="100" step="1" class="form-range mt-1">
                                </div>

                                <!-- Fecha Fin -->
                                <div class="col-12 col-md-6">
                                    <label for="fecha_fin" class="form-label small text-muted">Fecha Fin</label>
                                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                    <input type="range" id="slider_end" value="100" min="0"
                                        max="100" step="1" class="form-range mt-1">
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="reset" form="formFiltrosActivos" id="btnLimpiarActivos" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar
                </button>
                <button type="submit" form="formFiltrosActivos" class="btn btn-primary">
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
                @include('user.activos.registrar')
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








<div class="row  bg-info0 pb-4 justify-content-center" style="height: 90vh;min-height: 30vh;max-height:94vh">
    {{-- <div class="main-col col-md-12 col-lg-10 bg-danger order-lg-1 order-1 mb-4 p-1 transition"
         style="position: relative;height: 100%; min-height: 40vh; max-height:100vh display: flex; flex-direction: column; "> --}}
    <div class="main-col col-md-12 col-lg-11 bg-danger0 order-lg-1 order-1 mb-4 p-1 transition"
        style="position: relative; height: 80vh; min-height: 40vh; max-height: 80vh; display: flex; flex-direction: column; overflow: visible;">

        {{-- <div class="card p-4 rounded shadow" style="background-color: var(--color-fondo); display: flex; flex-direction: column; height: 100%;"> --}}
        {{-- <div class="card p-4 rounded shadow"
     style="background-color: var(--color-fondo);  display: flex; flex-direction: column; min-height 100vh;height: 100vh;"> --}}
        <div class="card p-4 rounded shadow"
            style="position: relative;  background-color: var(--color-fondo); display: flex; flex-direction: column; flex: 1 1 auto;">


            <!-- Título -->
            <h2 class="mb-4 text-center text-primary">
                <i class="bi bi-box-seam me-2"></i>Lista de Activos
            </h2>

            <!-- Botones principales -->
            <div class="d-flex justify-content-end mb-3 gap-2">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarActivo">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Activo
                </button>
                {{-- <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarActivo">
    <i class="bi bi-plus-lg me-1"></i> Registrar Activo
</button> --}}
                <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                    <i class="bi bi-funnel-fill me-1"></i> Filtrar
                </button>
                <button class="desactivado btn btn-azul btn-sm">
                    <i class="bi bi-printer-fill me-1"></i> Imprimir
                </button>
            </div>

            <!-- Card de acciones (buscar, importar, exportar, bajas) -->
            <div class="card mb-4 shadow-sm "
                style=" background-color: #f8f9fa;
            border-left: 5px solid #0d6efd;
            padding: 1.5rem;">
                <div class="row g-3 p-3">

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-search me-1"></i>Buscar activo
                        </label>

                        <input type="text" id="buscarActivo"
                            class="form-control form-control-sm rounded-pill shadow-sm px-3"
                            placeholder="Nombre, código o detalle">
                    </div>

                    <div class="col-md-1"></div>

                    <div class="col-md-2 d-flex align-items-end">

                    </div>

                    {{-- <div class="col-md-2 d-flex align-items-end">
                        <button class="desactivado btn btn-success btn-sm w-100" id="btnImportarExcel"><i class="bi bi-file-earmark-arrow-up me-1"></i> Importar Excel</button>
                    </div> --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-success btn-sm w-100" id="btnImportarExcel">
                            <i class="bi bi-file-earmark-arrow-up me-1"></i> Importar Excel
                        </button>
                        <input type="file" id="inputExcel" accept=".xls,.xlsx,.csv" style="display: none;">
                        <div id="modalSubida" class="modal">
                            <div class="modal-content">
                              <h2>Subir archivo Excel</h2>
                              <div id="dropZone">
                                Arrastra tu archivo aquí o haz clic para seleccionarlo.
                                <input type="file" id="inputExcel" accept=".xls,.xlsx" hidden>
                              </div>
                              <button id="btnCerrarModal">Cerrar</button>
                            </div>
                          </div>
                    </div>



                    <div class="col-md-2 d-flex align-items-end">
                        <button class="desactivado btn btn-light btn-sm w-100" id="btnExportarExcel"><i
                                class="bi bi-file-earmark-arrow-down me-1"></i> Exportar Excel</button>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="desactivado btn btn-dark btn-sm w-100" id="btnVerBajas"><i
                                class="bi bi-archive me-1"></i> Ver bajas</button>
                    </div>

                </div>
            </div>

            <!-- Contenedor de resultados -->
            {{-- <div id="contenedorResultados"
                 class="bg-secondary rounded bg-opacity-10 flex-grow-1"
                 style="overflow-y: auto; padding: 15px;"> --}}
            <div id="contenedorResultados" class="d-flex flex-column bg- rounded shadow p-3 bg-info0 p-3"
                style="height: 60vh; max-height: 80vh; ">
                <!-- Aquí van los resultados -->
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.modal').on('click', function(e) {
            if ($(e.target).is('.modal')) {
                $(this).find('input, select, textarea, button').blur();
                console.log('Click fuera del modal, cerrándolo...');
                $(this).blur()
                $(this).find('button[data-bs-dismiss="modal"]').trigger('click');
            }
        });
        $(document).on('click', '.modal .btn-close[data-bs-dismiss="modal"]', function() {
            console.log('Se hizo clic en el botón X del modal Registrar Activo');
            $(this).blur(); // Quita el foco del botón X
            // alert($('.modal fade show').html()) // Quita el foco del botón X
        });


        // $('.modal fade show').on('hide.bs.modal', function() {
        //     $(this).find('input, select, textarea, button').blur();

        //     $(this).find('button[data-bs-dismiss="modal"]').blur();
        //     $(this).focus();
        //     // $(this).focus();
        //     // alert($(this).html())
        //     $('body').attr('tabindex', '-1').focus();
        // });


        $('#buscarActivo').on('keyup', function() {
            let valor = $(this).val().toLowerCase();

            $('#contenedorResultados table tbody tr').filter(function() {
                // Buscamos en Código, Nombre y Detalle
                $(this).toggle(
                    $(this).find('td:eq(0)').text().toLowerCase().indexOf(valor) > -1 ||
                    $(this).find('td:eq(1)').text().toLowerCase().indexOf(valor) > -1 ||
                    $(this).find('td:eq(2)').text().toLowerCase().indexOf(valor) > -1
                );
            });
        });
    });
</script>
















<div id="iframeContainer"
    style="display:none; position:fixed; top:10%; left:10%; width:80%; height:70%; background:#fff; border:1px solid #ccc; z-index:9999;">
    <button id="cerrarIframe" style="position:absolute; top:5px; right:10px;">Cerrar X</button>
    <iframe id="iframeActivos" src="" style="width:100%; height:100%; border:none;"></iframe>
</div>

<!-- Modal -->
<!-- Modal -->
<!-- Modal Visualizar Activo -->
<!-- Modal Visualizar Activo -->
<!-- Modal Visualizar Activo -->
<div class="modal fade" id="modalVisualizar" tabindex="-1" aria-labelledby="modalVisualizarLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalVisualizarLabel">Detalle Completo del Activo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Contenido cargado por AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalEditarLabel">Detalle del Activo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Contenido cargado por AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="guardarCambiosActivo">Guardar cambios</button>
                <button type="button" class="btn btn-secondary" id="restablecerActivo">Restablecer</button>
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
            </div>
        </div>
    </div>
</div>







</div>








<script>
    $(document).ready(function() {
        // $('#formFiltrosActivos submit').trigger('click')









        const urlGuardar = $('#form_activo').attr('action'); // misma ruta del form

        // Click del botón
        $('#btnImportarExcel').click(() => $('#inputExcel').click());

        // Cuando selecciona el archivo
        $('#inputExcel').on('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {
                    type: 'array'
                });
                const sheet = workbook.Sheets[workbook.SheetNames[0]];
                const filas = XLSX.utils.sheet_to_json(sheet, {
                    defval: ''
                });

                if (!filas.length) {
                    mensaje2('El archivo está vacío o mal formateado.', 'error');
                    return;
                }

                importarActivos(filas);
            };
            reader.readAsArrayBuffer(file);
        });

        // function excelDateToJSDate(serial) {
        //     // Convierte número de Excel a formato YYYY-MM-DD
        //     if (typeof serial === 'number') {
        //         const utc_days = Math.floor(serial - 25569);
        //         const date_info = new Date(utc_days * 86400 * 1000);
        //         const year = date_info.getUTCFullYear();
        //         const month = String(date_info.getUTCMonth() + 1).padStart(2, '0');
        //         const day = String(date_info.getUTCDate()).padStart(2, '0');
        //         return `${year}-${month}-${day}`;
        //     }
        //     return serial; // Si ya es texto tipo "2025-01-15"
        // }
        function excelDateToJSDate(serial) {
    if (typeof serial === 'number') {
        // Caso: número serial de Excel
        const utc_days = Math.floor(serial - 25569);
        const date_info = new Date(utc_days * 86400 * 1000);
        const year = date_info.getUTCFullYear();
        const month = String(date_info.getUTCMonth() + 1).padStart(2, '0');
        const day = String(date_info.getUTCDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    if (typeof serial === 'string' && serial.includes('/')) {
        // Caso: texto con formato dd/mm/yyyy o d/m/yyyy
        const [d, m, y] = serial.split('/');
        if (d && m && y) {
            const day = String(d).padStart(2, '0');
            const month = String(m).padStart(2, '0');
            return `${y}-${month}-${day}`;
        }
    }

    return serial; // Devolver como está si no se reconoce el formato
}


        function importarActivos(filas) {
            let procesados = 0;
            let errores = 0;

            filas.forEach((fila, index) => {
                const formData = {
                    _token: $('meta[name="csrf-token"]').attr('content'), // ✅ CSRF
                    codigo: fila.codigo,
                    nombre: fila.nombre,
                    detalle: fila.detalle,
                    id_categoria: fila.id_categoria,
                    id_unidad: fila.id_unidad,
                    id_estado: fila.id_estado,
                    estado_situacional: fila.estado_situacional || 'activo',
                    fecha: excelDateToJSDate(fila.fecha),
                    comentarios: fila.comentarios || '',
                    tipo_adquisicion: fila.tipo_adquisicion,
                    id_proveedor: fila.id_proveedor || '',
                    precio_compra: fila.precio_compra || '',
                    id_donante: fila.id_donante || '',
                    motivo: fila.motivo || '',
                    precio_donacion: fila.precio_donacion || '',
                    sin_datos: fila.sin_datos || 0,
                };

                $.ajax({
                    url: urlGuardar,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        procesados++;
                        if (response.success) {
                            const a = response.activo;
                            const badges = {
                                activo: '<span class="badge bg-danger">En uso</span>',
                                inactivo: '<span class="badge bg-success">Libre</span>',
                                baja: '<span class="badge bg-dark">Baja</span>',
                            };
                            const badgeSituacion = badges[a.situacion] ||
                                `<span class="badge bg-secondary">${a.situacion}</span>`;

                            const filaHTML = `
            <tr data-id="${a.id}">
              <td>${a.codigo}</td>
              <td>${a.nombre}</td>
              <td>${a.detalle}</td>
              <td>${a.categoria}</td>
              <td>${a.unidad}</td>
              <td>${a.estado_fisico}</td>
              <td>${badgeSituacion}</td>
              <td>${a.fecha}</td>
              <td class="text-center">
                <button class="btn btn-sm btn-outline-primary editar-btn" data-id="${a.id}" title="Editar">
                  <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-dark visualizar-btn" data-id="${a.id}" title="Visualizar">
                  <i class="bi bi-eye"></i>
                </button>
              </td>
            </tr>
          `;
                            $('table tbody').prepend(filaHTML);
                        } else {
                            errores++;
                            console.warn(`Error en fila ${index + 1}:`, response);
                        }

                        if (procesados === filas.length) {
                            const tipoMsg = errores ? 'error' : 'success';
                            mensaje2(`Importación completada: ${procesados - errores} exitosas, ${errores} con error.`,
                                tipoMsg);
                        }
                    },
                    error: function(xhr) {
                        errores++;
                        console.error(`Error al importar fila ${index + 1}`, xhr
                            .responseText);
                        if (procesados + errores === filas.length) {
                            mensaje2(`Importación finalizada con ${errores} errores.`,
                                'error');
                        }
                    }
                });
            });
        }

        function mensaje2(texto, tipo) {
            Swal.fire({
                text: texto,
                icon: tipo,
                confirmButtonText: 'OK'
            });
        }































        // Botón de restablecer
        $('#restablecerActivo').on('click', function() {
            var form = $('#formEditarActivo')[0]; // Obtener el DOM puro del formulario
            form.reset(); // Resetea todos los campos al estado cargado en el modal

            // Disparar el cambio en el select tipo de adquisición para ajustar los campos dependientes
            $('#tipoAdquisicion').trigger('change');
        });

        // $('#restablecerActivo').on('click', function() {
        // //     var form = $('#modalEditar').find('form#formEditarActivo')[0];
        // //     $('#tipoAdquisicion').change();
        // // $('#tipoAdquisicion').triggerHandler('change');
        // // $('#modalEditar').on('shown.bs.modal', function () {
        // //     $('#tipoAdquisicion').change(); // dispara el cambio y ajusta los campos visibles
        // // });

        //     // Tomamos el elemento DOM
        //     form.reset(); // Restablece todos los campos a los valores cargados originalmente
        // });

        // Cuando se hace click en "Guardar cambios"
        $('#guardarCambiosActivo').on('click', function() {
            if (!confirm('¿Está seguro que desea guardar los cambios en este activo?')) return;

            var form = $('#modalEditar').find('form#formEditarActivo');
            var idActivo = form.find('input[name="id_activo"]').val();
            var url = baseUrl + '/activo/' + idActivo + '/update';

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function() {
                    form.find('.is-invalid').removeClass('is-invalid');
                    form.find('.invalid-feedback').remove();
                },
                success: function(response) {
                    if (response.success) {
                        mensaje2(response.message, 'success');

                        // ===== OCULTAR MODAL =====
                        bootstrap.Modal.getInstance(document.getElementById('modalEditar'))
                            .hide();

                        // ===== BUSCAR FILA EXISTENTE =====
                        var fila = $('tbody tr[data-id="' + response.data.id_activo + '"]');

                        // ===== GENERAR BADGE SEGÚN ESTADO =====
                        const situacion = response.data.situacion;
                        let badgeSituacion = '';

                        switch (situacion) {
                            case 'activo':
                                badgeSituacion =
                                    '<span class="badge bg-danger">En uso</span>';
                                break;
                            case 'inactivo':
                                badgeSituacion =
                                    '<span class="badge bg-success">Libre</span>';
                                break;
                            case 'baja':
                                badgeSituacion = '<span class="badge bg-dark">Baja</span>';
                                break;
                            default:
                                badgeSituacion =
                                    `<span class="badge bg-secondary">${situacion || 'N/A'}</span>`;
                                break;
                        }

                        // ===== SI LA FILA EXISTE, ACTUALIZARLA =====
                        if (fila.length) {
                            fila.find('td:eq(0)').text(response.data.codigo);
                            fila.find('td:eq(1)').text(response.data.nombre);
                            fila.find('td:eq(2)').text(response.data.detalle);
                            fila.find('td:eq(3)').text(response.data.categoria);
                            fila.find('td:eq(4)').text(response.data.unidad);
                            fila.find('td:eq(5)').text(response.data.estado);
                            fila.find('td:eq(6)').html(
                                badgeSituacion
                                ); // <---- 🔹 usar .html() para insertar el badge
                            fila.find('td:eq(7)').text(response.data.fecha);

                            // Efecto visual de actualización
                            fila.addClass('table-primary bg-opacity-10');
                            setTimeout(() => {
                                fila.removeClass('table-primary bg-opacity-10');
                            }, 2000);
                        }
                    } else {
                        mensaje2(response.message, 'danger');
                    }
                },

                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, msgs) {
                            var input = form.find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            if (input.next('.invalid-feedback').length === 0) {
                                input.after('<div class="invalid-feedback">' + msgs[
                                    0] + '</div>');
                            }
                        });
                        mensaje2('Existen errores en el formulario.', 'danger');
                    } else {
                        mensaje2('Ocurrió un error inesperado al actualizar.', 'danger');
                    }
                }
            });
        });













        $(function() {
            $('#formFiltrosActivos').triggerHandler('submit');
        });





















        $(document).on('click', '.editar-btn', function() {
            var idActivo = $(this).data('id');
            var url = baseUrl + '/activo/' + idActivo +
                '/editar'; // Ruta Laravel que devuelve la vista parcial

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    // Insertar la vista parcial en el modal
                    $('#modalEditar .modal-body').html(data);

                    // Mostrar modal
                    const modal = new bootstrap.Modal(document.getElementById(
                        'modalEditar'));
                    modal.show();
                },
                error: function() {
                    alert('No se pudo cargar el detalle del activo.');
                }
            });
        });














        $(document).on('click', '.visualizar-btn', function() {
            var idActivo = $(this).data('id');
            var url = baseUrl + '/activo/' + idActivo + '/detalle';

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#modalVisualizar .modal-body').html(data);
                    // $('#modalVisualizar').modal('show');
                    const modal = new bootstrap.Modal(document.getElementById(
                        'modalVisualizar'));
                    modal.show();


                },
                error: function() {
                    alert('No se pudo cargar el detalle del activo.');
                }
            });
        });


















        let usandoFechas = false;

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


        $('#btnLimpiar').on('click', function() {
            // if (!$('#rangoFechas').hasClass('d-none')) {
            //     $('#rangoFechas').addClass('d-none');
            //     $('#toggleFechas i').removeClass('bi-calendar-event-fill').addClass('bi-calendar-event');
            //     $('#toggleFechas').attr('title', 'Activar filtro por fechas');
            // }
        });

        $('#formFiltrosActivos').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'GET',
                data: $(this).serialize(),
                success: function(data) {
                    // Actualizar contenedor de resultados
                    $('#contenedorResultados').html(data);

                    // Opcional: actualizar URL sin recargar
                    // const newUrl = window.location.pathname + '?' + $('#formFiltrosActivos').serialize();
                    // window.history.pushState(null, '', newUrl);
                },
                error: function(xhr) {
                    let mensaje2 = 'Error al cargar activos.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje2 = xhr.responseJSON.message;
                    }
                    alert(mensaje2);
                }
            });
        });

    });

    // Paginación por AJAX
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            data: $('#filtro-form').serialize(), // ENVÍO LOS FILTROS AL AJAX
            success: function(data) {
                $('#contenedorResultados').html(data);
                // window.history.pushState(null, '', url); // opcional
            },
            error: function() {
                alert('Error al cargar página.');
            }
        });
    });










    $(function() {
        // Fecha mínima fija
        const fechaMin = new Date('2017-01-01');

        // Fecha máxima = hoy del sistema
        const fechaMax = new Date();
        const fechaMaxISO = fechaMax.toISOString().slice(0, 10);

        // Ajustamos los atributos min/max en los inputs date
        $('#fecha_inicio, #fecha_fin').attr('min', '2017-01-01').attr('max', fechaMaxISO);

        // Función que convierte un valor slider (0-100) a fecha ISO
        function sliderToDate(val) {
            const diff = fechaMax.getTime() - fechaMin.getTime();
            const date = new Date(fechaMin.getTime() + (val / 100) * diff);
            return date.toISOString().slice(0, 10);
        }

        // Función que convierte una fecha ISO a valor slider (0-100)
        function dateToSlider(fechaStr) {
            const date = new Date(fechaStr);
            if (isNaN(date)) return 0;
            const diff = fechaMax.getTime() - fechaMin.getTime();
            let val = ((date.getTime() - fechaMin.getTime()) / diff) * 100;
            return Math.min(100, Math.max(0, val));
        }

        // Al cargar, sincronizamos sliders con los inputs de fecha (ambos hoy)
        $('#slider_start').val(dateToSlider($('#fecha_inicio').val()));
        $('#slider_end').val(dateToSlider($('#fecha_fin').val()));

        // Slider inicio controla fecha_inicio
        $('#slider_start').on('input change', function() {
            let val = +$(this).val();
            let finVal = +$('#slider_end').val();

            if (val > finVal) {
                val = finVal; // no permitir pasar el slider fin
                $(this).val(val);
            }

            $('#fecha_inicio').val(sliderToDate(val));
        });

        // Slider fin controla fecha_fin
        $('#slider_end').on('input change', function() {
            let val = +$(this).val();
            let inicioVal = +$('#slider_start').val();

            if (val < inicioVal) {
                val = inicioVal; // no permitir bajar del slider inicio
                $(this).val(val);
            }

            $('#fecha_fin').val(sliderToDate(val));
        });

        // Cambios manuales en fecha_inicio actualizan slider inicio
        $('#fecha_inicio').on('change', function() {
            let val = dateToSlider($(this).val());
            let finVal = +$('#slider_end').val();

            if (val > finVal) {
                val = finVal; // evitar cruzar
                $(this).val(sliderToDate(val));
            }

            $('#slider_start').val(val);
        });

        // Cambios manuales en fecha_fin actualizan slider fin
        $('#fecha_fin').on('change', function() {
            let val = dateToSlider($(this).val());
            let inicioVal = +$('#slider_start').val();

            if (val < inicioVal) {
                val = inicioVal; // evitar cruzar
                $(this).val(sliderToDate(val));
            }

            $('#slider_end').val(val);
        });
    });
</script>
