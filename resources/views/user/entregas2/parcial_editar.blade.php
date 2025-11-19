<form id="formEditarEntrega">
    @csrf
    <input type="hidden" id="entrega_id" name="id_entrega" value="{{ $entrega->id_entrega ?? '' }}">

    <div class="container-fluid py-3">

        {{-- ============================ --}}
        {{--  INFORMACIÓN GENERAL DEL TRASLADO --}}
        {{-- ============================ --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-dark text-white fw-bold fs-5">
                <i class="bi bi-card-text me-2"></i> Editar Acta de Entrega
            </div>
            <div class="card-body">
                <div class="row g-3">

                 

                    {{-- Número de Entrega, Gestión y Fecha --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Número de Entrega</small>
                        <div class="d-flex ">
                            <div class="input-group">
                                <input type="text" id="numerogeneradoedicion" class="form-control"
                                    {{-- aquí está la clase is-invalid para simular el error --}} name="numero_documento"
                                    value="{{ $entrega->numero_documento ?? '' }}" required style="min-width: 0;"
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
                            value="{{ $entrega->gestion ?? date('Y') }}">
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Fecha</small>
                        <input type="date" class="form-control" name="fecha"
                            value="{{ $entrega->fecha ?? date('Y-m-d') }}">
                    </div>
                    

             

                    {{-- Servicio Destino --}}
                    <div class="col-md-6 col-sm-6">
                        <small class="text-muted">Servicio Destino</small>
                        <select name="id_servicio_destino" class="form-select">
                            <option selected disabled>Seleccione...</option>
                            @foreach ($servicios as $serv)
                                <option value="{{ $serv->id_servicio }}"
                                    {{ isset($entrega->servicio) && $entrega->servicio->id_servicio == $serv->id_servicio ? 'selected' : '' }}>
                                    {{ $serv->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                       {{-- Observaciones (ocupa toda la fila) --}}
                    <div class="col-12">
                        <small class="text-muted">Comentarios</small>
                        <input type="text" class="form-control" name="observaciones"
                            value="{{ $entrega->observaciones ?? '' }}">
                    </div>

                </div>
            </div>
        </div>


        {{-- Botones dentro del formulario --}}
        {{-- <div class="modal-footer"> --}}
        <button type="button" class="btn btn-success" id="guardarCambiosEntrega">Guardar cambios</button>
        <button type="reset" class="btn btn-secondary" id="restablecerEntrega">Restablecer</button>
        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
        {{-- </div> --}}
    </div>
</form>

<script>
    // $(document).ready(function() {

    $('#generarNumero').on('click', function() {
        var gestion = $('#gestion').val().trim();
        // alert(gestion)
        if (gestion.length !== 4 || isNaN(gestion)) {
            mensaje('Debe ingresar una gestión válida de 4 dígitos.', 'warning');
            return;
        }
        $.ajax({
            url: baseUrl + '/entregas/generar-numero/' + gestion,
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
   $('#guardarCambiosEntrega').on('click', function() {
    if (!confirm('¿Está seguro que desea guardar los cambios en este entrega?')) return;

    var form = $('#modalEditarEntrega').find('form#formEditarEntrega');
    var idEntrega = form.find('input[name="id_entrega"]').val();


    // Función para guardar entrega
    function ActualizarEntrega() {
        $.ajax({
            url: baseUrl + '/entregas/' + idEntrega + '/update',
            type: 'PUT',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
            },
            success: function(response) {
                if (response.success) {
                    mensaje(response.message || 'Entrega actualizado correctamente', 'success');
                    bootstrap.Modal.getInstance($('#modalEditarEntrega')[0]).hide();
                    cargarDetalleEntrega(idEntrega);
                    cargarTablaActivos(idEntrega);
                } else {
                    mensaje(response.message || 'No se pudo actualizar el entrega.', 'danger');
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
                // const errorMsg = xhr.responseJSON?.message || 'Error inesperado al actualizar.';
                // mensaje(errorMsg, 'danger');
            }
        });
    }
ActualizarEntrega()
  
});






    // });
</script>
