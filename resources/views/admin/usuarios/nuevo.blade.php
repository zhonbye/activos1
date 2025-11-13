<form id="formNuevoUsuario" method="POST" action="{{ route('usuarios.store') }}">
    @csrf
    <input type="hidden" name="id_responsable" id="idResponsableUsuario" value="">

    <!-- 🧾 Sección 1: Usuario y contraseña -->
    <div class="mb-4 p-3 rounded" style="background-color: #e7eef886;">
        <h6 class="fw-bold border-bottom pb-1 mb-3">
            <i class="bi bi-person-vcard me-1"></i> Datos de usuario
        </h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="usuarioNuevo" class="form-label">Nombre de usuario</label>
                <input type="text" id="usuarioNuevo" name="usuario" class="form-control" placeholder="Ej: j.sanchez"
                    required>
            </div>
            <div class="col-md-6">
                <label for="rolNuevo" class="form-label">Rol del sistema</label>
                <select id="rolNuevo" name="rol" class="form-select" required>
                    <option value="">Seleccione un rol</option>
                    <option value="administrador">Administrador</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="claveNuevo" class="form-label">Contraseña</label>
                <input type="password" id="claveNuevo" name="clave" class="form-control"
                    placeholder="Ingrese contraseña" required>
            </div>
            <div class="col-md-6">
                <label for="claveConfirmNuevo" class="form-label">Confirmar contraseña</label>
                <input type="password" id="claveConfirmNuevo" name="clave_confirmation" class="form-control"
                    placeholder="Repita contraseña" required>
            </div>
        </div>
    </div>

    <!-- 🟢 Sección 2: Estado y responsable -->
    {{-- <div class="mb-4 p-3 rounded" style="background-color: #b7f3d27c;">
                        <h6 class="fw-bold border-bottom pb-1 mb-3">
                            <i class="bi bi-check2-circle me-1"></i> Estado y responsable
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="estadoNuevo" class="form-label">Estado</label>
                                <select id="estadoNuevo" name="estado" class="form-select" required>
                                    <option value="">Seleccione estado</option>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="responsableNuevo" class="form-label">Responsable</label>
                                <input type="text" id="responsableNuevoNombre" class="form-control" readonly>
                                <input type="hidden" id="responsableNuevoId" name="id_responsable">
                            </div>
                        </div>
                    </div> --}}

    <!-- Footer -->
    <div class="text-end">
        <button type="reset" class="btn btn-secondary">
            <i class="bi bi-eraser-fill"></i> Limpiar
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check2-circle"></i> Guardar
        </button>
    </div>

</form>




<script>
    // 🔧 Función que agrega una nueva fila a la tabla de usuarios
    function agregarFilaUsuario(usuario) {
        // Verificar si la tabla ya está cargada en el DOM
        const tbody = $('#contenedorTablaUsuarios tbody');
        if (!tbody.length) return; // Si aún no existe, salir sin hacer nada
        // alert(tbody.html())

        // Crear la nueva fila HTML
        const filaHTML = `
        <tr data-id="${usuario.id_usuario}">
            <td>${usuario.responsable ? usuario.responsable.nombre + ' (' + usuario.responsable.ci + ')' : 'd—'}</td>
            <td>${usuario.usuario}</td>
            <td>${usuario.rol ? capitalize(usuario.rol) : '—'}</td>
            <td>
                <span class="badge ${
                    usuario.estado === 'activo' ? 'bg-success' :
                    usuario.estado === 'inactivo' ? 'bg-secondary' : 'bg-dark'
                }">${capitalize(usuario.estado)}</span>
            </td>
            <td>${usuario.created_at ?? '—'}</td>
            <td>${usuario.updated_at ?? '—'}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-dark editar-usuario-btn"
                        data-id="${usuario.id_usuario}"
                        data-bs-toggle="modal" data-bs-target="#modalEditarUsuario"
                        title="Editar usuario">
                    <i class="bi bi-person-gear"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger eliminar-usuario-btn"
                        data-id="${usuario.id_usuario}"
                        title="Eliminar usuario">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `;

        // Insertar la fila al inicio del tbody
        tbody.prepend(filaHTML);

        // ✨ Efecto visual
        const nuevaFila = tbody.find('tr').first();
        nuevaFila.addClass('table-success bg-opacity-25');
        setTimeout(() => nuevaFila.removeClass('table-success bg-opacity-25'), 2500);
    }

    $('#formNuevoUsuario').submit(function(e) {
        e.preventDefault(); // Evita recargar la página al enviar el formulario

        // Serializar todo el formulario
        let formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'), // Acción definida en el formulario
            method: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                // Limpiar errores previos
                $('#formNuevoUsuario').find('.is-invalid').removeClass('is-invalid');
                $('#formNuevoUsuario').find('.invalid-feedback').remove();
            },
            success: function(response) {
                if (response.success) {
                    mensaje2('Usuario registrado correctamente.', 'success');
                    const usuario = response.usuario;
                    const idResponsable = usuario.responsable.id_responsable;
                    const idUsuario = usuario.id_usuario;

                    // Ocultar el modal
                    bootstrap.Modal.getInstance(document.getElementById('modalNuevoUsuario'))
                .hide();
// alert(idResponsable)
                    // Actualalerizar tabla de responsables
                    const fila = $('#contenedorTablaResponsables tbody tr[data-id="' +
                        idResponsable + '"]');
                    if (fila.length) {
                        fila.find('td').eq(6).html(
                            '<span class="badge bg-primary">Tiene usuario</span>');
                        fila.find('td').eq(8).html(`
                <button class="btn btn-sm btn-outline-primary editar-btn" data-bs-toggle="modal"
                        data-bs-target="#modalEditarResponsable" data-id="${idResponsable}"
                        title="Editar personal">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger eliminar-btn" data-id="${idResponsable}"
                        title="Eliminar personal">
                    <i class="bi bi-trash"></i>
                </button>
                <button class="btn btn-sm btn-outline-dark editar-usuario-btn"
                        data-id="${idUsuario}" title="Editar usuario">
                    <i class="bi bi-person-gear"></i>
                </button>
            `);
                    }

                    // 🔹 Agregar nueva fila a la tabla de usuarios si ya está cargada
                    agregarFilaUsuario(usuario);

                    // Limpiar formulario
                    $('#formNuevoUsuario')[0].reset();
                } else {
                    mensaje2(response.message || 'Ocurrió un error inesperado.', 'error');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    // Mostrar errores de validación
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, msgs) {
                        let input = $('#formNuevoUsuario').find('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        if (input.next('.invalid-feedback').length === 0) {
                            input.after('<div class="invalid-feedback">' + msgs[0] +
                                '</div>');
                        }
                    });
                    mensaje2('Existen errores en el formulario.', 'error');
                } else {
                    mensaje2('Ocurrió un error inesperado al enviar el formulario.', 'danger');
                }
            }
        });
    });
</script>
