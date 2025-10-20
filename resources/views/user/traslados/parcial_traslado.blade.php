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




<div class="col-12 mt-0" id="div_traslado">
    <h5>Detalles del traslado</h5>
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0" id="numero_traslado">Nro. {{ $traslado->numero_documento ?? '...' }}</h5>
            <div>
                <span class="badge bg-light text-dark me-2"
                    id="gestion_traslado">{{ $traslado->gestion ?? date('Y') }}</span>
                <span class="badge {{ $traslado->estado == 'finalizado' ? 'bg-danger' : 'bg-success' }} me-2" data-estado-traslado="{{ $traslado->estado}}"
                    id="estado_traslado">
                    {{ $traslado->estado ?? 'pendiente' }}
                </span>
                <!-- Botón de colapsar -->
                {{-- <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#cardBodyTraslado" aria-expanded="false" aria-controls="cardBodyTraslado">
                    ⮟
                </button> --}}
                <!-- Card body colapsable -->
                {{--
    <div class="card-body">
        Contenido del card body aquí.
    </div>
</div> --}}

                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#cardBodyTraslado" aria-expanded="true" aria-controls="cardBodyTraslado">
                    ⮟
                </button>
            </div>
        </div>

        <div id="cardBodyTraslado" class="collapse show">
        {{-- <div id="cardBodyTraslado" class="show "> --}}
            <div class="card-body">
                <div class="row g-3">
                    <input type="hidden" name="id_traslado" value="{{ $traslado->id_traslado }}">
                    {{-- Origen --}}
                    <div class="col-12 col-md-4">
                        <div class="border p-2 rounded h-100">
                            <strong>Origen</strong><br>
                            <span id="servicio_responsable_origen"
                                data-nombre=" {{ $traslado->servicioOrigen->nombre ?? 'N/D' }}">
                                {{ $traslado->servicioOrigen->nombre ?? 'N/D' }} -
                                {{ $traslado->servicioOrigen->responsable->nombre ?? 'N/D' }}
                            </span>
                            <input type="hidden" id="id_servicio_origen"
                                value="{{ $traslado->id_servicio_origen ?? '' }}">
                            <input type="hidden" id="id_responsable_origen"
                                value="{{ $traslado->servicioOrigen->responsable->nombre ?? '' }}">
                        </div>
                    </div>

                    {{-- Destino --}}
                    <div class="col-12 col-md-5">
                        <div class="border p-2 rounded h-100">
                            <strong>Destino</strong><br>
                            <span id="servicio_responsable_destino">
                                {{ $traslado->servicioDestino->nombre ?? 'N/D' }} -
                                {{ $traslado->servicioDestino->responsable->nombre ?? 'N/D' }}
                            </span>
                            <input type="hidden" id="id_servicio_destino"
                                value="{{ $traslado->id_servicio_destino ?? '' }}">
                            <input type="hidden" id="id_responsable_destino"
                                value="{{ $traslado->servicioDestino->responsable->nombre ?? '' }}">
                        </div>
                    </div>

                    {{-- Fecha --}}
                    <div class="col-6 col-md-3">
                        <div class="border p-2 rounded text-center h-100">
                            <strong>Fecha</strong><br>
                            <span id="fecha_traslado">{{ $traslado->fecha ?? '...' }}</span>
                        </div>
                    </div>

                    {{-- Observaciones (ocupa todo el ancho restante y permite varias filas) --}}
                    <div class="col-12">
                        <div class="border p-2 rounded text-start h-100" style=" word-wrap: break-word;">
                            <strong>Observaciones</strong><br>
                            <span id="observaciones_traslado">{{ $traslado->observaciones ?? 'N/D' }}</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                @if ($traslado->estado === 'finalizado')
                    <button class="btn btn-sm btn-outline-secondary" disabled
                        title="No se puede editar un traslado finalizado">
                        No se puede editar
                    </button>
                @else
                    <button class="btn btn-sm btn-outline-primary me-2" id="btn_editar_traslado"
                        data-id="{{ $traslado->id_traslado }}">Editar</button>
                    <button class="btn btn-sm btn-outline-success" id="recargar_traslado">Recargar</button>
                @endif
            </div>
            @if ($traslado->estado === 'finalizado')
                <div class="alert alert-danger p-2 m-0 w-100 text-center" role="alert">
                    ⚠ No puede modificar un traslado finalizado.
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
