<div class="row bg-info4 p-4 justify-content-center" style="height: 130vh; min-height: 130vh; max-height: 130vh;">

    <div class="main-col col-md-12 col-lg-11 order-lg-1 bg-dan2ger order-1 mb-1 p-1 transition"
        style="position: relative; height: 130vh;max-height: 130vh; display: flex; flex-direction: column; overflow: visible;">
        <div class="card p-4 rounded shadow "
            style="background-color: var(--color-fondo); display: flex; flex-direction: column; flex: 1 1 auto;">


            <!-- Título -->
            <h2 class="mb-4 text-center text-primary">
                <i class="bi bi-box-seam me-2"></i>Lista de Proveedores
            </h2>

            <!-- Botones principales -->
            <div class="d-flex justify-content-end mb-3 gap-2">

            </div>
            <!-- Card de acciones (buscar, importar, exportar, bajas) -->
            <div class="card shadow-sm position-relative p-3 d-flex justify-content-center align-items-center mb-4"
                id="cardProveedores"
                style="
        background-color: #e9f2ff7e;
        border-left: 5px solid #0d6efd;
        box-sizing: border-box;
        min-height: 140px;
        max-height: none;
        overflow: visible;">

                <!-- Contenedor interno centrado -->
                <div class="d-flex flex-column justify-content-center  p-4 rounded"
                    style="background-color:#e9f2ff; width: 100%; box-sizing: border-box;">



                    <div class="row g-2 align-items-end">

                        <!-- Nombre del proveedor -->
                        <div class="col-md-4 me-2">
                            <label class="form-label fw-semibold">Nombre del proveedor</label>
                            <input type="text" id="buscarNombreProveedor"
                                class="form-control form-control-sm rounded-pill" placeholder="Nombre del proveedor">
                        </div>

                        <!-- Lugar -->
                        <div class="col-md-3 me-2">
                            {{-- <div class="me-2"> --}}
                            <label class="form-label fw-semibold">Lugar</label>
                            <input type="text" id="buscarLugar" class="form-control form-control-sm rounded-pill"
                                placeholder="Lugar">
                        </div>


                        <div class="col-md-2 me-2">
                            <button class="btn btn-primary btn-sm rounded-pill" id="btnBuscarProveedor">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>


                        <!-- Botón Generar PDF al extremo derecho -->
                        <div class="col-md-2">
                            <button class="btn btn-danger btn-sm" id="btnGenerarPDF">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Generar PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>




            <div class="card shadow-sm position-relative p-3 mb-4" style="background-color: #e9f2ff7e; border-left: 5px solid #0d6efd;">
                <div class="card-body">
                    <div class="row g-2 align-items-end">

                        <!-- Código del activo -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Código del activo</label>
                            <input type="text" id="buscarCodigoActivo" class="form-control form-control-sm rounded-pill" placeholder="Código del activo">
                        </div>

                        <!-- Nombre del activo -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nombre del activo</label>
                            <input type="text" id="buscarNombreActivo" class="form-control form-control-sm rounded-pill" placeholder="Nombre del activo">
                        </div>

                        <!-- Fecha de adquisición -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Fecha de adquisición</label>
                            <input type="date" id="buscarFechaAdquisicion" class="form-control form-control-sm rounded-pill">
                        </div>

                        <!-- Botón de búsqueda -->
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-primary btn-sm w-100 rounded-pill" id="btnBuscarActivo">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>

                    </div>
                </div>
            </div>


















           <!-- Tabs -->
<ul class="nav nav-pills mb-3 bg-light rounded p-1" id="tabsProveedores" role="tablist">
    <li class="nav-item me-2" role="presentation">
        <button class="nav-link active text-dark fw-semibold" id="tab-proveedores" data-bs-toggle="tab"
                data-bs-target="#contenedorProveedores" type="button" role="tab">
            <i class="bi bi-people-fill me-1"></i> Proveedores
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-dark fw-semibold" id="tab-compras"
                data-bs-toggle="tab" data-bs-target="#contenedorCompras" type="button" role="tab"
                aria-disabled="true">
            <i class="bi bi-card-list me-1"></i> Compras
        </button>
    </li>
</ul>

<!-- Contenido de los tabs -->
<div class="tab-content d-flex flex-column bg-da53425nger position-relative overflow-auto p-3" style="height: 90vh; max-height: 80vh; min-height: 90vh;">

    <!-- Proveedores -->
    <div class="tab-pane fade show active flex-grow-1 position-relative" id="contenedorProveedores" role="tabpanel">
        <div id="contenedorListaProveedores" class="d-flex flex-column rounded p-2"
             style="height: 80vh; max-height: 80vh; overflow-y: auto;">
            <!-- Aquí se cargará la lista de proveedores dinámicamente -->
        </div>
    </div>

    <!-- Compras -->
    <div class="tab-pane fade position-relative " id="contenedorCompras" role="tabpanel">
        <div id="contenidoCompras" class="d-flex flex-column rounded p-2"
             style="height: 100%; max-height: 100%; overflow-y: auto;">
            <!-- Aquí se cargará la lista de compras dinámicamente -->
            <div style="height: 70vh; max-height: 70vh; overflow-y: auto; overflow-x: hidden; position: relative;">
                <table class="table table-striped mb-0 rounded">
                    <thead class="table-light">
                        <tr>
                            <th>Nº</th>
                            <th>Código</th>
                            <th>Proveedor</th>
                            <th>Detalle</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaCompras">
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
        $("#btnBuscarProveedor").click(function() {
    let nombre = $("#buscarNombreProveedor").val();
    let lugar  = $("#buscarLugar").val();

    $.ajax({
        url: baseUrl + "/proveedores/filtrar",   // tu ruta
        method: "GET",
        data: {
            nombre: nombre,
            lugar: lugar
        },
        success: function(res) {
            // Insertar la vista parcial devuelta en el contenedor
            $("#contenedorListaProveedores").html(res);
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo filtrar los proveedores. Intente nuevamente.',
            });
            console.error("Error al filtrar proveedores:", error);
        }
    });
});

    });
    </script>
