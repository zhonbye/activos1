<!-- Modal para editar acta de entrega -->
<div class="modal fade" id="modalEditarEntrega" tabindex="-1" aria-labelledby="modalEditarEntregaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalEditarEntregaLabel">Editar Acta de Entrega</h5>
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




<div class="col-12 mt-0" id="div_entrega">
    <h5>Detalles del entrega</h5>
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0" id="numero_entrega">Nro. {{ $entrega->numero_documento ?? '...' }}</h5>
            <div>
                <span class="badge bg-light text-dark me-2"
                    id="gestion_entrega">{{ $entrega->gestion ?? date('Y') }}</span>
                <span class="badge {{ $entrega->estado == 'finalizado' ? 'bg-danger' : 'bg-success' }} me-2" data-estado-entrega="{{ $entrega->estado}}"
                    id="estado_entrega">
                    {{ $entrega->estado ?? 'pendiente' }}
                </span>
                <!-- Botón de colapsar -->
                {{-- <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#cardBodyEntrega" aria-expanded="false" aria-controls="cardBodyEntrega">
                    ⮟
                </button> --}}
                <!-- Card body colapsable -->
                {{--
    <div class="card-body">
        Contenido del card body aquí.
    </div>
</div> --}}

                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#cardBodyEntrega" aria-expanded="true" aria-controls="cardBodyEntrega">
                    ⮟
                </button>
            </div>
        </div>

        <div id="cardBodyEntrega" class="collapse show">
        {{-- <div id="cardBodyEntrega" class="show "> --}}
            <div class="card-body">
                <div class="row g-3">
                    <input type="hidden" name="id_entrega"  id="id_entrega" value="{{ $entrega->id_entrega }}">
                    {{-- Origen --}}
                   

                    {{-- Destino --}}
                    <div class="col-12 col-md-5">
                        <div class="border p-2 rounded h-100">
                            <strong>Destino</strong><br>
                            <span id="servicio_responsable_destino">
                                {{ $entrega->servicioDestino->nombre ?? 'N/D' }} -
                                {{ $entrega->servicioDestino->responsable->nombre ?? 'N/D' }}
                            </span>
                            <input type="hidden" id="id_servicio_destino"
                                value="{{ $entrega->id_servicio_destino ?? '' }}">
                            <input type="hidden" id="id_responsable_destino"
                                value="{{ $entrega->servicioDestino->responsable->nombre ?? '' }}">
                        </div>
                    </div>

                    {{-- Fecha --}}
                    <div class="col-6 col-md-3">
                        <div class="border p-2 rounded text-center h-100">
                            <strong>Fecha</strong><br>
                            <span id="fecha_entrega">{{ $entrega->fecha ?? '...' }}</span>
                        </div>
                    </div>

                    {{-- Observaciones (ocupa todo el ancho restante y permite varias filas) --}}
                    <div class="col-12">
                        <div class="border p-2 rounded text-start h-100" style=" word-wrap: break-word;">
                            <strong>Observaciones</strong><br>
                            <span id="observaciones_entrega">
    {{ $entrega->observaciones ?: '— No se registraron observaciones —' }}
</span>

                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                @if ($entrega->estado === 'finalizado')
                    <button class="btn btn-sm btn-outline-secondary" disabled
                        title="No se puede editar un entrega finalizado">
                        No se puede editar
                    </button>
                @else
                    <button class="btn btn-sm btn-outline-primary me-2" id="btn_editar_entrega"
                        data-id="{{ $entrega->id_entrega }}">Editar</button>
                    <button class="btn btn-sm btn-outline-success" id="recargar_entrega">Recargar</button>
                @endif
            </div>
            @if ($entrega->estado === 'finalizado')
                <div class="alert alert-danger p-2 m-0 w-100 text-center" role="alert">
                    ⚠ No puede modificar un entrega finalizado.
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    // function cargarDetalleEntrega(entrega_id = null) {
    //     // Toma el ID del input si no se pasa
    //     if (!entrega_id) entrega_id = $('#btn_editar_entrega').data('id');

    //     if (!entrega_id) {
    //         mensaje('No se encontró el ID del entrega', 'danger');
    //         return;
    //     }

    //     // AJAX GET para traer la vista parcial
    //     $.ajax({
    //         url: `${baseUrl}/entregas/${entrega_id}/detalle`,
    //         type: 'GET',
    //         success: function(data) {
    //             $('#contenedor_detalle_entrega').html(data);
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
    $('#recargar_entrega').click(function() {
        // alert(idEntrega)
        // alert("fdsaf")
        cargarDetalleEntrega($('#btn_editar_entrega').data('id'))
    });

    $('#btn_editar_entrega').click(function() {
        // $(document).on('click', '#btn_editar_entrega', function() {
        var idEntrega = $(this).data('id'); // Debes tener un botón con data-id del entrega
        var url = baseUrl + '/entregas/' + idEntrega + '/editar';
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#modalEditarEntrega .modal-body').html(data);

                // Crear instancia de modal y mostrarlo
                const modal = new bootstrap.Modal(document.getElementById('modalEditarEntrega'));
                modal.show();

                // Guardar la instancia en el modal para poder cerrarlo desde dentro del contenido
                $('#modalEditarEntrega').data('bs.modal', modal);
            },
            error: function() {
                alert('No se pudo cargar la información del entrega.');
            }
        });
    });
</script>
