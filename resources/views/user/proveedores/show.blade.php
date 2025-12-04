
<div class="modal fade" id="modalEditarProveedor" tabindex="-1" aria-labelledby="modalEditarProveedorLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #ffffff; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalEditarProveedorLabel">
                    <i class="bi bi-pencil-square me-2"></i> Editar Proveedor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">
                <form id="formEditarProveedor" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_proveedor" id="idProveedorEditar">

                    <div class="mb-4 p-3 rounded" style="background-color: #b8cce92f;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-building me-1"></i> Información del Proveedor
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombreProveedorEditar" class="form-label">Nombre</label>
                                <input type="text" id="nombreProveedorEditar" name="nombre" class="form-control"
                                    placeholder="Nombre del proveedor" required>
                            </div>
                            <div class="col-md-3">
                                <label for="lugarProveedorEditar" class="form-label">Lugar</label>
                                <input type="text" id="lugarProveedorEditar" name="lugar" class="form-control"
                                    placeholder="Ciudad / País">
                            </div>
                            <div class="col-md-3">
                                <label for="contactoProveedorEditar" class="form-label">Contacto</label>
                                <input type="text" id="contactoProveedorEditar" name="contacto" class="form-control"
                                    placeholder="Teléfono o correo">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="reset" form="formEditarProveedor" class="btn btn-secondary">
                    <i class="bi bi-eraser-fill"></i> Limpiar
                </button>
                <button type="submit" id="btnActualizarProveedor" class="btn btn-success" form="formEditarProveedor">
                    <i class="bi bi-check2-circle"></i> Guardar cambios
                </button>
            </div>

        </div>
    </div>
</div>









<div class="modal fade" id="modalNuevoProveedor" tabindex="-1" aria-labelledby="modalNuevoProveedorLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #ffffff; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalNuevoProveedorLabel">
                    <i class="bi bi-plus-square me-2"></i> Nuevo Proveedor
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">
                <form id="formNuevoProveedor" method="POST">
                    @csrf

                    <div class="mb-4 p-3 rounded" style="background-color: #b8cce92f;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-building me-1"></i> Información del Proveedor
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombreProveedorNuevo" class="form-label">Nombre</label>
                                <input type="text" id="nombreProveedorNuevo" name="nombre" class="form-control"
                                    placeholder="Nombre del proveedor" required>
                            </div>
                            <div class="col-md-3">
                                <label for="lugarProveedorNuevo" class="form-label">Lugar</label>
                                <input type="text" id="lugarProveedorNuevo" name="lugar" class="form-control"
       placeholder="Ciudad / País" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ /]+" 
       title="No se permiten números">

                            </div>
                            <div class="col-md-3">
                                <label for="contactoProveedorNuevo" class="form-label">Contacto</label>
                               <input type="text" id="contactoProveedorNuevo" name="contacto" class="form-control"
       placeholder="Teléfono (6-8 dígitos) o correo"
       pattern="(^\d{6,8}$)|(^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$)"
       title="Ingrese un correo válido o un número de 6 a 8 dígitos">

                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="reset" form="formNuevoProveedor" class="btn btn-secondary">
                    <i class="bi bi-eraser-fill"></i> Limpiar
                </button>
                <button type="submit" id="btnGuardarProveedor" class="btn btn-success" form="formNuevoProveedor">
                    <i class="bi bi-check2-circle"></i> Guardar proveedor
                </button>
            </div>

        </div>
    </div>
</div>















<div class="row bg-info4 p-4 justify-content-center" style="height: 130vh; min-height: 130vh; max-height: 130vh;">

    <div class="main-col col-md-12 col-lg-11 order-lg-1 bg-dan2ger order-1 mb-1 p-1 transition"
        style="position: relative; height: 130vh;max-height: 130vh; display: flex; flex-direction: column; overflow: visible;">
        <div class="card p-4 rounded shadow  "
            style="background-color: var(--color-fondo); display: flex; flex-direction: column; flex: 1 1 auto;" >


            <!-- Título -->
            <h2 class="mb-4 text-center text-primary">
                <i class="bi bi-box-seam me-2"></i>Gestionar Proveedores
            </h2>

            <!-- Botones principales -->
            <div class="d-flex justify-content-end mb-3 gap-2">

            </div>
            <!-- Card de acciones (buscar, importar, exportar, bajas) -->
            <div class="card shadow-sm position-relative p-3 d-flex justify-content-center align-items-center mb-4 panel-external"
                id="cardProveedores" data-panel="proveedores"
                style="
        background-color: #e9f2ff7e;
        border-left: 5px solid #0d6efd;
        box-sizing: border-box;
        min-height: 140px;
        max-height: none;
        overflow: visible;">

                <!-- Contenedor interno centrado -->
                <div class="d-flex flex-column justify-content-center  p-4 rounded "
                    style="background-color:#e9f2ff; width: 100%; box-sizing: border-box;">



                    <div class="row g-2 align-items-end">

                        <!-- Nombre del proveedor -->
                        <div class="col-md-4 ">
                            <label class="form-label fw-semibold">Nombre del proveedor</label>
                            <input type="text" id="buscarNombreProveedor"
                                class="form-control form-control-sm rounded-pill" placeholder="Nombre del proveedor">
                        </div>

                        <!-- Lugar -->
                        <div class="col-md-3 ">
                            {{-- <div class="me-2"> --}}
                            <label class="form-label fw-semibold">Lugar</label>
                            <input type="text" id="buscarLugar" class="form-control form-control-sm rounded-pill"
                                placeholder="Lugar">
                        </div>


                        <div class="col-md-2 ">
                            <button class="btn btn-primary btn-sm rounded-pill" id="btnBuscarProveedor">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        {{-- <div class="col-md-1"></div> --}}


                        <!-- Botón Generar PDF al extremo derecho -->
                        <div class="col-md-3 gap-3 d-flex justify-content-end">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoProveedor">
                                <i class="bi bi-plus-circle me-1"></i> Nuevo
                            </button>
                            <a href="{{ route('proveedores.imprimir') }}" target="_blank" class="btn btn-danger btn-sm " id="btnGenerarPDF">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Generar PDF
                            </a>

                        </div>
                    </div>
                </div>
            </div>





                <div class="card shadow-sm position-relative p-3 d-none d-flex justify-content-center align-items-center mb-4 panel-external"
                    id="cardCompras" data-panel="compras"
                    style="
            background-color: #e9f2ff7e;
            border-left: 5px solid #0d6efd;
            box-sizing: border-box;
            min-height: 140px;
            max-height: none;
            overflow: visible;">

                    <!-- Contenedor interno centrado -->
                    <div class="d-flex flex-column justify-content-center  p-4 rounded "
                        style="background-color:#e9f2ff; width: 100%; box-sizing: border-box;">

                    <div class="row g-2 align-items-end">

                        <!-- Código del activo -->
                        <div class="col-md-3 ">
                            <label class="form-label fw-semibold">Código del activo</label>
                            <input type="text" id="buscarCodigoActivo" class="form-control form-control-sm rounded-pill" placeholder="Código del activo">
                        </div>

                        <!-- Nombre del activo -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Nombre del activo</label>
                            <input type="text" id="buscarNombreActivo" class="form-control form-control-sm rounded-pill" placeholder="Nombre del activo">
                        </div>

                        <!-- Fecha de adquisición -->
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Fecha de adquisición</label>
                            <input type="date" id="buscarFechaAdquisicion" class="form-control form-control-sm rounded-pill">
                        </div>

                        <!-- Botón de búsqueda -->
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-primary btn-sm rounded-pill" id="btnBuscarActivo">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        {{-- <div class="col-md-1"></div> --}}
                        <div class="col-md-2 justify-content-end">
                            <button class="btn btn-danger btn-sm" id="btnGenerarPDF">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Generar PDF
                            </button>
                        </div>

                    </div>
                </div>
            </div>


















           <!-- Tabs -->
<ul class="nav nav-pills mb-3 bg-light rounded p-1" id="tabsProveedores" role="tablist">
    <li class="nav-item me-2" role="presentation">
        <button class="nav-link active text-dark fw-semibold" id="tab-proveedores" data-bs-toggle="tab"
                data-bs-target="#contenedorProveedores" type="button" role="tab" data-panels="proveedores">
            <i class="bi bi-people-fill me-1"></i> Proveedores
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-dark fw-semibold" id="tab-compras"
                data-bs-toggle="tab" data-bs-target="#contenedorCompras" type="button" role="tab" data-panels="compras"
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
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Detalle</th>
                            <th>Fecha Adquisición</th>
                            <th>Proveedor</th>
                            <th>Estado</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaCompras" >
                        <tr>
                            <td colspan="8" class="text-center text-muted"> selecione a un  preveedor</td>
                        </tr>
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

filtrarProveedores()


 $(document).on('click', '#contenedorCompras .pagination a', function(e) {
    e.preventDefault();

    let url = $(this).attr('href');

    // Extraer page=n de la URL
    let page = url.split('page=')[1];

    let idProveedor = $('#contenedorCompras table').data('id-proveedor');

    filtrarCompras(idProveedor, page);
});



$(document).off('click', '.ver-activo-btn').on('click', '.ver-activo-btn', function() {
    var idActivo = $(this).data('id');
    var url = baseUrl + '/activo/' + idActivo + '/detalle';

    $.ajax({
        url: url,
        type: 'GET',
        success: function(data) {
            $('#modalVisualizar2 .modal-body').html(data);
            // const modal = new bootstrap.Modal(document.getElementById('modalVisualizar2'));
            // modal.show();
        },
        error: function() {
            $('#modalVisualizar2 .modal-body').html('<div class="alert alert-danger text-center">No se pudo cargar el detalle del activo.</div>');
            // const modal = new bootstrap.Modal(document.getElementById('modalVisualizar2'));
            // modal.show();
        }
    });
});






let procesando = false;
$('#formNuevoProveedor').on('submit', function(e) {
    e.preventDefault();

    if (procesando) return;
    procesando = true;

    // Limpiar errores anteriores
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    $.ajax({
        url: baseUrl + '/proveedores',
        method: 'POST',
        data: $(this).serialize(),

        success: function(res) {
            $('#modalNuevoProveedor').modal('hide');
            filtrarProveedores();

            Swal.fire({
                icon: 'success',
                title: 'Proveedor registrado',
                text: 'El proveedor se ha creado correctamente'
            });

            $('#formNuevoProveedor')[0].reset();
        },

        error: function(xhr) {
            // Si son errores de validación 422 (Laravel)
            if (xhr.status === 422) {
                let errores = xhr.responseJSON.errors;

                // Recorrer los errores y mostrarlos bajo cada input
                Object.keys(errores).forEach(function(campo) {
                    let input = $('[name="' + campo + '"]');
                    input.addClass('is-invalid');

                    let mensaje = errores[campo][0];

                    input.after('<div class="invalid-feedback">' + mensaje + '</div>');
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Errores en el formulario',
                    text: 'Revisa los campos marcados en rojo.'
                });

            } else {
                // Error general del servidor
                Swal.fire({
                    icon: 'error',
                    title: 'Error inesperado',
                    text: xhr.responseJSON?.message || 'No se pudo registrar el proveedor'
                });
            }

            console.error(xhr.responseText);
        },

        complete: function() {
            procesando = false;
        }
    });
});


$('#formEditarProveedor').on('submit', function(e) {
    e.preventDefault(); // evitar que se recargue la página

    let idProveedor = $('#idProveedorEditar').val();

    $.ajax({
        url: baseUrl + '/proveedores/' + idProveedor, // Ruta tipo REST
        method: 'PUT',
        data: $(this).serialize(),
        success: function(res) {
            $('#modalEditarProveedor').modal('hide'); // cerrar modal
            filtrarProveedores(); // recargar tabla
            Swal.fire({
                icon: 'success',
                title: 'Actualizado',
                text: 'Proveedor actualizado correctamente'
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo actualizar el proveedor'
            });
            console.error(xhr.responseText);
        }
    });
});

$(document).on('click', '.btnEditarProveedor', function() {
    let fila = $(this).closest('tr'); // fila del botón
    let idProveedor = $(this).data('id');

    // Leer valores de las celdas de la misma fila
    let nombre = fila.find('.nombre').text().trim();
    let lugar = fila.find('.lugar').text().trim();
    let contacto = fila.find('.contacto').text().trim();
// alert(nombre)
    // Asignar valores al modal
    let modal = $('#modalEditarProveedor');
    modal.find('#idProveedorEditar').val(idProveedor);
    modal.find('#nombreProveedorEditar').val(nombre);
    modal.find('#lugarProveedorEditar').val(lugar);
    modal.find('#contactoProveedorEditar').val(contacto);
});








function resetCompras() {
    // Seleccionamos el tbody de la tabla de compras
    let $tbody = $('#contenedorCompras table tbody');

    if ($tbody.length === 0) {
        // Si no hay tbody, crearlo
        $tbody = $('<tbody></tbody>').appendTo('#tablaCompras');
    }

    // Limpiar todas las filas
    $tbody.empty();

    // Insertar fila por defecto
    $tbody.append(`
        <tr>
            <td colspan="8" class="text-center text-muted">
                Seleccione un proveedor
            </td>
        </tr>
    `);

    // Limpiar filtros asociados
    $('#buscarCodigoActivo').val('');
    $('#buscarNombreActivo').val('');
    $('#buscarFechaAdquisicion').val('');
    $('#filtroProveedor').val('');
    $('#filtroEstadoCompra').val('');
}






$(document).off('click','.btnVerCompras').on('click','.btnVerCompras',function(){

    const detalleTab = new bootstrap.Tab(document.querySelector('#tab-compras'));
                detalleTab.show();
                if ($(this).hasClass('active')) {
                    return;
                }
                // Quitar clase active de otros botones
                $('.btnVerCompras').removeClass('active');
                $(this).addClass('active');
                filtrarCompras($(this).data('id'))
});

function filtrarCompras(idProveedor, page = 1) {

if (!idProveedor) {
return;
}
// Leer los valores de los inputs
let codigo   = $('#buscarCodigoActivo').val();
let nombre   = $('#buscarNombreActivo').val();
let fecha    = $('#buscarFechaAdquisicion').val();
$.ajax({
    url: baseUrl + "/compras/filtrar",  // tu ruta en el controlador de compras
    method: 'GET',
    data: {
        proveedor_id: idProveedor,
        codigo: codigo,
        nombre: nombre,
        fecha: fecha,
        page: page
    },
    beforeSend: function() {
        $('#contenedorCompras').html(`
            <div class="text-center text-muted mt-4">
                <i class="bi bi-hourglass-split me-2"></i> Cargando listado de compras...
            </div>
        `);
    },
    success: function(data) {
        $('#contenedorCompras').html(data);
    },
    error: function(xhr) {
        console.error(xhr.responseText);
        $('#contenedorCompras').html(`
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle me-2"></i> Error al cargar las compras.
            </div>
        `);
    }
});
}










        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {

// Ocultamos todos los paneles externos
$('.panel-external').addClass('d-none');

// Obtenemos los paneles declarados en la pestaña
let panels = $(e.target).data('panels');
if (!panels) return;

panels.split(',').forEach(function(panel){
    panel = panel.trim();
    if (panel.length > 0) {
        $('.panel-external[data-panel="'+panel+'"]').removeClass('d-none');
    }
});
});












// Cuando se activa la pestaña PROVEEDORES
$('#tab-proveedores').on('shown.bs.tab', function(e) {

// Mostrar filtros de proveedores y ocultar filtros de compras
// $('.filtroProveedores').removeClass('d-none');
// $('.filtroCompras').addClass('d-none');

// Si deseas cargar proveedores solo la primera vez
// if (!proveedoresCargados) {
//     $.get(baseUrl + "/proveedores/lista", function(data) {
//         $('#contenedorProveedores').html(data);
//         proveedoresCargados = true;
//     });
// }

});

// Cuando se activa la pestaña COMPRAS
$('#tab-compras').on('shown.bs.tab', function(e) {

// Mostrar filtros de compras y ocultar filtros de proveedores
// $('.filtroCompras').removeClass('d-none');
// $('.filtroProveedores').addClass('d-none');

// // Si deseas cargar compras solo la primera vez
// if (!comprasCargadas) {
//     $.get(baseUrl + "/compras/lista", function(data) {
//         $('#contenedorCompras').html(data);
//         comprasCargadas = true;
//     });
// }
});













        $("#btnBuscarProveedor").click(function() {
    filtrarProveedores()
});
        $("#btnBuscarActivo").click(function() {
            let idPrimerProveedor = $('#contenedorListaProveedores table .btnVerCompras').first().data('id');// Buscar el botón activo dentro del contenedor
let idProveedorActivo = $('#contenedorListaProveedores .btnVerCompras.active').data('id');

// Llamar a la función con ese ID
filtrarCompras(idProveedorActivo);

});



function filtrarProveedores(page = 1) {
    resetCompras();
    let nombre = $('#buscarNombreProveedor').val();
let lugar  = $('#buscarLugar').val();
// let page   = page ?? null;   // si usas paginación

$.ajax({
    url: baseUrl + "/proveedores/filtrar",
    method: 'GET',
    data: {
        nombre: nombre,
        lugar: lugar,

    },
    beforeSend: function() {
        $('#contenedorListaProveedores').html(`
            <div class="text-center text-muted mt-4">
                <i class="bi bi-hourglass-split me-2"></i> Cargando listado de proveedores...
            </div>
        `);
    },
    success: function(data) {
        $('#contenedorListaProveedores').html(data);
    },
    error: function(xhr) {
        console.error(xhr.responseText);
        $('#contenedorListaProveedores').html(`
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle me-2"></i> Error al cargar los proveedores.
            </div>
        `);
    }
});

        }

$(document).on('click', '#contenedorListaProveedores .pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            filtrarProveedores(page);
        });
        $(document).on('click', '#contenedorTablaUsuarios .pagination a', function(e) {
            e.preventDefault(); // Evita recargar toda la página
            let page = $(this).attr('href').split('page=')[1]; // obtiene el número de página
            filtrarUsuarios(page); // tu función AJAX que recarga la tabla
        });




    });
    </script>
