<div class="card border-0 shadow-sm p-4 pt-0 mx-auto" style="max-width: 700px;">
    <div class="card-body">
        <div class="text-center mb-2">
            <i class="bi bi-plus-circle text-primary fs-1"></i>
            <h4 class="fw-bold mt-2">Nueva Devolución</h4>
            <p class="text-muted small">Complete los datos generales para registrar la devolución</p>
        </div>

        <form id="form_devolucion" class="row g-3" action="{{ route('devolucion.store') }}" method="POST">
            @csrf

            {{-- Número de Documento --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Número de Documento</label>
                <input type="text" class="form-control fw-bold" value="{{ $numeroDisponible }}"
                    name="numero_documento" id="numero_documento" readonly>
                <div class="form-text">Este campo se genera automáticamente</div>
            </div>

            {{-- Gestión --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Gestión</label>
                <input type="number" name="gestion" class="form-control" value="{{ $gestionActual }}" required>
            </div>

            {{-- Fecha --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            {{-- Servicio --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Servicio</label>
                <select name="id_servicio" id="id_servicio" class="form-select" required>
                    <option value="">Seleccione...</option>
                    @foreach ($servicios as $s)
                        <option value="{{ $s->id_servicio }}" data-responsable="{{ $s->responsable->nombre ?? 'N/D' }}">
                            {{ $s->nombre }}
                        </option>
                    @endforeach
                </select>
                <div id="info_responsable" class="form-text text-muted">
                    Responsable: N/D
                </div>
            </div>

            {{-- Observaciones --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="3" placeholder="Ingrese observaciones..." ></textarea>
            </div>

            {{-- Botón guardar --}}
            <div class="col-12 text-center mt-3">
                <button type="button" id="btn_guardar_devolucion" class="btn btn-primary w-50">
                    <i class="bi bi-save me-1"></i> Guardar Devolución
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

        // $(document).on('change', 'input[name="gestion"]', function() {
$(document).on('input', '#form_devolucion input[name="gestion"]', function() {

            var gestion = $(this).val().trim();

            // Verificar que tenga 4 dígitos
            if (gestion.length !== 4 || isNaN(gestion)) {
                mensaje('Debe ingresar una gestión válida de 4 dígitos.', 'warning');
                return;
            }

            // Mostrar cargando (opcional)
            $('#numero_documento').val('...');

            $.ajax({
                url: baseUrl + '/devolucion/generar-numero/' + gestion,
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

        $(document).off('click', '#btn_guardar_devolucion').on('click', '#btn_guardar_devolucion', function() {
            var form = $('#form_devolucion');
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

                        var devolucion = response.data;
                        var iddevolucion = devolucion.id_devolucion;

                        cargarDetalleDevolucion(iddevolucion);
                        cargarTablaActivos(iddevolucion);
                        // $(this).blur();


                          form[0].reset();

                        $('#modalNuevaDevolucion #form_devolucion #numero_documento').val(response.siguiente_numero);
                        $('#modalNuevaDevolucion .btn-close').trigger('click');
                        $('.modal-backdrop').remove();
            //             var $modal = $('.modal.show');
            // // var $botonAbrirModal = $('.btn-ver-detalle-principal[data-id-activo="' + 3 + '"]');
            // setTimeout(() => {

            // }, 10000);
            // $modal.find('button[data-bs-dismiss="modal"]').trigger('click');
            // $(this).blur();

                        // Referencia directa al modal
                        // var $modal = $('#modaldevolucion');

                        // // Cerrar modal
                        // var modalInstance = bootstrap.Modal.getInstance($modal[0]);
                        // if (modalInstance) modalInstance.hide();

                        // //    var $modal = $('#modaldevolucion');
                        // // var modalInstance = bootstrap.Modal.getInstance($modal[0]);

                        // if (modalInstance) {
                        //     modalInstance.hide();

                        //     // Limpiar contenido cuando realmente se haya cerrado
                        //     $modal.one('hidden.bs.modal', function() {
                        //         $(this).blur();
                        //         $(this).find('.modal-body').html('');
                        //     });
                        // }

                        // // También asegurarse de que no queden backdrops colgados
                        // $('.modal-backdrop').remove();


                        // form[0].reset();
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
            $('#info_responsable').text('Responsable: ' + nombreResp);
        });


    });
</script>
