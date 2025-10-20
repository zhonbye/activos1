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
                <input type="text" class="form-control" name="numero_documento"
                    value="{{ $traslado->numero_documento ?? '' }}" required>
            </div>

            <div class="col-md-4 col-sm-6">
                <small class="text-muted">Gestión</small>
                <input type="number" class="form-control" name="gestion"
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

 $('#guardarCambiosTraslado').on('click', function() {
    if (!confirm('¿Está seguro que desea guardar los cambios en este traslado?')) return;

    var form = $('#modalEditarTraslado').find('form#formEditarTraslado');
    var idTraslado = form.find('input[name="id_traslado"]').val();
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
                bootstrap.Modal.getInstance(document.getElementById('modalEditarTraslado')).hide();

                // Actualizar tabla o recargar detalle
                cargarDetalleTraslado(idTraslado);

            } else {
                if (response.errors) {
                    // Mostrar errores directamente en el formulario
                    $.each(response.errors, function(key, msgs) {
                        var input = form.find('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        if (input.next('.invalid-feedback').length === 0) {
                            input.after('<div class="invalid-feedback d-block">' + msgs[0] + '</div>');
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
                        input.after('<div class="invalid-feedback d-block">' + msgs[0] + '</div>');
                    }
                });
                mensaje('Existen errores en el formulario.', 'danger');
            } else {
                let errorMsg = xhr.responseJSON?.message || 'Ocurrió un error inesperado al actualizar.';
                mensaje(errorMsg, 'danger');
            }
        }
    });
});





    // });
</script>
