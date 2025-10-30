<!-- Modal para editar acta de traslado -->
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
                    data-estado-devolucion="{{ $devolucion->estado }}" id="estado_devolucion">
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
                            <span id="servicio_responsable" data-nombre="{{ $devolucion->servicio->nombre ?? 'N/D' }}">
                                {{ $devolucion->servicio->nombre ?? 'N/D' }}
                                -
                                {{ $devolucion->responsable->nombre ?? 'N/D' }}
                            </span>
                            <input type="hidden" id="id_servicio" value="{{ $devolucion->id_servicio ?? '' }}">
                            <input type="hidden" id="id_responsable" value="{{ $devolucion->id_responsable ?? '' }}">
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
    $('#recargar_devolucion').click(function() {
        // Recargar los detalles de la devolución actual
        cargarDetalleDevolucion($('#btn_editar_devolucion').data('id'));
    });

    $('#btn_editar_devolucion').click(function() {
        var idDevolucion = $(this).data('id'); // El botón debe tener data-id con el id de la devolución
        var url = baseUrl + '/devolucion/' + idDevolucion + '/editar';


        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#modalEditarDevolucion .modal-body').html(data);

                // Crear instancia del modal y mostrarlo
                const modal = new bootstrap.Modal(document.getElementById('modalEditarDevolucion'));
                modal.show();

                // Guardar la instancia para poder cerrarla luego
                $('#modalEditarDevolucion').data('bs.modal', modal);
            },
           error: function(xhr) {
            console.log('XHR object:', xhr); // Muestra todo el objeto
            console.log('Response Text:', xhr.responseText); // Ver el HTML o mensaje de error
            if (xhr.responseJSON && xhr.responseJSON.message) {
                alert('Error: ' + xhr.responseJSON.message);
            } else {
                alert('No se pudo cargar la información de la devolución. Revisa la consola.');
            }
        }
        });


    });
</script>
