




<div class="col-12 mt-0" id="div_entrega">
    <h5>Detalles de la entrega</h5>
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold" id="numero_entrega">Nro. {{ $entrega->numero_documento ?? '...' }}</h5>
            <div>
                <span class="badge bg-light text-dark me-2"
                    id="gestion_entrega">{{ $entrega->gestion ?? date('Y') }}</span>
                <span class="badge {{ $entrega?->estado == 'finalizado' ? 'bg-danger' : 'bg-success' }} me-2"
                    data-estado-entrega="{{ $entrega->estado }}" id="estado_entrega">
                    {{ $entrega->estado ?? 'pendiente' }}
                </span>


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
                    <input type="hidden" name="id_entrega" id="id_entrega" value="{{ $entrega->id_entrega }}">
                    {{-- Origen --}}


                    {{-- Destino --}}
                    <div class="col-12 col-md-6">
                        <div class="border p-2 rounded h-100 d-flex">
                            <div class="me-2">
                                <strong class="text-nowrap">Destino:</strong>
                            </div>
                            <div>
                                <div>
                                    <small class="text-muted">Servicio:</small>
                                    <span id="nombre_servicio_destino" class="text-dark fw-semibold">
                                        {{ $entrega->servicio->nombre ?? 'N/D' }}
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted">Responsable:</small>
                                    <span id="nombre_responsable_destino" class="text-dark">
                                        {{ $entrega->servicio->responsable->nombre ?? 'N/D' }}
                                    </span>
                                </div>
                            </div>

                            <input type="hidden" id="id_servicio_destino"
                                value="{{ $entrega->id_servicio_destino ?? '' }}">
                            <input type="hidden" id="id_responsable_destino"
                                value="{{ $entrega->servicioDestino->responsable->id ?? '' }}">
                        </div>
                    </div>



                    {{-- Fecha --}}
                    <div class="col-6 col-md-3">
                        <div class="border p-2 rounded text-center h-100">
                            <strong>Fecha</strong><br>
                            <span id="fecha_entrega">{{ $entrega->fecha ?? '...' }}</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="border p-2 rounded text-center h-100">
                            <strong>Creada por</strong><br>
                            <span id="usuarioEntrega">{{ $entrega->usuario->usuario}}</span>
                         <small class="text-muted d-block">
            {{ ucfirst($entrega->usuario->rol ?? 'Sin rol') }}
        </small>
                        </div>

                    </div>


                    {{-- Observaciones (ocupa todo el ancho restante y permite varias filas) --}}
                    <div class="col-12">
                        <div class="border p-2 rounded text-start h-100" style=" word-wrap: break-word;">
                            <strong>Comentarios</strong><br>
                            <span id="observaciones_entrega">
                                {{ $entrega->observaciones ?: '——' }}
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
                        data-id="{{ $entrega->id_entrega }}"  data-bs-toggle="modal"
                        data-bs-target="#modalEditarEntrega">Editar</button>
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
    $('#recargar_entrega').click(function() {
        // alert(idEntrega)
        // alert("fdsaf")
        cargarDetalleEntrega($('#btn_editar_entrega').data('id'))
    });

</script>
