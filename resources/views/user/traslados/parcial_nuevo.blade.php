<div class="card border-0 shadow-sm p-4 pt-0 mx-auto" style="max-width: 700px;">
    <div class="card-body">
        <div class="text-center mb-2">
            <i class="bi bi-plus-circle text-primary fs-1"></i>
            <h4 class="fw-bold mt-2">Nuevo Traslado</h4>
            <p class="text-muted small">Complete los datos para registrar el traslado</p>
        </div>

     <form id="form_traslado" class="row g-3" action="{{ route('traslados.store') }}" method="POST">
            @csrf

            <div class="col-md-6">
                <label class="form-label fw-semibold">Número de Documento</label>
                <input type="text" class="form-control fw-bold" value="{{ $numeroDisponible }}"
                    name="numero_documento" id="numero_documento" readonly placeholder="">
                <div class="form-text">Este campo se genera automáticamente</div>

            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Gestión</label>
                <input type="number" name="gestion" class="form-control" value="{{ $gestionActual }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="col-md-6">
    <label class="form-label fw-semibold">Servicio Origen</label>
    <select name="id_servicio_origen" id="id_servicio_origen" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach ($servicios as $s)
            <option value="{{ $s->id_servicio }}" data-responsable="{{ $s->responsable->nombre ?? 'N/D' }}">
                {{ $s->nombre }}
            </option>
        @endforeach
    </select>
    <div id="info_responsable_origen" class="form-text text-muted">
        Responsable: N/D
    </div>
</div>

<div class="col-md-6">
    <label class="form-label fw-semibold">Servicio Destino</label>
    <select name="id_servicio_destino" id="id_servicio_destino" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach ($servicios as $s)
            <option value="{{ $s->id_servicio }}" data-responsable="{{ $s->responsable->nombre ?? 'N/D' }}">
                {{ $s->nombre }}
            </option>
        @endforeach
    </select>
    <div id="info_responsable_destino" class="form-text text-muted">
        Responsable: N/D
    </div>
</div>


            <div class="col-12">
                <label class="form-label fw-semibold">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="3" placeholder="Ingrese observaciones..."></textarea>
            </div>

            <div class="col-12 text-center mt-3">
                <button type="button" id="btn_guardar_traslado" class="btn btn-primary w-50">
                    <i class="bi bi-save me-1"></i> Guardar Traslado
                </button>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {


// $(document).on('change', '#id_servicio_origen', function() {
//     hola();
// });

$(document).on('change', 'input[name="gestion"]', function() {
    var gestion = $(this).val().trim();

    // Verificar que tenga 4 dígitos
    if (gestion.length !== 4 || isNaN(gestion)) {
        mensaje('Debe ingresar una gestión válida de 4 dígitos.', 'warning');
        return;
    }

    // Mostrar cargando (opcional)
    $('#numero_documento').val('...');

    $.ajax({
        url: baseUrl + '/traslados/generar-numero/' + gestion,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#numero_documento').val(response.numero);
                mensaje('Número generado correctamente.', 'success');
            } else {
                $('#numero_documento').val('');
                mensaje(response.message || 'No se pudo generar el número.', 'danger');
            }
        },
        error: function(xhr) {
            $('#numero_documento').val('');
            let msg = 'Ocurrió un error al generar el número.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            mensaje(msg, 'danger');
        }
    });
});

    $(document).off('click', '#btn_guardar_traslado').on('click', '#btn_guardar_traslado', function() {
    var form = $('#form_traslado');
    var url = form.attr('action');

    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function() {
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();
        },
        success: function(response) {
    if (response.success) {
        mensaje(response.message, 'success');

        var traslado = response.data;
        var idtraslado = traslado.id_traslado;

        cargarDetalleTraslado(idtraslado);
        cargarTablaActivos(idtraslado);

        // Referencia directa al modal
        var $modal = $('#modalTraslado');

        // Cerrar modal
        var modalInstance = bootstrap.Modal.getInstance($modal[0]);
        if (modalInstance) modalInstance.hide();

    //    var $modal = $('#modalTraslado');
// var modalInstance = bootstrap.Modal.getInstance($modal[0]);

if (modalInstance) {
    modalInstance.hide();

    // Limpiar contenido cuando realmente se haya cerrado
    $modal.one('hidden.bs.modal', function() {
        $(this).find('.modal-body').html('');
    });
}

// También asegurarse de que no queden backdrops colgados
$('.modal-backdrop').remove();


        form[0].reset();
    } else {
        mensaje(response.message, 'danger');
    }
},

        error: function(xhr) {
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();

            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors || {};
                $.each(errors, function(key, msgs) {
                    var input = form.find('[name="' + key + '"]');
                    if (input.length > 0) {
                        input.addClass('is-invalid');
                        if (input.next('.invalid-feedback').length === 0) {
                            input.after('<div class="invalid-feedback">' + msgs[0] + '</div>');
                        }
                    }
                });

                var msg = xhr.responseJSON.message || 'Existen errores en el formulario.';
                mensaje(msg, 'danger');
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                mensaje(xhr.responseJSON.message, 'danger');
            } else {
                mensaje('Ocurrió un error inesperado.', 'danger');
            }
        }
    });
});



    $(document).on('change', '#id_servicio_origen', function() {
        let nombreResp = $(this).find(':selected').data('responsable');
        $('#info_responsable_origen').text('Responsable: ' + nombreResp);
    });

    $(document).on('change', '#id_servicio_destino', function() {
        let nombreResp = $(this).find(':selected').data('responsable');
        $('#info_responsable_destino').text('Responsable: ' + nombreResp);
    });
});
</script>
