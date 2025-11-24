<form method="POST" id="form_baja" action="{{ route('bajas.store') }}">
    @csrf
    <input type="hidden" name="id_activo" id="id_activo" value="{{ $activo->id_activo }}">
    <input type="hidden" name="id_servicio" id="id_servicio" value="{{ $id_servicio }}">
    <input type="hidden" name="id_usuario" value="{{ Auth::id() }}">
    <input type="hidden" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">

    <div class="row g-3 mb-3 p-3 rounded" style="background-color: #f0f4f8;">
        <div class="d-flex align-items-start mb-3">
            <!-- Icono grande -->
            <div class="me-3 text-center" style="width: 80px;">
                <i class="bi bi-box-seam fs-1 text-primary"></i>
            </div>

            <!-- Detalles del activo -->
            <div class="flex-grow-1">
                <p class="mb-1 fw-bold" id="activo_texto">{{ $activo->nombre }} - {{ $activo->detalle }}</p>
                <p class="mb-1 text-secondary" id="servicio_texto">Servicio: {{ $servicio->nombre ?? '' }}</p>
                <small class="text-muted text-danger">Este activo será retirado del inventario y no estará disponible para nuevas entregas.</small>
            </div>
        </div>

        <!-- Responsable -->
        <div class="col-md-6">
            <label class="form-label fw-bold text-danger">Responsable que dará de baja</label>
            <select class="form-select" name="id_responsable" id="id_responsable" required>
                <option value="" disabled>Seleccione responsable</option>
                @foreach ($responsables as $responsable)
                    <option value="{{ $responsable->id_responsable }}" 
                        {{ $responsable->id_responsable == $responsable_id ? 'selected' : '' }}>
                        {{ $responsable->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Motivo -->
        <div class="col-md-6">
            <label class="form-label">Motivo</label>
            <input type="text" class="form-control" name="motivo" id="motivo" placeholder="Ej: Deterioro, obsolescencia" required>
        </div>

        <!-- Observaciones -->
        <div class="col-12">
            <label class="form-label">Observaciones</label>
            <input type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Opcional">
        </div>
    </div>
    <div class="modal-footer border-0 justify-content-center">
                <button type="submit" form="form_baja" class="btn btn-danger d-flex align-items-center">
                    <i class="bi bi-check2-circle me-2"></i> Confirmar Baja
                </button>
            </div>
</form>
<script>
    $(document).off('submit', '#form_baja').on('submit', '#form_baja', function(e){
    e.preventDefault(); // evitar envío normal

    Swal.fire({
        title: '¿Confirmar baja del activo?',
        text: "El activo será retirado del inventario y no estará disponible para nuevas entregas.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, dar de baja',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if(result.isConfirmed){
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Baja registrada',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    });
                     
            $('#modalDarBaja button[data-bs-dismiss="modal"]').trigger('click');
              $('#contenedorResultadosInventarios table button.btn.ver-detalles-btn.active').removeClass('active').trigger('click');
          
                    // Opcional: refrescar tabla o actualizar lista de activos
                    // $('#tabla_activos').DataTable().ajax.reload();
                },
                error: function(xhr){
                    let mensaje = 'Ocurrió un error al dar de baja el activo.';
                    if(xhr.responseJSON && xhr.responseJSON.error){
                        mensaje = xhr.responseJSON.error;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje,
                        confirmButtonColor: '#d33'
                    });
                }
            });
        }
    });
});

</script>