<!-- Modal para editar acta de devolucion -->
<div class="modal fade" id="modalEditarDevolucion" tabindex="-1" aria-labelledby="modalEditarDevolucionLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalEditarDevolucionLabel">Editar Acta de Devolucion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Aquí se cargará el formulario de edición vía AJAX o parcial -->
            </div>
            <div class="modal-footer">

                {{--
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cerrar</button> --}}
            </div>
        </div>
    </div>
</div>




<div class="col-12 mt-0" id="div_devolucion">
    <h5>Último Devolucion</h5>
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0" id="numero_devolucion">Nro. {{ $devolucion->numero_documento ?? '...' }}</h5>
            <div>
                <span class="badge bg-light text-dark me-2"
                    id="gestion_devolucion">{{ $devolucion->gestion ?? date('Y') }}</span>
                <span class="badge {{ $devolucion->estado == 'FINALIZADO' ? 'bg-danger' : 'bg-secondary' }} me-2"
                    id="estado_devolucion">
                    {{ $devolucion->estado ?? 'PENDIENTE' }}
                </span>
                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#cardBodyDevolucion" aria-expanded="true" aria-controls="cardBodyDevolucion">
                    ⮟
                </button>
            </div>
        </div>

        <div id="cardBodyDevolucion" class="collapse show">
            <div class="card-body">
                <div class="row g-3">
                    {{-- Origen --}}
                    <div class="col-12 col-md-4">
                        <div class="border p-2 rounded h-100">
                            <strong>Origen</strong><br>
                            <span id="servicio_responsable_origen">
                                {{ $devolucion->servicioOrigen->nombre ?? 'N/D' }} -
                                {{ $devolucion->servicioOrigen->responsable->nombre ?? 'N/D' }}
                            </span>
                            <input type="hidden" id="id_servicio_origen"
                                value="{{ $devolucion->id_servicio_origen ?? '' }}">
                            <input type="hidden" id="id_responsable_origen"
                                value="{{ $devolucion->servicioOrigen->responsable->nombre ?? '' }}">
                        </div>
                    </div>

                    {{-- Destino --}}
                    <div class="col-12 col-md-5">
                        <div class="border p-2 rounded h-100">
                            <strong>Destino</strong><br>
                            <span id="servicio_responsable_destino">
                                {{ $devolucion->servicioDestino->nombre ?? 'N/D' }} -
                                {{ $devolucion->servicioDestino->responsable->nombre ?? 'N/D' }}
                            </span>
                            <input type="hidden" id="id_servicio_destino"
                                value="{{ $devolucion->id_servicio_destino ?? '' }}">
                            <input type="hidden" id="id_responsable_destino"
                                value="{{ $devolucion->servicioDestino->responsable->nombre ?? '' }}">
                        </div>
                    </div>

                    {{-- Fecha --}}
                    <div class="col-6 col-md-3">
                        <div class="border p-2 rounded text-center h-100">
                            <strong>Fecha</strong><br>
                            <span id="fecha_devolucion">{{ $devolucion->fecha ?? '...' }}</span>
                        </div>
                    </div>

                    {{-- Observaciones (ocupa todo el ancho restante y permite varias filas) --}}
                    <div class="col-12">
                        <div class="border p-2 rounded text-start h-100" style=" word-wrap: break-word;">
                            <strong>Observaciones</strong><br>
                            <span id="observaciones_devolucion">{{ $devolucion->observaciones ?? 'N/D' }}</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button class="btn btn-sm btn-outline-primary me-2" id="btn_editar_devolucion"
                    data-id="{{ $devolucion->id_devolucion }}">Editar</button>
                <button class="btn btn-sm btn-outline-success" id="recargar_devolucion">Recargar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function cargarDetalleDevolucion(devolucion_id = null) {
        // Toma el ID del input si no se pasa
        if (!devolucion_id) devolucion_id = $('#btn_editar_devolucion').data('id');

        if (!devolucion_id) {
            mensaje('No se encontró el ID del devolucion', 'danger');
            return;
        }

        // AJAX GET para traer la vista parcial
        $.ajax({
            url: `${baseUrl}/devolucions/${devolucion_id}/detalle`,
            type: 'GET',
            success: function(data) {
                $('#contenedor_detalle_devolucion').html(data);
            },
            error: function(xhr) {
                // Si el controlador devuelve JSON con error
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje(xhr.responseJSON.message, 'danger');
                } else {
                    mensaje('Ocurrió un error inesperado.', 'danger');
                }
            }
        });
    }
    $('#recargar_devolucion').click(function() {
        // alert(idDevolucion)
        // alert("fdsaf")
        cargarDetalleDevolucion($('#btn_editar_devolucion').data('id'))
    });

    $('#btn_editar_devolucion').click(function() {
    // $(document).on('click', '#btn_editar_devolucion', function() {
        var idDevolucion = $(this).data('id'); // Debes tener un botón con data-id del devolucion
        var url = baseUrl + '/devolucions/' + idDevolucion + '/editar';
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
               $('#modalEditarDevolucion .modal-body').html(data);

            // Crear instancia de modal y mostrarlo
            const modal = new bootstrap.Modal(document.getElementById('modalEditarDevolucion'));
            modal.show();

            // Guardar la instancia en el modal para poder cerrarlo desde dentro del contenido
            $('#modalEditarDevolucion').data('bs.modal', modal);
            },
            error: function() {
                alert('No se pudo cargar la información del devolucion.');
            }
        });
    });
</script>
