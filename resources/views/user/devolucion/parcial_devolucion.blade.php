<!-- Modal para editar acta de traslado -->
<div class="modal fade" id="modalEditarTraslado" tabindex="-1" aria-labelledby="modalEditarTrasladoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalEditarTrasladoLabel">Editar Acta de Traslado</h5>
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
    <h5>Detalles de la devolución</h5>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0" id="numero_devolucion">
                Nro. {{ $devolucion->numero_documento ?? '...' }}
            </h5>

            <div>
                <span class="badge bg-light text-dark me-2" id="gestion_devolucion">
                    {{ $devolucion->gestion ?? date('Y') }}
                </span>

                <span class="badge {{ $devolucion->estado == 'finalizado' ? 'bg-danger' : 'bg-success' }} me-2"
                    data-estado-devolucion="{{ $devolucion->estado }}"
                    id="estado_devolucion">
                    {{ $devolucion->estado ?? 'pendiente' }}
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
                    <input type="hidden" name="id_devolucion" id="id_devolucion"
                        value="{{ $devolucion->id_devolucion }}">

                    {{-- Servicio + Responsable --}}
                    <div class="col-12 col-md-6">
                        <div class="border p-2 rounded h-100">
                            <strong>Servicio</strong><br>
                            <span id="servicio_responsable"
                                data-nombre="{{ $devolucion->servicio->nombre ?? 'N/D' }}">
                                {{ $devolucion->servicio->nombre ?? 'N/D' }}
                                -
                                {{ $devolucion->responsable->nombre ?? 'N/D' }}
                            </span>
                            <input type="hidden" id="id_servicio"
                                value="{{ $devolucion->id_servicio ?? '' }}">
                            <input type="hidden" id="id_responsable"
                                value="{{ $devolucion->id_responsable ?? '' }}">
                        </div>
                    </div>

                    {{-- Fecha --}}
                    <div class="col-12 col-md-3">
                        <div class="border p-2 rounded text-center h-100">
                            <strong>Fecha</strong><br>
                            <span id="fecha_devolucion">{{ $devolucion->fecha ?? '...' }}</span>
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-12">
                        <div class="border p-2 rounded text-start h-100" style="word-wrap: break-word;">
                            <strong>Observaciones</strong><br>
                            <span id="observaciones_devolucion">
                                {{ $devolucion->observaciones ?: '— No se registraron observaciones —' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                @if ($devolucion->estado === 'finalizado')
                    <button class="btn btn-sm btn-outline-secondary" disabled
                        title="No se puede editar una devolución finalizada">
                        No se puede editar
                    </button>
                @else
                    <button class="btn btn-sm btn-outline-primary me-2" id="btn_editar_devolucion"
                        data-id="{{ $devolucion->id_devolucion }}">Editar</button>
                    <button class="btn btn-sm btn-outline-success" id="recargar_devolucion">Recargar</button>
                @endif
            </div>

            @if ($devolucion->estado === 'finalizado')
                <div class="alert alert-danger p-2 m-0 w-100 text-center" role="alert">
                    ⚠ No puede modificar una devolución finalizada.
                </div>
            @endif
        </div>
    </div>
</div>


<script>
    // function cargarDetalleTraslado(traslado_id = null) {
    //     // Toma el ID del input si no se pasa
    //     if (!traslado_id) traslado_id = $('#btn_editar_traslado').data('id');

    //     if (!traslado_id) {
    //         mensaje('No se encontró el ID del traslado', 'danger');
    //         return;
    //     }

    //     // AJAX GET para traer la vista parcial
    //     $.ajax({
    //         url: `${baseUrl}/traslados/${traslado_id}/detalle`,
    //         type: 'GET',
    //         success: function(data) {
    //             $('#contenedor_detalle_traslado').html(data);
    //         },
    //         error: function(xhr) {
    //             // Si el controlador devuelve JSON con error
    //             if (xhr.responseJSON && xhr.responseJSON.message) {
    //                 mensaje(xhr.responseJSON.message, 'danger');
    //             } else {
    //                 mensaje('Ocurrió un error inesperado.', 'danger');
    //             }
    //         }
    //     });
    // }
    $('#recargar_traslado').click(function() {
        // alert(idTraslado)
        // alert("fdsaf")
        cargarDetalleTraslado($('#btn_editar_traslado').data('id'))
    });

    $('#btn_editar_traslado').click(function() {
        // $(document).on('click', '#btn_editar_traslado', function() {
        var idTraslado = $(this).data('id'); // Debes tener un botón con data-id del traslado
        var url = baseUrl + '/traslados/' + idTraslado + '/editar';
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#modalEditarTraslado .modal-body').html(data);

                // Crear instancia de modal y mostrarlo
                const modal = new bootstrap.Modal(document.getElementById('modalEditarTraslado'));
                modal.show();

                // Guardar la instancia en el modal para poder cerrarlo desde dentro del contenido
                $('#modalEditarTraslado').data('bs.modal', modal);
            },
            error: function() {
                alert('No se pudo cargar la información del traslado.');
            }
        });
    });
</script>
