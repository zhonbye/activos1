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

                    {{-- Número de Traslado --}}
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted">Número de Traslado</small>
                        <input type="text" class="form-control" name="numero_documento"
                               value="{{ $traslado->numero_documento ?? '' }}" required>
                    </div>

                    {{-- Gestión --}}
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted">Gestión</small>
                        <input type="number" class="form-control" name="gestion"
                               value="{{ $traslado->gestion ?? date('Y') }}">
                    </div>

                    {{-- Fecha --}}
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted">Fecha</small>
                        <input type="date" class="form-control" name="fecha"
                               value="{{ $traslado->fecha ?? date('Y-m-d') }}">
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted">Observaciones</small>
                        <input type="text" class="form-control" name="observaciones"
                               value="{{ $traslado->observaciones ?? '' }}">
                    </div>

                    {{-- Servicio Origen --}}
                  {{-- Servicio Origen --}}
<div class="col-md-6 col-sm-6">
    <small class="text-muted">Servicio Origen</small>
    <select name="id_servicio_origen" class="form-select">
        <option selected disabled>Seleccione...</option>
        @foreach($servicios as $serv)
            <option value="{{ $serv->id_servicio }}"
                {{ (isset($traslado->servicioOrigen) && $traslado->servicioOrigen->id_servicio == $serv->id_servicio) ? 'selected' : '' }}>
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
        @foreach($servicios as $serv)
            <option value="{{ $serv->id_servicio }}"
                {{ (isset($traslado->servicioDestino) && $traslado->servicioDestino->id_servicio == $serv->id_servicio) ? 'selected' : '' }}>
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
   
   $('#guardarCambiosTraslado').on('click', function(e) {
    e.preventDefault();

    let idTraslado = $('input[name="id_traslado"]').val();
    let $form = $('#formEditarTraslado'); // jQuery
let form = $form[0]; // HTMLFormElement

if (!form.checkValidity()) {
    form.reportValidity();
    return;
}
 if (!confirm('¿Está seguro que desea guardar los cambios en este activo?')) return;

    $.ajax({
        url: baseUrl + '/traslados/' + idTraslado + '/update',
        type: 'PUT',
            data: $form.serialize(),
        success: function(response) {
            if(response.success){
                mensaje(response.message || 'Traslado actualizado correctamente', 'success');

          const modal = $('#modalEditarTraslado').data('bs.modal');
    modal.hide();

//  $('#modalEditarTraslado').hide();
            } else {
                // Mostrar errores específicos devueltos por el controlador
                if(response.errors){
                    for(let campo in response.errors){
                        mensaje(response.errors[campo][0], 'danger');
                    }
                } else if(response.message){
                    mensaje(response.message, 'danger');
                }
            }
        },
        error: function(xhr){
            // Errores HTTP no esperados
            let errorMsg = 'Ocurrió un error inesperado.';
            if(xhr.responseJSON && xhr.responseJSON.message){
                errorMsg = xhr.responseJSON.message;
            }
            mensaje(errorMsg, 'danger');
            console.log(xhr.responseText);
        }
    });
});

   
   
   
        // });

</script>
