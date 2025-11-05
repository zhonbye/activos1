<form id="formEditarDevolucion">
    @csrf
    <input type="hidden" id="devolucion_id" name="id_devolucion" value="{{ $devolucion->id_devolucion ?? '' }}">

    <div class="container-fluid py-3">

        {{-- ============================ --}}
        {{--  INFORMACIÓN GENERAL DE LA DEVOLUCIÓN --}}
        {{-- ============================ --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-dark text-white fw-bold fs-5">
                <i class="bi bi-card-text me-2"></i> Editar Acta de Devolución
            </div>
            <div class="card-body">
                <div class="row g-3">

                    {{-- Número de Devolución --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Número de Devolución</small>
                        <div class="d-flex">
                            <div class="input-group">
                                <input type="text" id="numerogeneradoedicion" class="form-control" 
                                    name="numero_documento"
                                    value="{{ $devolucion->numero_documento ?? '' }}" 
                                    required style="min-width: 0;">
                            </div>
                            <button class="btn btn-outline-primary" type="button" id="generarNumero" style="flex-shrink: 0; align-self: flex-start;">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Gestión --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Gestión</small>
                        <input type="number" id="gestion" class="form-control" name="gestion"
                            value="{{ $devolucion->gestion ?? date('Y') }}">
                    </div>

                    {{-- Fecha --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Fecha</small>
                        <input type="date" class="form-control" name="fecha"
                            value="{{ $devolucion->fecha ?? date('Y-m-d') }}">
                    </div>

                    {{-- Servicio --}}
                    <div class="col-md-6 col-sm-6">
                        <small class="text-muted">Servicio</small>
                        <select name="id_servicio" class="form-select" id="servicio">
                            <option selected disabled>Seleccione...</option>
                            @foreach ($servicios as $serv)
                                <option value="{{ $serv->id_servicio }}"
                                    {{ isset($devolucion->servicio) && $devolucion->servicio->id_servicio == $serv->id_servicio ? 'selected' : '' }}>
                                    {{ $serv->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-12">
                        <small class="text-muted">Observaciones</small>
                        <input type="text" class="form-control" name="observaciones"
                            value="{{ $devolucion->observaciones ?? '' }}">
                    </div>

                </div>
            </div>
        </div>

        {{-- Botones --}}
        <button type="button" class="btn btn-success" id="guardarCambiosDevolucion">Guardar cambios</button>
        <button type="reset" class="btn btn-secondary" id="restablecerDevolucion">Restablecer</button>

    </div>
</form>

<script>
    // Generar número
    $('#generarNumero').on('click', function() {
        var gestion = $('#gestion').val().trim();
        if (gestion.length !== 4 || isNaN(gestion)) {
            mensaje('Debe ingresar una gestión válida de 4 dígitos.', 'warning');
            return;
        }
        $.ajax({
            url: baseUrl + '/devolucion/generar-numero/' + gestion,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#numerogeneradoedicion').val(response.numero);
                    mensaje('Número generado correctamente.', 'success');
                } else {
                    $('#numerogeneradoedicion').val('');
                    mensaje(response.message || 'No se pudo generar el número.', 'danger');
                }
            },
            error: function(xhr) {
                $('#numerogeneradoedicion').val('');
                let msg = 'Ocurrió un error al generar el número.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                mensaje(msg, 'danger');
            }
        });
    });

    // Guardar cambios
    $('#guardarCambiosDevolucion').on('click', function() {
        if (!confirm('¿Está seguro que desea guardar los cambios en esta devolución?')) return;

        var form = $('#modalEditarDevolucion').find('form#formEditarDevolucion');
        var idDevolucion = form.find('input[name="id_devolucion"]').val();
        var servicioActual = $("#contenedor_detalle_devolucion #id_servicio").val();
        var servicioNuevo = form.find('select[name="id_servicio"]').val();

        var activosSeleccionados = $('#tabla_activos tbody tr[data-id-activo]').length;

        function guardarDevolucion() {
            $.ajax({
                url: baseUrl + '/devolucion/' + idDevolucion + '/update',
                type: 'PUT',
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function() {
                    form.find('.is-invalid').removeClass('is-invalid');
                    form.find('.invalid-feedback').remove();
                },
                success: function(response) {
                    if (response.success) {
                        mensaje(response.message || 'Devolución actualizada correctamente', 'success');
                        bootstrap.Modal.getInstance($('#modalEditarDevolucion')[0]).hide();
                        cargarDetalleDevolucion(idDevolucion);
                        cargarTablaActivos(idDevolucion);
                    } else {
                        mensaje(response.message || 'No se pudo actualizar la devolución.', 'danger');
                    }
                },
                error: function(xhr) {
    if (xhr.status === 422 && xhr.responseJSON.errors) {
        // Mostrar todos los mensajes de validación
        let errores = xhr.responseJSON.errors;
        let mensajes = [];
        Object.keys(errores).forEach(function(key) {
            errores[key].forEach(function(msg) {
                mensajes.push(msg);
                // Opcional: marcar los campos con error
                form.find('[name="' + key + '"]').addClass('is-invalid')
                    .after('<div class="invalid-feedback">' + msg + '</div>');
            });
        });
        mensaje(mensajes.join('<br>'), 'warning');
    } else {
        // Otros errores (500, excepciones, etc.)
        const msg = xhr.responseJSON?.message || 'Ocurrió un error inesperado.';
        mensaje(msg, 'danger');
    }
}

            });
        }

        // Si cambio de servicio y hay activos, limpiar primero
        if (servicioActual != servicioNuevo && activosSeleccionados > 0) {
            if (!confirm('Se ha cambiado el servicio. Todos los activos seleccionados serán eliminados. ¿Desea continuar?')) return;

            $('#tabla_activos tbody').empty();

            $.ajax({
                url: `${baseUrl}/devolucion/${idDevolucion}/activos/limpiar`,
                type: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        mensaje(response.message || 'Activos eliminados correctamente.', 'success');
                        inventarioCargado = false;
                        guardarDevolucion();
                    } else {
                        mensaje(response.message || 'Error al eliminar los activos.', 'danger');
                    }
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Error de comunicación con el servidor.';
                    mensaje(msg, 'danger');
                }
            });
        } else {
            guardarDevolucion();
        }
    });
</script>
