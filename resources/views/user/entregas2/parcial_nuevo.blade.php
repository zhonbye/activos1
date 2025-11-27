<div class="card border-0 shadow-sm p-4 pt-0 mx-auto" style="max-width: 700px;">
    <div class="card-body">
        <div class="text-center mb-2">
            <i class="bi bi-plus-circle text-primary fs-1"></i>
            <h4 class="fw-bold mt-2">Nueva Entrega</h4>
            <p class="text-muted small">Complete los datos para registrar la entrega</p>
        </div>

        <form id="form_entrega" class="row g-3" action="{{ route('entregas.store') }}" method="POST">
            @csrf
            <div class="col-md-6 col-lg-6">
                <label for="numero_documento" class="form-label fw-bold">Número Documento</label>
                <input type="text" class="form-control fw-bold" value="{{ $numeroSiguiente }}"
                    name="numero_documento" id="numero_documento" readonly placeholder="">
                <div class="form-text">Este campo se genera automáticamente</div>
            </div>


            <div class="col-md-6 col-lg-6">
                <label for="gestion" class="form-label">Gestión</label>
                <input type="number" class="form-control" name="gestion" id="gestion" value="2025" required>
            </div>

            <div class="col-md-6 col-lg-6">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha" id="fecha" value="2025-09-16" required>
            </div>

            <div class="col-md-6 col-lg-6">
                <label for="id_servicio" class="form-label">Servicio destino</label>
                <select name="id_servicio" id="id_servicio" class="form-select" required>
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


            <div class="col-md-6 col-lg-12">
                <label for="observaciones" class="form-label">Observaciones</label>
                <textarea name="observaciones" id="observaciones" class="form-control" rows="3"
                    placeholder="Detalles de la entrega..."></textarea>
            </div>


            <div class="col-12 text-center mt-3">
                <button type="button" id="btn_guardar_entrega" class="btn btn-primary w-50">
                    <i class="bi bi-save me-1"></i> Guardar Entrega
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

$(document).on('input', '#form_entrega input[name="gestion"]', function() {
            var gestion = $(this).val().trim();

            // Verificar que tenga 4 dígitos
            if (gestion.length !== 4 || isNaN(gestion)) {
                mensaje('Debe ingresar una gestión válida de 4 dígitos.', 'warning');
                return;
            }

            // Mostrar cargando (opcional)
            $('#numero_documento').val('...');

            $.ajax({
                url: baseUrl + '/entregas/generar-numero/' + gestion,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#numero_documento').val(response.numero);
                        mensaje('Número generado correctamente.', 'success');
                    } else {
                        $('#numero_documento').val('');
                        mensaje(response.message || 'No se pudo generar el número.',
                            'danger');
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

        $(document).off('click', '#btn_guardar_entrega').on('click', '#btn_guardar_entrega', function() {
            var form = $('#form_entrega');
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

                        var entrega = response.data;
                        var identrega = entrega.id_entrega;

                        cargarDetalleEntrega(identrega);

                        cargarTablaActivos(identrega);

  form[0].reset();

                        $('#modalEntrega #form_entrega #numero_documento').val(response.siguiente_numero);
                        $('#modalEntrega .btn-close').trigger('click');
                        $('.modal-backdrop').remove();
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
                                    input.after('<div class="invalid-feedback">' +
                                        msgs[0] + '</div>');
                                }
                            }
                        });

                        var msg = xhr.responseJSON.message ||
                            'Existen errores en el formulario.';
                        mensaje(msg, 'danger');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje(xhr.responseJSON.message, 'danger');
                    } else {
                        mensaje('Ocurrió un error inesperado.', 'danger');
                    }
                }
            });
        });



        $(document).on('change', '#id_servicio', function() {
            let nombreResp = $(this).find(':selected').data('responsable');
            $('#info_responsable_destino').text('Responsable: ' + nombreResp);
        });


    });
</script>
