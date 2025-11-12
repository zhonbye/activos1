<!-- Modal -->
<div class="modal fade" id="modalNuevoResponsable" tabindex="-1" aria-labelledby="modalNuevoResponsableLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #ffffff; color: #212529; border-radius: 12px;">

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
                    'datos' => ['nombre', 'ci', 'telefono', 'cargo', 'rol', 'estado', 'fecha'],
                ])

            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="reset" id="btnLimpiarResponsable" class="btn btn-secondary" form="formNuevoResponsable">
                    <i class="bi bi-eraser-fill"></i> Limpiar
                </button>
                <button type="submit" id="btnGuardarResponsable" class="btn btn-primary" form="formNuevoResponsable">
                    <i class="bi bi-check2-circle"></i> Guardar
                </button>
            </div>

        </div>
    </div>
</div>




<!-- Modal de edición -->
<div class="modal fade" id="modalEditarResponsable" tabindex="-1" aria-labelledby="modalEditarResponsableLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #ffffff; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalEditarResponsableLabel">
                    <i class="bi bi-pencil-square me-2"></i> Editar Responsable
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">
             
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0">
                <button type="reset" form="formEditarResponsable" class="btn btn-secondary">
                    <i class="bi bi-eraser-fill"></i> Limpiar
                </button>
                <button type="submit" id="btnActualizarResponsable" class="btn btn-success"
                    form="formEditarResponsable">
                    <i class="bi bi-check2-circle"></i> Guardar cambios
                </button>
            </div>

        </div>
    </div>
</div>




<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="modalNuevoUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #ffffff; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-primary bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalNuevoUsuarioLabel">
                    <i class="bi bi-person-plus-fill me-2"></i> Crear nuevo usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">
                @include('admin.usuarios.nuevo')
            </div>
{{-- <div class="modal-footer border-0">
                 <button type="reset" class="btn btn-secondary">
                            <i class="bi bi-eraser-fill"></i> Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle"></i> Guardar
                        </button>
            </div> --}}

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
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalNuevoResponsable">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Responsable
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
    <option value="administrador">Administrador</option>
    <option value="director">Director</option>
    <option value="coordinador">Coordinador</option>
    <option value="medico">Médico / Doctor</option>
    <option value="enfermero">Enfermero / Técnico de enfermería</option>
    <option value="administrativo">Personal administrativo / Secretaria</option>
    <option value="Personal_operativo">Personal operativo</option>
    <option value="invitado">Visitante / Invitado</option>
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
                @include('admin.responsables.parcial')
                {{-- <div class="text-center text-muted mt-4">
                    <i class="bi bi-hourglass-split me-2"></i> Cargando listado de personal...
                </div> --}}
            </div>

        </div>
    </div>
</div>
<script>
    function cargarDatos(tablaId, datos) {
        console.log(datos)
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

            // 🧩 Añadimos las columnas en el orden deseado
            const columnas = [
                item.nombre ?? '-',
                item.ci ?? '-',
                item.telefono ?? '-',
                item.cargo ?? '-',
                item.rol ?? '-',
                `<span class="badge bg-success">Activo</span>`,
                // item.estado ?? '-', // si lo tienes
                // item.usuario ?? '-', // usuario del sistema
                `<span class="badge bg-dark">No tiene usuario</span>`,
                item.fecha ?? '-', // fecha de registro
                `<button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
         <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>` // acciones
            ];

            columnas.forEach(valor => {
                const celda = document.createElement('td');
                celda.innerHTML = valor; // usamos innerHTML para los botones
                fila.appendChild(celda);
            });

            // Insertamos la fila al inicio del tbody
            tbody.prepend(fila);
        });


        alert(`✅ ${datos.length} fila(s) agregadas a la tabla ${tablaId}`);
    }

    $(document).ready(function() {









// Se dispara cuando se abre el modal
$('#modalNuevoUsuario').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que abrió el modal
    var idResponsable = button.data('id'); // Extrae el ID del responsable

    // Llenar el input hidden del formulario con el ID
    $('#idResponsableUsuario').val(idResponsable);
});






// $('#modalEditarResponsable #formEditarResponsable').submit(function(e) {
$(document).on('submit', '#formEditarResponsable', function(e) {
    e.preventDefault(); // Evita recargar la página al enviar el formulario
// alert("hola")
    let formDataArray = $(this).serializeArray();

    // Si tuvieras algún checkbox especial, lo agregas aquí como en tu ejemplo
    // Por ejemplo: formDataArray.push({ name: 'activo', value: $('#activo_checkbox').is(':checked') ? 1 : 0 });

    // Convertir array de datos a query string para enviarlo
    let formData = $.param(formDataArray);

    // Tomar el ID del responsable
    let idResponsable = $(this).find('input[name="id_responsable"]').val();
    // let url = "/responsables/" + idResponsable; // Ruta RESTful PUT
// alert($(this).attr('action'))
    $.ajax({
        url: $(this).attr('action'),
        method: 'PUT',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            // Limpiar errores previos
            // $('#formEditarResponsable').find('.is-invalid').removeClass('is-invalid');
            // $('#formEditarResponsable').find('.invalid-feedback').remove();
        },
        success: function(response) {
            if (response.success) {
                mensaje2(response.message, 'success');
// console.log("fdsafds")
                // Ocultar modal
                // bootstrap.Modal.getInstance(document.getElementById('modalEditarResponsable')).hide();
                // $('#modalEditarResponsable #modalEditarResponsable').find('button[data-bs-dismiss="modal"]').trigger('click');
                $('#modalEditarResponsable ').find('button[data-bs-dismiss="modal"]').trigger('click');
                // $('#modalEditarResponsable').find('button[data-bs-dismiss="modal"]').trigger('click');

                // Actualizar fila en la tabla si existe
                var fila = $('#contenedorTablaResponsables tbody tr[data-id="' + idResponsable + '"]');
                if (fila.length) {
                    fila.find('td:eq(0)').text(response.responsable.nombre);
                    fila.find('td:eq(1)').text(response.responsable.ci);
                    fila.find('td:eq(2)').text(response.responsable.telefono);
                    fila.find('td:eq(3)').text(response.responsable.cargo);
                    fila.find('td:eq(4)').text(response.responsable.rol);
                    // fila.find('td:eq(5)').text(response.responsable.estado);
                    fila.find('td:eq(5)').text(" <span class='badge bg-success'>"+response.responsable.estado+"</span>");

                    fila.addClass('table-primary bg-opacity-10');
                    setTimeout(() => fila.removeClass('table-primary bg-opacity-10'), 2000);
                }
            } else {
                mensaje2(response.message, 'danger');
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, msgs) {
                    var input = $('#formEditarResponsable').find('[name="' + key + '"]');
                    input.addClass('is-invalid');
                    if (input.next('.invalid-feedback').length === 0) {
                        input.after('<div class="invalid-feedback">' + msgs[0] + '</div>');
                    }
                });
                mensaje2('Existen errores en el formulario.', 'danger');
            } else {
                mensaje2('Ocurrió un error inesperado al actualizar.', 'danger');
            }
        }
    });
});




// Cuando se hace click en el botón editar
$(document).on('click', '.editar-btn', function() {
    const idResponsable = $(this).data('id'); // Obtenemos el ID del data-id

    // Petición AJAX
    // let idResponsable = $(this).data('id'); // tu botón tiene data-id
$.ajax({
    url: baseUrl+"/responsables/" + idResponsable + "/edit", // <-- aquí va el ID en la URL
    method: "GET",
    beforeSend: function() {
        $('#modalEditarResponsable .modal-body').html(`
            <div class="text-center text-muted p-3">
                <i class="bi bi-hourglass-split me-2"></i> Cargando datos...
            </div>
        `);
    },
    success: function(response) {
        $('#modalEditarResponsable .modal-body').html(response);
        
        // $('#modalEditarResponsable').modal('show');
    },
    error: function(xhr) {
        console.error(xhr.responseText);
        $('#modalEditarResponsable .modal-body').html(`
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle me-2"></i> Error al cargar los datos.
            </div>
        `);
    }
});

});










        let temporizadorBusqueda; // 🕒 Para evitar muchas peticiones seguidas

        $('#buscarResponsable').on('keyup', function() {
            clearTimeout(temporizadorBusqueda); // Cancelar búsqueda anterior
            temporizadorBusqueda = setTimeout(() => {
                filtrarResponsables(); // Llama a tu función AJAX existente
            }, 400); // Espera 400ms después de dejar de escribir
        });





        // $('#buscarResponsable').on('keyup', function() {
        //     let valor = $(this).val().toLowerCase();

        //     $('#contenedorTablaResponsables table tbody tr').filter(function() {
        //         // Buscamos en Código, Nombre y Detalle
        //         $(this).toggle(
        //             $(this).find('td:eq(0)').text().toLowerCase().indexOf(valor) > -1 ||
        //             $(this).find('td:eq(1)').text().toLowerCase().indexOf(valor) > -1 ||
        //             $(this).find('td:eq(2)').text().toLowerCase().indexOf(valor) > -1
        //         );
        //     });
        // });










        // 🔎 Ejecutar filtrado al hacer clic en el botón
        $('#btnFiltrarActivos').on('click', function() {
            filtrarResponsables();
        });

        // 🧩 Función principal del filtrado
        function filtrarResponsables(page = 1) {
            let id_cargo = $('#filtroCargo').val();
            let rol = $('#filtroRol').val();
            let estado = $('#filtroEstado').val();
            let search = $('#buscarResponsable').val(); // 🔍 nuevo campo

            $.ajax({
                url: "{{ route('responsables.filtrar') }}",
                method: 'GET',
                data: {
                    id_cargo: id_cargo,
                    rol: rol,
                    estado: estado,
                    search: search, // 🔍 enviar texto de búsqueda
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
