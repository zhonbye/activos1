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
                    mensaje('Usuario registrado correctamente.', 'success');

                    // Cerrar modal
                    const idResponsable = response.usuario.id_responsable;
                    const idUsuario = response.usuario.id_usuario;
                    const fila = $('#contenedorTablaResponsables tbody tr[data-id="' +
                        idResponsable + '"]');
                    alert(fila.html())
                    bootstrap.Modal.getInstance(document.getElementById('modalNuevoUsuario'))
                .hide();

                    if (fila.length) {
                        // Cambiar el badge de “No tiene usuario” → “Tiene usuario”
                        fila.find('td').eq(6).html(
                            '<span class="badge bg-primary">Tiene usuario</span>'
                        );




                         fila.find('td').eq(8).html(
        `
        
        <button class="btn btn-sm btn-outline-primary editar-btn" data-bs-toggle="modal" data-bs-target="#modalEditarResponsable"
                data-id="${idResponsable}" title="Editar personal">
            <i class="bi bi-pencil"></i>
        </button>
        <button class="btn btn-sm btn-outline-danger eliminar-btn"
                data-id="${idResponsable}" title="Eliminar personal">
            <i class="bi bi-trash"></i>
        </button>
        
        
        <button class="btn btn-sm btn-outline-dark editar-usuario-btn"
                 data-id="${idUsuario}" 
                 title="Editar usuario">
             <i class="bi bi-person-gear"></i>
         </button>`
    );

                    }
                    // Limpiar formulario
                    $('#formNuevoUsuario')[0].reset();
                } else {
                    mensaje(response.message || 'Ocurrió un error inesperado.', 'danger');
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
                    mensaje('Existen errores en el formulario.', 'danger');
                } else {
                    mensaje('Ocurrió un error inesperado al enviar el formulario.', 'danger');
                }
            }
        });
    });
</script>
