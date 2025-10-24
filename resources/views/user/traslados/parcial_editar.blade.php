<form id="formEditarTraslado">
    @csrf
    <input type="hidden" id="traslado_id" name="id_traslado" value="{{ $traslado->id_traslado ?? '' }}">

    <div class="container-fluid py-3">

        {{-- ============================ --}}
        {{--  INFORMACIÓN GENERAL DEL TRASLADO --}}
        {{-- ============================ --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-dark text-white fw-bold fs-5">
                <i class="bi bi-card-text me-2"></i> Editar Acta de Traslado
            </div>
            <div class="card-body">
                <div class="row g-3">

                    {{-- Observaciones (ocupa toda la fila) --}}
                    <div class="col-12">
                        <small class="text-muted">Observaciones</small>
                        <input type="text" class="form-control" name="observaciones"
                            value="{{ $traslado->observaciones ?? '' }}">
                    </div>

                    {{-- Número de Traslado, Gestión y Fecha --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Número de Traslado</small>
                        <div class="d-flex ">
                            <div class="input-group">
                                <input type="text" id="numerogeneradoedicion" class="form-control"
                                    {{-- aquí está la clase is-invalid para simular el error --}} name="numero_documento"
                                    value="{{ $traslado->numero_documento ?? '' }}" required style="min-width: 0;"
                                    {{-- evita que el input crezca demasiado --}}>
                            </div>
                            <button class="btn btn-outline-primary" type="button"
                                id="generarNumero"style="flex-shrink: 0; align-self: flex-start;">
                                <i class="bi bi-search"></i> <!-- ícono lupa usando Bootstrap Icons -->
                            </button>
                        </div>
                    </div>



                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Gestión</small>
                        <input type="number" id="gestion" class="form-control" name="gestion"
                            value="{{ $traslado->gestion ?? date('Y') }}">
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Fecha</small>
                        <input type="date" class="form-control" name="fecha"
                            value="{{ $traslado->fecha ?? date('Y-m-d') }}">
                    </div>

                    {{-- Servicio Origen --}}
                    <div class="col-md-6 col-sm-6">
                        <small class="text-muted">Servicio Origen</small>
                        <select name="id_servicio_origen" class="form-select" id="servicio_origen">
                            <option selected disabled>Seleccione...</option>
                            @foreach ($servicios as $serv)
                                <option value="{{ $serv->id_servicio }}"
                                    {{ isset($traslado->servicioOrigen) && $traslado->servicioOrigen->id_servicio == $serv->id_servicio ? 'selected' : '' }}>
                                    {{ $serv->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Servicio Destino --}}
                    <div class="col-md-6 col-sm-6">
                        <small class="text-muted">Servicio Destino</small>
                        <select name="id_servicio_destino" class="form-select">
                            <option selected disabled>Seleccione...</option>
                            @foreach ($servicios as $serv)
                                <option value="{{ $serv->id_servicio }}"
                                    {{ isset($traslado->servicioDestino) && $traslado->servicioDestino->id_servicio == $serv->id_servicio ? 'selected' : '' }}>
                                    {{ $serv->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>


        {{-- Botones dentro del formulario --}}
        {{-- <div class="modal-footer"> --}}
        <button type="button" class="btn btn-success" id="guardarCambiosTraslado">Guardar cambios</button>
        <button type="reset" class="btn btn-secondary" id="restablecerTraslado">Restablecer</button>
        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
        {{-- </div> --}}
    </div>
</form>

<script>
    // $(document).ready(function() {

    $('#generarNumero').on('click', function() {
        var gestion = $('#gestion').val().trim();
        alert(gestion)
        if (gestion.length !== 4 || isNaN(gestion)) {
            mensaje('Debe ingresar una gestión válida de 4 dígitos.', 'warning');
            return;
        }
        $.ajax({
            url: baseUrl + '/traslados/generar-numero/' + gestion,
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
    $('#guardarCambiosTraslado').on('click', function() {
        if (!confirm('¿Está seguro que desea guardar los cambios en este traslado?')) return;

        var form = $('#modalEditarTraslado').find('form#formEditarTraslado');
        var idTraslado = form.find('input[name="id_traslado"]').val();
        var servicioActual = form.find('select[name="id_servicio_origen"]').data('original'); // guardamos el original
        var servicioActual = $("#contenedor_detalle_traslado #id_servicio_origen").val(); // guardamos el original
        var servicioNuevo = form.find('select[name="id_servicio_origen"]').val();
// alert(servicioActual +" y "+servicioNuevo)
        // Verificar si cambió el servicio
        if (servicioActual != servicioNuevo) {
            // alert("fdsafds")
            var activosSeleccionados = $('#tabla_activos tbody tr').length;
            if (activosSeleccionados > 0 ) {
                if (!confirm(
                        'Se ha cambiado el servicio de origen. Todos los activos seleccionados serán eliminados. ¿Desea continuar?'
                        )) {
                    return; // Detener acción
                }

                // Eliminar visualmente los activos de la tabla
                $('#tablaActivosTraslado tbody').empty();

                // Opcional: también enviar petición al servidor para limpiar los activos guardados
                $.post(`${baseUrl}/traslados/${idTraslado}/activos/limpiar`, {
                    _token: $('meta[name="csrf-token"]').attr('content')
                });
            }
        }










        var url = baseUrl + '/traslados/' + idTraslado + '/update';

        $.ajax({
            url: url,
            type: 'PUT',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                // Limpiar errores anteriores
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
            },
            success: function(response) {
                if (response.success) {
                    mensaje(response.message || 'Traslado actualizado correctamente', 'success');

                    // Cerrar modal
                    bootstrap.Modal.getInstance(document.getElementById('modalEditarTraslado'))
                        .hide();

                    // Actualizar tabla o recargar detalle
                    cargarDetalleTraslado(idTraslado);

                } else {
                    if (response.errors) {
                        // Mostrar errores directamente en el formulario
                        $.each(response.errors, function(key, msgs) {
                            var input = form.find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            if (input.next('.invalid-feedback').length === 0) {
                                input.after('<div class="invalid-feedback d-block">' + msgs[
                                    0] + '</div>');
                            }
                        });
                        mensaje('Existen errores en el formulario.', 'danger');
                    } else {
                        mensaje(response.message || 'No se pudo actualizar el traslado.', 'danger');
                    }
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(key, msgs) {
                        var input = form.find('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        if (input.next('.invalid-feedback').length === 0) {
                            input.after('<div class="invalid-feedback d-block">' + msgs[0] +
                                '</div>');
                        }
                    });
                    mensaje('Existen errores en el formulario.', 'danger');
                } else {
                    let errorMsg = xhr.responseJSON?.message ||
                        'Ocurrió un error inesperado al actualizar.';
                    mensaje(errorMsg, 'danger');
                }
            }
        });
    });





    // });
</script>
