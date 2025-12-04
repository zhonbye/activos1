
<div class="modal fade" id="modalEditarDonante" tabindex="-1" aria-labelledby="modalEditarDonanteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #ffffff; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalEditarDonanteLabel">
                    <i class="bi bi-pencil-square me-2"></i> Editar Donacion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">
                <form id="formEditarDonante" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_donante" id="idDonanteEditar">

                    <div class="mb-4 p-3 rounded" style="background-color: #b8cce92f;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-building me-1"></i> Información del donante
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombreDonanteEditar" class="form-label">Nombre</label>
                                <input type="text" id="nombreDonanteEditar" name="nombre" class="form-control"
                                    placeholder="Nombre del donante" required>
                            </div>
                            <div class="col-md-3">
                                <label for="lugarDonanteEditar" class="form-label">Tipo</label>
                                <input type="text" id="lugarDonanteEditar" name="tipo" class="form-control"
                                    placeholder="Tipo">
                            </div>
                            <div class="col-md-3">
                                <label for="contactoDonanteEditar" class="form-label">Contacto</label>
                                <input type="text" id="contactoDonanteEditar" name="contacto" class="form-control"
                                    placeholder="Teléfono o correo">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="reset" form="formEditarDonante" class="btn btn-secondary">
                    <i class="bi bi-eraser-fill"></i> Limpiar
                </button>
                <button type="submit" id="btnActualizarDonante" class="btn btn-success" form="formEditarDonante">
                    <i class="bi bi-check2-circle"></i> Guardar cambios
                </button>
            </div>

        </div>
    </div>
</div>









<div class="modal fade" id="modalNuevoDonante" tabindex="-1" aria-labelledby="modalNuevoDonanteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #ffffff; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalNuevoDonanteLabel">
                    <i class="bi bi-plus-square me-2"></i> Nuevo Donante
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">
                <form id="formNuevoDonante" method="POST">
                    @csrf

                    <div class="mb-4 p-3 rounded" style="background-color: #b8cce92f;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-building me-1"></i> Información del Donante
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombreDonanteNuevo" class="form-label">Nombre</label>
                                <input type="text" id="nombreDonanteNuevo" name="nombre" class="form-control"
                                    placeholder="Nombre del donante" required>
                            </div>
                            <div class="col-md-3">
                                <label for="lugarDonanteNuevo" class="form-label">Tipo</label>
                                <input type="text" id="lugarDonanteNuevo" name="tipo" class="form-control"
                                    placeholder="Tipo">
                            </div>
                            <div class="col-md-3">
                                <label for="contactoDonanteNuevo" class="form-label">Contacto</label>
                                <input type="text" id="contactoDonanteNuevo" name="contacto" class="form-control"
                                    placeholder="Teléfono o correo">
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="reset" form="formNuevoDonante" class="btn btn-secondary">
                    <i class="bi bi-eraser-fill"></i> Limpiar
                </button>
                <button type="submit" id="btnGuardarDonante" class="btn btn-success" form="formNuevoDonante">
                    <i class="bi bi-check2-circle"></i> Guardar donacion
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
                <i class="bi bi-box-seam me-2"></i>Gestionar donantes
            </h2>

            <!-- Botones principales -->
            <div class="d-flex justify-content-end mb-3 gap-2">

            </div>
            <!-- Card de acciones (buscar, importar, exportar, bajas) -->
            <div class="card shadow-sm position-relative p-3 d-flex justify-content-center align-items-center mb-4 panel-external"
                id="cardDonantees" data-panel="donantes"
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

                        <!-- Nombre del donante -->
                        <div class="col-md-4 ">
                            <label class="form-label fw-semibold">Nombre del donante</label>
                            <input type="text" id="buscarNombreDonante"
                                class="form-control form-control-sm rounded-pill" placeholder="Nombre del donante">
                        </div>

                        <!-- Tipo -->
                        <div class="col-md-3 ">
                            {{-- <div class="me-2"> --}}
                            <label class="form-label fw-semibold">Tipo</label>
                            <input type="text" id="buscarLugar" class="form-control form-control-sm rounded-pill"
                                placeholder="Tipo">
                        </div>


                        <div class="col-md-2 ">
                            <button class="btn btn-primary btn-sm rounded-pill" id="btnBuscarDonante">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        {{-- <div class="col-md-1"></div> --}}


                        <!-- Botón Generar PDF al extremo derecho -->
                        <div class="col-md-3 gap-3 d-flex justify-content-end">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoDonante">
                                <i class="bi bi-plus-circle me-1"></i> Nuevo
                            </button>
                            <a href="{{ route('donantes.imprimir') }}" target="_blank" class="btn btn-danger btn-sm " id="btnGenerarPDF">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Generar PDF
                            </a>

                        </div>
                    </div>
                </div>
            </div>





                <div class="card shadow-sm position-relative p-3 d-none d-flex justify-content-center align-items-center mb-4 panel-external"
                    id="cardDonaciones" data-panel="donaciones"
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
<ul class="nav nav-pills mb-3 bg-light rounded p-1" id="tabsDonantees" role="tablist">
    <li class="nav-item me-2" role="presentation">
        <button class="nav-link active text-dark fw-semibold" id="tab-donantes" data-bs-toggle="tab"
                data-bs-target="#contenedorDonantees" type="button" role="tab" data-panels="donantes">
            <i class="bi bi-people-fill me-1"></i> donantes
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-dark fw-semibold" id="tab-donaciones"
                data-bs-toggle="tab" data-bs-target="#contenedorDonaciones" type="button" role="tab" data-panels="donaciones"
                aria-disabled="true">
            <i class="bi bi-card-list me-1"></i> donaciones
        </button>
    </li>
</ul>

<!-- Contenido de los tabs -->
<div class="tab-content d-flex flex-column bg-da53425nger position-relative overflow-auto p-3" style="height: 90vh; max-height: 80vh; min-height: 90vh;">

    <!-- donantes -->
    <div class="tab-pane fade show active flex-grow-1 position-relative" id="contenedorDonantees" role="tabpanel">
        <div id="contenedorListaDonantees" class="d-flex flex-column rounded p-2"
             style="height: 80vh; max-height: 80vh; overflow-y: auto;">
            <!-- Aquí se cargará la lista de donantes dinámicamente -->
        </div>
    </div>

    <!-- donaciones -->
    <div class="tab-pane fade position-relative " id="contenedorDonaciones" role="tabpanel">
        <div id="contenidoDonaciones" class="d-flex flex-column rounded p-2"
             style="height: 100%; max-height: 100%; overflow-y: auto;">
            <!-- Aquí se cargará la lista de donaciones dinámicamente -->
            <div style="height: 70vh; max-height: 70vh; overflow-y: auto; overflow-x: hidden; position: relative;">
                <table class="table table-striped mb-0 rounded">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Detalle</th>
                            <th>Fecha Adquisición</th>
                            <th>Donacion</th>
                            <th>Estado</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaDonaciones">
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

filtrarDonantees()





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
$('#formNuevoDonante').on('submit', function(e) {
    e.preventDefault();

    if (procesando) return;
    procesando = true;

    // Limpiar errores anteriores
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    
    $.ajax({
        url: baseUrl + '/donantes',
        method: 'POST',
        data: $(this).serialize(),
        success: function(res) {
            $('#modalNuevoDonante').modal('hide');
            filtrarDonantees();

            Swal.fire({
                icon: 'success',
                title: 'Donante registrado',
                text: 'El donante se ha creado correctamente'
            });

            $('#formNuevoDonante')[0].reset();
        },
        error: function(xhr) {

            if (xhr.status === 422) {
                // Laravel Validation errors
                let errors = xhr.responseJSON.errors;

                $.each(errors, function(campo, mensajes) {
                    let input = $('[name="' + campo + '"]');

                    // input rojo
                    input.addClass('is-invalid');

                    // mensaje debajo del input
                    input.after('<div class="invalid-feedback">' + mensajes[0] + '</div>');
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Datos incompletos',
                    text: 'Revisa los campos marcados en rojo.'
                });

            } else {
                // Error general
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo registrar el donante.'
                });
            }

            console.error(xhr.responseText);
        },
        complete: function() {
            procesando = false;
        }
    });
});



$('#formEditarDonante').on('submit', function(e) {
    e.preventDefault(); // evitar que se recargue la página

    let idDonante = $('#idDonanteEditar').val();

    $.ajax({
        url: baseUrl + '/donantes/' + idDonante, // Ruta tipo REST
        method: 'PUT',
        data: $(this).serialize(),
        success: function(res) {
            $('#modalEditarDonante').modal('hide'); // cerrar modal
            filtrarDonantees(); // recargar tabla
            Swal.fire({
                icon: 'success',
                title: 'Actualizado',
                text: 'Donante actualizado correctamente'
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo actualizar el donante'
            });
            console.error(xhr.responseText);
        }
    });
});

$(document).on('click', '.btnEditarDonante', function() {
    let fila = $(this).closest('tr'); // fila del botón
    let idDonante = $(this).data('id');

    // Leer valores de las celdas de la misma fila
    let nombre = fila.find('.nombre').text().trim();
    let tipo = fila.find('.tipo').text().trim();
    let contacto = fila.find('.contacto').text().trim();
// alert(nombre)
    // Asignar valores al modal
    let modal = $('#modalEditarDonante');
    modal.find('#idDonanteEditar').val(idDonante);
    modal.find('#nombreDonanteEditar').val(nombre);
    modal.find('#lugarDonanteEditar').val(tipo);
    modal.find('#contactoDonanteEditar').val(contacto);
});








function resetDonaciones() {
    // Seleccionamos el tbody de la tabla de donaciones
    let $tbody = $('#contenedorDonaciones table tbody');

    if ($tbody.length === 0) {
        // Si no hay tbody, crearlo
        $tbody = $('<tbody></tbody>').appendTo('#tablaDonaciones');
    }

    // Limpiar todas las filas
    $tbody.empty();

    // Insertar fila por defecto
    $tbody.append(`
        <tr>
            <td colspan="8" class="text-center text-muted">
                Seleccione un donacion
            </td>
        </tr>
    `);

    // Limpiar filtros asociados
    $('#buscarCodigoActivo').val('');
    $('#buscarNombreActivo').val('');
    $('#buscarFechaAdquisicion').val('');
    $('#filtroDonante').val('');
    $('#filtroEstadoCompra').val('');
}






$(document).off('click','.btnVerDonaciones').on('click','.btnVerDonaciones',function(){

    const detalleTab = new bootstrap.Tab(document.querySelector('#tab-donaciones'));
                detalleTab.show();
                if ($(this).hasClass('active')) {
                    return;
                }
                // Quitar clase active de otros botones
                $('.btnVerDonaciones').removeClass('active');
                $(this).addClass('active');
                filtrarDonaciones($(this).data('id'))
});

function filtrarDonaciones(idDonante, page = 1) {

if (!idDonante) {
return;
}
// Leer los valores de los inputs
let codigo   = $('#buscarCodigoActivo').val();
let nombre   = $('#buscarNombreActivo').val();
let fecha    = $('#buscarFechaAdquisicion').val();
$.ajax({
    url: baseUrl + "/donaciones/filtrar",  // tu ruta en el controlador de donaciones
    method: 'GET',
    data: {
        donante_id: idDonante,
        codigo: codigo,
        nombre: nombre,
        fecha: fecha,
        page: page
    },
    beforeSend: function() {
        $('#contenedorDonaciones').html(`
            <div class="text-center text-muted mt-4">
                <i class="bi bi-hourglass-split me-2"></i> Cargando listado de donaciones...
            </div>
        `);
    },
    success: function(data) {
        $('#contenedorDonaciones').html(data);
    },
    error: function(xhr) {
        console.error(xhr.responseText);
        $('#contenedorDonaciones').html(`
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle me-2"></i> Error al cargar las donaciones.
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












// Cuando se activa la pestaña donantes
$('#tab-donantes').on('shown.bs.tab', function(e) {

// Mostrar filtros de donantes y ocultar filtros de donaciones
// $('.filtroDonantees').removeClass('d-none');
// $('.filtroDonaciones').addClass('d-none');

// Si deseas cargar donantes solo la primera vez
// if (!donanteesCargados) {
//     $.get(baseUrl + "/donantes/lista", function(data) {
//         $('#contenedorDonantees').html(data);
//         donanteesCargados = true;
//     });
// }

});

// Cuando se activa la pestaña donaciones
$('#tab-donaciones').on('shown.bs.tab', function(e) {

// Mostrar filtros de donaciones y ocultar filtros de donantes
// $('.filtroDonaciones').removeClass('d-none');
// $('.filtroDonantees').addClass('d-none');

// // Si deseas cargar donaciones solo la primera vez
// if (!comprasCargadas) {
//     $.get(baseUrl + "/donaciones/lista", function(data) {
//         $('#contenedorDonaciones').html(data);
//         comprasCargadas = true;
//     });
// }
});













        $("#btnBuscarDonante").click(function() {
    filtrarDonantees()
});
        $("#btnBuscarActivo").click(function() {
            let idPrimerDonante = $('#contenedorListaDonantees table .btnVerDonaciones').first().data('id');// Buscar el botón activo dentro del contenedor
let idDonanteActivo = $('#contenedorListaDonantees .btnVerDonaciones.active').data('id');

// Llamar a la función con ese ID
filtrarDonaciones(idDonanteActivo);

});



function filtrarDonantees(page = 1) {
    resetDonaciones();
    let nombre = $('#buscarNombreDonante').val();
let tipo  = $('#buscarLugar').val();
// let page   = page ?? null;   // si usas paginación

$.ajax({
    url: baseUrl + "/donantes/filtrar",
    method: 'GET',
    data: {
        nombre: nombre,
        tipo: tipo,

    },
    beforeSend: function() {
        $('#contenedorListaDonantees').html(`
            <div class="text-center text-muted mt-4">
                <i class="bi bi-hourglass-split me-2"></i> Cargando listado de donantes...
            </div>
        `);
    },
    success: function(data) {
        $('#contenedorListaDonantees').html(data);
    },
    error: function(xhr) {
        console.error(xhr.responseText);
        $('#contenedorListaDonantees').html(`
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle me-2"></i> Error al cargar los donantes.
            </div>
        `);
    }
});

        }

$(document).on('click', '#contenedorDonaciones .pagination a', function(e) {
    e.preventDefault();
    
    let url = $(this).attr('href');
    if (!url) return;

    let page = url.split('page=')[1];

    let idDonante = $('#contenedorDonaciones table').data('id-donante');
    filtrarDonaciones(idDonante, page);
});




    });
    </script>
