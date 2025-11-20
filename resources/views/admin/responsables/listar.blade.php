<!-- Modal -->
<div class="modal fade" id="modalNuevoResponsable" tabindex="-1" aria-labelledby="modalNuevoResponsableLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #ffffff; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-primary bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalNuevoResponsableLabel">
                    <i class="bi bi-person-plus-fill me-2"></i> Registrar nuevo Personal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">
                @include('admin.responsables.nuevo', [
                    'tabla' => 'contenedorTablaResponsables',
                    'datos' => ['id_responsable', 'nombre', 'ci', 'telefono', 'cargo', 'rol', 'estado', 'fecha'],
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
                    <i class="bi bi-pencil-square me-2"></i> Editar Personal
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




<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="modalNuevoUsuarioLabel"
    aria-hidden="true">
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







<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color: #ffffff; color: #212529; border-radius: 12px;">

            <!-- Header -->
            <div class="modal-header border-0 bg-primary bg-opacity-10">
                <h5 class="modal-title fw-bold" id="modalEditarUsuarioLabel">
                    <i class="bi bi-person-gear me-2"></i> Editar usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-3">
                {{-- @include('admin.usuarios.editar') --}}

            </div>

            {{-- Opcional footer si quieres botones separados
            <div class="modal-footer border-0">
                <button type="reset" class="btn btn-secondary">
                    <i class="bi bi-eraser-fill"></i> Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-circle"></i> Guardar cambios
                </button>
            </div> --}}

        </div>
    </div>
</div>



<!-- Modal Lista de Usuarios -->
<div class="modal fade" id="modalListaUsuarios" tabindex="-1" aria-labelledby="modalListaUsuariosLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg"> <!-- modal-lg para tabla más ancha -->
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title" id="modalListaUsuariosLabel">
                    <i class="bi bi-people me-1"></i> Lista de usuarios
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-2">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Clave</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>ID Responsable</th>
                            <th>Token</th>
                            <th>Creado</th>
                            <th>Actualizado</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUsuarios">
                        <!-- Aquí se cargará la tabla parcial vía AJAX -->
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>













<div class="row bg-info4 pb-4 justify-content-center" style="height: 135vh; min-height: 135vh; max-height: 135vh;">

    <div class="main-col col-md-12 col-lg-11 order-lg-1 bg-dange4r order-1 mb-1 p-1 transition"
        style="position: relative; height: 135vh;max-height: 220vh; display: flex; flex-direction: column; overflow: visible;">

        <!-- CARD PRINCIPAL -->
        <div class="card p-4 rounded shadow"
            style="background-color: var(--color-fondo); display: flex; flex-direction: column; flex: 1 1 auto;">

            <!-- 🔹 Título -->
            <h2 class="mb-4 text-center text-primary">
                <i class="bi bi-people-fill me-2"></i>Listado del Personal / Usuarios
            </h2>

            <!-- 🔹 Botones principales -->
            <div class="d-flex justify-content-end mb-3 gap-2">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalNuevoResponsable">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Personal
                </button>


                <button class="btn btn-secondary btn-sm">
                    <i class="bi bi-printer-fill me-1"></i> Imprimir
                </button>
            </div>

            <div class="card mb-4 shadow-sm filtroPersonal"
                style="background-color: #f8f9fa; border-left: 5px solid #0d6efd; padding: 1.5rem;">
                <div class="row g-3 p-3 align-items-end">

                    <!-- 🔍 Buscar (frontend) -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-search me-1"></i>Buscar personal
                        </label>
                        <input type="text" id="buscarResponsable"
                            class="form-control form-control-sm rounded-pill shadow-sm px-3"
                            placeholder="Nombre, C.I. o telefono">
                    </div>

                    <div class="col-md-2"> </div>
                    <!-- 🧩 Filtro: Cargo -->
                    <div class="col-md-2  align-items-end">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-briefcase me-1"></i>Profesión
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
                            <i class="bi bi-person-badge me-1"></i>Cargo
                        </label>
                        <select id="filtroRol" class="form-select form-select-sm rounded-pill shadow-sm">
                            <option value="">Todos</option>
                            @php
                            $roles = [
                                'director',
                                'administrador',
                                'subdirector',
                                'coordinador',
                                'coordinador de pediatría',
                                'coordinador de radiología',
                                'coordinador de emergencias',
                                'coordinador de cirugía',
                                'coordinador de urología',
                                'coordinador cardiología',
                                'jefe de enfermería',
                                'enfermero jefe',
                                'enfermero general',
                                'auxiliar de enfermería',
                                'técnico en laboratorio',
                                'responsable de laboratorio',
                                'responsable de farmacia',
                                'responsable de nutrición',
                                'responsable de nutrición clínica',
                                'responsable de fisioterapia',
                                'responsable de psicología',
                                'responsable de servicios generales',
                                'responsable de docencia',
                                'responsable de investigación',
                                'médico general',
                                'médico especialista',
                                'cirujano',
                                'ginecólogo',
                                'pediatra',
                                'cardiólogo',
                                'urólogo',
                                'farmacéutico',
                                'nutricionista',
                                'psicólogo clínico',
                                'fisioterapeuta',
                                'personal operativo',
                                'administrativo',
                                'secretaria',
                                'recepcionista',
                                'auxiliar administrativo',
                                'contador',
                                'coordinador de logística',
                                'coordinador de recursos humanos',
                                'responsable de calidad',
                                'responsable de seguridad e higiene',
                                'responsable de mantenimiento',
                                'técnico en radiología',
                                'técnico en emergencias',
                                'técnico en farmacia',
                                'técnico en informática',
                                'tecnólogo médico',
                                'responsable de compras',
                                'responsable de archivo',
                                'coordinador de docencia',
                                'coordinador de investigación',
                                'jefe de departamento',
                                'subjefe de departamento',
                                'invitado',
                                'pasante / becario',
                                'voluntario'
                            ];
                        @endphp

                        @foreach ($roles as $rol)
                            <option value="{{ ucwords(strtolower($rol)) }}" {{ strtolower($responsable->rol ?? '') == strtolower($rol) ? 'selected' : '' }}>
                                {{ ucwords(strtolower($rol)) }}
                            </option>
                        @endforeach
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
                        <button class="btn btn-outline-primary btn-sm w-100" id="btnFiltrarResponsable">
                            <i class="bi bi-funnel me-1"></i>Filtrar
                        </button>
                    </div>
                </div>
            </div>











            <div class="card mb-4 shadow-sm filtroUsuario d-none"
                style="background-color: #f8f9fa; border-left: 5px solid #0d6efd; padding: 1.5rem;">
                <div class="row g-3 p-3 align-items-end">

                    <!-- 🔍 Buscar (frontend) -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-search me-1"></i>Buscar usuario
                        </label>
                        <input type="text" id="buscarUsuario"
                            class="form-control form-control-sm rounded-pill shadow-sm px-3"
                            placeholder="Personal o usuario">
                    </div>
                    <div class="col-md-3"> </div>

                    <!-- 👤 Filtro: Rol -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person-badge me-1"></i>Rol
                        </label>
                        <select id="filtroRolUsuario" class="form-select form-select-sm rounded-pill shadow-sm">
                            <option value="">Todos</option>
                            <option value="administrador">Administrador</option>
                            <option value="usuario">Usuario</option>
                        </select>
                    </div>

                    <!-- ⚙️ Filtro: Estado -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-toggle-on me-1"></i>Estado
                        </label>
                        <select id="filtroEstadoUsuario" class="form-select form-select-sm rounded-pill shadow-sm">
                            <option value="">Todos</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>

                    <!-- 🔎 Botón Filtrar -->
                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-outline-primary btn-sm w-100" id="btnFiltrarUsuarios">
                            <i class="bi bi-funnel me-1"></i>Filtrar
                        </button>
                    </div>

                </div>
            </div>






            <!-- 🔹 Contenedor donde cargará la tabla -->
            {{-- <div id="contenedorResultados">
            <!-- Aquí van los resultados -->
        </div> --}}

            {{-- <div id="contenedorTablaResponsables" class="d-flex flex-column bg- rounded shadow p-3 bg-info0 p-3"
                style="height: 60vh; max-height: 80vh; ">
                <!-- Aquí se cargará la tabla de responsables -->
                @include('admin.responsables.parcial')
                {{-- <div class="text-center text-muted mt-4">
                    <i class="bi bi-hourglass-split me-2"></i> Cargando listado de personal...
                </div>
            </div> --}}








            {{-- <div class="d-flex flex-column bg-white rounded shadow p-3" style="height: 90vh; max-height: 90vh;"> --}}

                <!-- Nav tabs compactas -->
                <ul class="nav nav-pills mb-3 bg-light rounded p-1 " id="tabList" role="tablist">
                    <li class="nav-item me-2" role="presentation">
                        <button class="nav-link active text-dark fw-semibold" id="tab-personal" data-bs-toggle="tab"
                            data-bs-target="#contenido-personal" type="button" role="tab">
                            <i class="bi bi-people me-1"></i> Personal
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-dark fw-semibold" id="tab-usuarios" data-bs-toggle="tab"
                            data-bs-target="#contenido-usuarios" type="button" role="tab">
                            <i class="bi bi-person-badge me-1"></i> Usuarios
                        </button>
                    </li>
                </ul>

                <!-- Tab panes -->
                {{-- <div class="tab-content flex-grow-1 overflow-auto" style="height: calc(100% - 50px);"> --}}
                <div class="tab-content d-flex flex-column flex-grow-1 overflow-auto bg-d5anger"
                    style="height: 50vh;">

                    <!-- Personal -->
                    {{-- <div class="tab-pane fade show active" id="contenido-personal" role="tabpanel">
                            <div id="contenedorTablaResponsables">
                                @include('admin.responsables.parcial')
                            </div>
                        </div> --}}
                    <div class="tab-pane fade show active flex-grow-1  bg-info8" id="contenido-personal"
                        role="tabpanel">
                        <div id="contenedorTablaResponsables"
                            class="d-flex mt-0 flex-column bg-dange3r rounded  p2-3 "
                            style="height: 85vh; max-height: 85vh; ">
                            @include('admin.responsables.parcial')
                        </div>
                    </div>

                    <!-- Usuarios -->
                    <div class="tab-pane fade" id="contenido-usuarios" role="tabpanel">
                        <div id="contenedorTablaUsuarios"
                        class="d-flex mt-0 flex-column bg-dange3r rounded  p2-3 "
                            style="height: 85vh; max-height: 85vh; ">
                            <!-- Aquí se cargará la tabla vía AJAX -->
                            <div class="text-center text-muted mt-3">
                                <i class="bi bi-hourglass-split me-2"></i> Cargando listado de usuarios...
                            </div>
                        </div>
                    </div>

                </div>
            {{-- </div> --}}











        </div>
    </div>
</div>
<script>
    // Helper para capitalizar texto
    function capitalize(text) {
        if (!text) return '';
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    function cargarDatos(tablaId, datos) {
        // console.log(datos)
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
            fila.setAttribute('data-id', item.id_responsable);

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
                `<span class="badge bg-dark">Sin acceso</span>`,
                item.fecha ?? '-', // fecha de registro
                `  <button class="btn btn-sm btn-outline-primary editar-btn" data-bs-toggle="modal" data-bs-target="#modalEditarResponsable"
                    data-id="${item.id_responsable}"
                    title="Editar personal">
              <i class="bi bi-pencil"></i>
            </button>
          <button class="btn btn-sm btn-outline-danger eliminar-btn"
                    data-id="${item.id_responsable}"
                    title="Eliminar personal">
              <i class="bi bi-trash"></i>
            </button>
             <button class="btn btn-sm btn-outline-secondary agregar-usuario-btn"
                      data-id="${item.id_responsable}"  data-bs-toggle="modal"
        data-bs-target="#modalNuevoUsuario"
                      title="Crear usuario para este personal">
                <i class="bi bi-person-plus"></i>
              </button>


         ` // acciones
            ];

            columnas.forEach((valor, index) => {
                const celda = document.createElement('td');
                if (index === 8) { // 👈 columna 8
                    celda.classList.add('text-center');
                }
                celda.innerHTML = valor;
                fila.appendChild(celda);
            });


            // Insertamos la fila al inicio del tbody
            tbody.prepend(fila);
        });


        // alert(`✅ ${datos.length} fila(s) agregadas a la tabla ${tablaId}`);
    }

    $(document).ready(function() {



        let usuariosCargados = false; // bandera para que solo cargue una vez
        $('#tab-usuarios').on('shown.bs.tab', function(e) {
            // Mostrar filtro de usuarios y ocultar filtro de personal
            $('.filtroUsuario').removeClass('d-none');
            $('.filtroPersonal').addClass('d-none');

            if (!usuariosCargados) {
                $.get("{{ route('usuarios.lista') }}", function(data) {
                    $('#contenedorTablaUsuarios').html(data);
                    usuariosCargados = true; // marcamos que ya se cargó
                });
            }
        });

        $('#tab-personal').on('shown.bs.tab', function(e) {
            // Mostrar filtro de personal y ocultar filtro de usuarios
            $('.filtroPersonal').removeClass('d-none');
            $('.filtroUsuario').addClass('d-none');
        });








        // Se dispara cuando se abre el modal
        $('#modalNuevoUsuario').on('show.bs.modal', function(event) {
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
                        $('#modalEditarResponsable ').find(
                            'button[data-bs-dismiss="modal"]').trigger('click');
                        // $('#modalEditarResponsable').find('button[data-bs-dismiss="modal"]').trigger('click');
                        let telefono = response.responsable.telefono;

                        // si el valor es null, undefined o cadena vacía
                        if (telefono === null || telefono === undefined || telefono
                            .trim() === '') {
                            telefono = '—';
                        }
                        // alert(estado)    // Actualizar fila en la tabla si existe
                        var fila = $('#contenedorTablaResponsables tbody tr[data-id="' +
                            idResponsable + '"]');
                        if (fila.length) {
                            fila.find('td:eq(0)').text(response.responsable.nombre);
                            fila.find('td:eq(1)').text(response.responsable.ci);
                            fila.find('td:eq(2)').text(telefono);
                            fila.find('td:eq(3)').text(response.responsable.cargo);
                            fila.find('td:eq(4)').text(response.responsable.rol);
                            // fila.find('td:eq(5)').text(response.responsable.estado);
                            fila.find('td:eq(5)').html(
                                `<span class='badge bg-success'>${response.responsable.estado}</span>`
                            );

                            fila.addClass('table-primary bg-opacity-10');
                            setTimeout(() => fila.removeClass(
                                'table-primary bg-opacity-10'), 2000);
                        }
                    } else {
                        mensaje2(response.message, 'danger');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, msgs) {
                            var input = $('#formEditarResponsable').find('[name="' +
                                key + '"]');
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


        // Evento submit para el formulario de edición de usuario
        $(document).on('submit', '#formEditarUsuario', function(e) {
            e.preventDefault(); // Evita recargar la página al enviar el formulario

            let formDataArray = $(this).serializeArray();
            let formData = $.param(formDataArray); // Convierte el array en query string

            // Obtener el ID del usuario desde el formulario
            let idUsuario = $(this).find('input[name="id_usuario"]').val();
            // alert(idUsuario)
            $.ajax({
                url: $(this).attr(
                'action'), // La ruta configurada en el atributo action del form
                method: 'PUT',
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    // Limpiar errores previos
                    $('#formEditarUsuario').find('.is-invalid').removeClass('is-invalid');
                    $('#formEditarUsuario').find('.invalid-feedback').remove();
                },
                success: function(response) {
                    if (response.success) {
                        mensaje2(response.message, 'success');

                        // Cerrar el modal
                        $('#modalEditarUsuario').find('button[data-bs-dismiss="modal"]')
                            .trigger('click');

                        // Buscar la fila en la tabla de usuarios
                        var fila = $('#contenedorTablaUsuarios tbody tr[data-id="' +
                            idUsuario + '"]');

                        if (fila.length) {
                            // 1️⃣ Responsable (nombre + CI)
                            fila.find('td:eq(0)').text(
                                response.usuario.responsable ?
                                response.usuario.responsable.nombre + ' (' + response
                                .usuario.responsable.ci + ')' :
                                '—'
                            );

                            // 2️⃣ Nombre de usuario
                            fila.find('td:eq(1)').text(response.usuario.usuario);

                            // 3️⃣ Rol del sistema
                            fila.find('td:eq(2)').text(
                                response.usuario.rol ? capitalize(response.usuario
                                .rol) : '—'
                            );

                            // 4️⃣ Estado
                            fila.find('td:eq(3)').html(
                                `<span class="badge ${
                            response.usuario.estado === 'activo' ? 'bg-success' :
                            response.usuario.estado === 'inactivo' ? 'bg-secondary' : 'bg-dark'
                        }">
                            ${capitalize(response.usuario.estado)}
                        </span>`
                            );

                            // 5️⃣ Fecha de actualización (updated_at)
                            fila.find('td:eq(5)').text(response.usuario.updated_at);

                            // Efecto visual de actualización
                            fila.addClass('table-primary bg-opacity-10');
                            setTimeout(() => fila.removeClass(
                                'table-primary bg-opacity-10'), 2000);
                        }
                    } else {
                        mensaje2(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, msgs) {
                            var input = $('#formEditarUsuario').find('[name="' +
                                key + '"]');
                            input.addClass('is-invalid');
                            if (input.next('.invalid-feedback').length === 0) {
                                input.after('<div class="invalid-feedback">' + msgs[
                                    0] + '</div>');
                            }
                        });
                        mensaje2('Existen errores en el formulario.', 'error');
                    } else {
                        mensaje2('Ocurrió un error inesperado al actualizar el usuario.',
                            'error');
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
                url: baseUrl + "/responsables/" + idResponsable +
                    "/edit", // <-- aquí va el ID en la URL
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




        // Cuando se hace click en el botón editar usuario
        $(document).on('click', '.editar-usuario-btn', function() {
            const idUsuario = $(this).data('id'); // Obtenemos el ID del usuario

            // Abrimos el modal
            const modal = $('#modalEditarUsuario');
            modal.modal('show');

            // Mostramos mensaje de carga
            modal.find('.modal-body').html(`
        <div class="text-center text-muted p-3">
            <i class="bi bi-hourglass-split me-2"></i> Cargando datos del usuario...
        </div>
    `);

            // Petición AJAX para obtener los datos del usuario
            $.ajax({
                url: baseUrl + "/usuarios/" + idUsuario +
                    "/edit", // Ruta del controlador que retorna la vista parcial con datos
                method: "GET",
                success: function(response) {
                    // Rellenamos el modal con la vista parcial
                    modal.find('.modal-body').html(response);

                    // Opcional: rellenar campos manualmente si devuelves JSON
                    /*
                    $('#idUsuarioEditar').val(response.id_usuario);
                    $('#usuarioEditar').val(response.usuario);
                    $('#rolEditar').val(response.rol);
                    $('#estadoEditar').val(response.estado);
                    $('#responsableEditarNombre').val(response.responsable.nombre);
                    $('#responsableEditarId').val(response.id_responsable);
                    */
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    modal.find('.modal-body').html(`
                <div class="alert alert-danger text-center">
                    <i class="bi bi-exclamation-triangle me-2"></i> Error al cargar los datos del usuario.
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

        let temporizadorBusqueda2; // 🕒 Para evitar muchas peticiones seguidas

        $('#buscarUsuario').on('keyup', function() {
            clearTimeout(temporizadorBusqueda); // Cancelar búsqueda anterior
            temporizadorBusqueda2 = setTimeout(() => {
                filtrarUsuarios(); // Llama a tu función AJAX existente
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
        $('#btnFiltrarResponsable').on('click', function() {
            filtrarResponsables();
        });
        $('#btnFiltrarUsuarios').on('click', function() {
            filtrarUsuarios();
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


        function filtrarUsuarios(page = 1) {
            let search = $('#buscarUsuario').val();
            let rol = $('#filtroRolUsuario').val();
            let estado = $('#filtroEstadoUsuario').val();

            $.ajax({
                url: "{{ route('usuarios.filtrar') }}",
                method: 'GET',
                data: {
                    search,
                    rol,
                    estado,
                    page
                },
                beforeSend: function() {
                    $('#contenedorTablaUsuarios').html(`
                <div class="text-center text-muted mt-4">
                    <i class="bi bi-hourglass-split me-2"></i> Cargando listado de usuarios...
                </div>
            `);
                },
                success: function(data) {
                    $('#contenedorTablaUsuarios').html(data);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    $('#contenedorTablaUsuarios').html(`
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
        $(document).on('click', '#contenedorTablaUsuarios .pagination a', function(e) {
            e.preventDefault(); // Evita recargar toda la página
            let page = $(this).attr('href').split('page=')[1]; // obtiene el número de página
            filtrarUsuarios(page); // tu función AJAX que recarga la tabla
        });


    });
</script>
