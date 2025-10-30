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
                        {{-- Observaciones (ocupa toda la fila) --}}
                    <div class="col-12">
                        <small class="text-muted">Observaciones</small>
                        <input type="text" class="form-control" name="observaciones"
                            value="{{ $traslado->observaciones ?? '' }}">
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
    var servicioActual = $("#contenedor_detalle_traslado #id_servicio_origen").val();
    var servicioNuevo = form.find('select[name="id_servicio_origen"]').val();

    var activosSeleccionados = $('#tabla_activos tbody tr[data-id-activo]').length;

    // Función para guardar traslado
    function guardarTraslado() {
        $.ajax({
            url: baseUrl + '/traslados/' + idTraslado + '/update',
            type: 'PUT',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
            },
            success: function(response) {
                if (response.success) {
                    mensaje(response.message || 'Traslado actualizado correctamente', 'success');
                    bootstrap.Modal.getInstance($('#modalEditarTraslado')[0]).hide();
                    cargarDetalleTraslado(idTraslado);
                    cargarTablaActivos(idTraslado);
                } else {
                    mensaje(response.message || 'No se pudo actualizar el traslado.', 'danger');
                }
            },
            // error: function(xhr) {
            //     const errorMsg = xhr.responseJSON?.message || 'Error inesperado al actualizar.';
            //     mensaje(errorMsg, 'danger');
            // }
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
        if (!confirm('Se ha cambiado el servicio de origen. Todos los activos seleccionados serán eliminados. ¿Desea continuar?')) return;

        $('#tabla_activos tbody').empty();

        $.ajax({
            url: `${baseUrl}/traslados/${idTraslado}/activos/limpiar`,
            type: 'POST',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    mensaje(response.message || 'Activos eliminados correctamente.', 'success');
                    inventarioCargado = false;

                    // ¡Solo ahora se guarda el traslado!
                    guardarTraslado();
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
        // No hay cambio de servicio o no hay activos, guardar directamente
        guardarTraslado();
    }
});






    // });
</script>
