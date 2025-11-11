<!-- 🧑‍💼 Botón para abrir modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoResponsable">
    <i class="bi bi-person-plus me-1"></i> Nuevo Responsable
</button>

<!-- Modal -->
<div class="modal fade" id="modalNuevoResponsable" tabindex="-1" aria-labelledby="modalNuevoResponsableLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #fdfdfd; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-primary bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalNuevoResponsableLabel">
                    <i class="bi bi-person-plus-fill me-2"></i> Registrar nuevo responsable
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">
                @include('admin.responsables.nuevo', [
                    'tabla' => 'contenedorTablaResponsables',
                    'datos' => [
        'ci',
        'nombre'
    ]
                ])

            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="button" id="btnLimpiarResponsable" class="btn btn-secondary">
                    <i class="bi bi-eraser-fill"></i> Limpiar
                </button>
                <button type="submit" id="btnGuardarResponsable" class="btn btn-primary" form="formNuevoResponsable">
                    <i class="bi bi-check2-circle"></i> Guardar
                </button>
            </div>

        </div>
    </div>
</div>













<div class="row bg-info0 pb-4 justify-content-center" style="height: 90vh; min-height: 30vh; max-height: 94vh;">

    <div class="main-col col-md-12 col-lg-11 order-lg-1 order-1 mb-4 p-1 transition"
        style="position: relative; height: 80vh; display: flex; flex-direction: column; overflow: visible;">

        <!-- CARD PRINCIPAL -->
        <div class="card p-4 rounded shadow"
            style="background-color: var(--color-fondo); display: flex; flex-direction: column; flex: 1 1 auto;">

            <!-- 🔹 Título -->
            <h2 class="mb-4 text-center text-primary">
                <i class="bi bi-people-fill me-2"></i>Listado del Personal / Responsables
            </h2>

            <!-- 🔹 Botones principales -->
            <div class="d-flex justify-content-end mb-3 gap-2">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoResponsable">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Responsable
                </button>
                <button class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                    <i class="bi bi-funnel-fill me-1"></i> Filtrar
                </button>
                <button class="btn btn-secondary btn-sm">
                    <i class="bi bi-printer-fill me-1"></i> Imprimir
                </button>
            </div>

            <div class="card mb-4 shadow-sm"
                style="background-color: #f8f9fa; border-left: 5px solid #0d6efd; padding: 1.5rem;">
                <div class="row g-3 p-3 align-items-end">

                    <!-- 🔍 Buscar (frontend) -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-search me-1"></i>Buscar activo
                        </label>
                        <input type="text" id="buscarResponsable"
                        class="form-control form-control-sm rounded-pill shadow-sm px-3"
                        placeholder="Nombre, C.I. o telefono">
                    </div>

                    <div class="col-md-2"> </div>
                    <!-- 🧩 Filtro: Cargo -->
                    <div class="col-md-2  align-items-end">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-briefcase me-1"></i>Cargo
                        </label>
                        <select id="filtroCargo" class="form-select form-select-sm rounded-pill shadow-sm">
                            <option value="">Todos</option>
                            @foreach ($cargos as $cargo)
                                <option value="{{ $cargo->id_cargo }}">{{ $cargo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 👤 Filtro: Rol -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person-badge me-1"></i>Rol
                        </label>
                        <select id="filtroRol" class="form-select form-select-sm rounded-pill shadow-sm">
                            <option value="">Todos</option>
                            <option value="admin">Administrador</option>
                            <option value="user">Usuario</option>
                            <option value="tecnico">Técnico</option>
                        </select>
                    </div>

                    <!-- ⚙️ Filtro: Estado -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-toggle-on me-1"></i>Estado
                        </label>
                        <select id="filtroEstado" class="form-select form-select-sm rounded-pill shadow-sm">
                            <option value="">Todos</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>

                    <!-- 🔎 Botón Filtrar -->
                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-outline-primary btn-sm w-100" id="btnFiltrarActivos">
                            <i class="bi bi-funnel me-1"></i>Filtrar
                        </button>
                    </div>
                </div>
            </div>


            <!-- 🔹 Contenedor donde cargará la tabla -->
            {{-- <div id="contenedorResultados">
            <!-- Aquí van los resultados -->
        </div> --}}

            <div id="contenedorTablaResponsables" class="d-flex flex-column bg- rounded shadow p-3 bg-info0 p-3"
                style="height: 60vh; max-height: 80vh; ">
                <!-- Aquí se cargará la tabla de responsables -->
                <div class="text-center text-muted mt-4">
                    {{-- <i class="bi bi-hourglass-split me-2"></i> Cargando listado de personal... --}}
                    @include('admin.responsables.parcial')
                </div>
            </div>

        </div>
    </div>
</div>
<script>


    $(document).ready(function() {





        function cargarDatos(tablaId, datos) {
    const contenedor = document.getElementById(tablaId);
    if (!contenedor) {
        console.error(`❌ No se encontró el contenedor con ID: ${tablaId}`);
        return;
    }

    const tabla = contenedor.querySelector('table');
    if (!tabla) {
        console.error(`❌ No se encontró una tabla dentro de #${tablaId}`);
        return;
    }

    const tbody = tabla.querySelector('tbody') || tabla.appendChild(document.createElement('tbody'));

    // Limpia el contenido actual (opcional)
    // tbody.innerHTML = '';

    // Recorre cada objeto del array de datos
    datos.forEach(item => {
        const fila = document.createElement('tr');

        // Recorremos las claves del objeto (por ejemplo: ci, nombre)
        Object.values(item).forEach(valor => {
            const celda = document.createElement('td');
            celda.textContent = valor ?? '-';
            fila.appendChild(celda);
        });

        // Insertamos al inicio del tbody
        tbody.prepend(fila);
    });

    alert(`✅ ${datos.length} fila(s) agregadas a la tabla ${tablaId}`);
}















        $('#buscarResponsable').on('keyup', function() {
            let valor = $(this).val().toLowerCase();

            $('#contenedorTablaResponsables table tbody tr').filter(function() {
                // Buscamos en Código, Nombre y Detalle
                $(this).toggle(
                    $(this).find('td:eq(0)').text().toLowerCase().indexOf(valor) > -1 ||
                    $(this).find('td:eq(1)').text().toLowerCase().indexOf(valor) > -1 ||
                    $(this).find('td:eq(2)').text().toLowerCase().indexOf(valor) > -1
                );
            });
        });










     // 🔎 Ejecutar filtrado al hacer clic en el botón
$('#btnFiltrarActivos').on('click', function() {
    filtrarResponsables();
});

// 🧩 Función principal del filtrado
function filtrarResponsables(page = 1) {
    let id_cargo = $('#filtroCargo').val();
    let rol = $('#filtroRol').val();
    let estado = $('#filtroEstado').val();

    $.ajax({
        url: "{{ route('responsables.filtrar') }}", // Ajusta esta ruta si usas otro nombre
        method: 'GET',
        data: {
            id_cargo: id_cargo,
            rol: rol,
            estado: estado,
            page: page
        },
        beforeSend: function() {
            $('#contenedorTablaResponsables').html(`
                <div class="text-center text-muted mt-4">
                    <i class="bi bi-hourglass-split me-2"></i> Cargando listado de personal...
                </div>
            `);
        },
        success: function(data) {
            $('#contenedorTablaResponsables').html(data);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            $('#contenedorTablaResponsables').html(`
                <div class="alert alert-danger text-center">
                    <i class="bi bi-exclamation-triangle me-2"></i> Error al cargar los datos.
                </div>
            `);
        }
    });
}

// 📄 Delegar paginación para mantener AJAX al cambiar de página
$(document).on('click', '#contenedorTablaResponsables .pagination a', function(e) {
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    filtrarResponsables(page);
});

    });
</script>
