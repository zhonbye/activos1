<div class="table-responsive" style="max-height: 80vh; overflow-y: auto;">
    <table class="table table-striped table-hover mb-0 rounded" data-id-donantes="{{$donaciones[0]->id_donantes ?? ''}}">
        <thead class="table-light">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Fecha Adquisición</th>
                <th>Donante</th>
                <th>Estado</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donaciones as $donacion)
                <tr>
                    <td>{{ $donacion->codigo }}</td>
                    <td>{{ $donacion->nombre }}</td>
                    <td>{{ $donacion->detalle }}</td>
                    <td>{{ $donacion->fecha }}</td>
                    <td>{{ $donacion->donante->nombre }}</td>
                   <td>
    @if ($donacion->estado_situacional === 'inactivo')
        <span class="badge bg-success">Libre</span>
    @elseif ($donacion->estado_situacional === 'activo')
        <span class="badge bg-danger">En uso</span>
    @else
        <span class="badge bg-secondary">{{ $donacion->estado_situacional }}</span>
    @endif
</td>

                    <td>{{ $donacion->precio }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary ver-activo-btn"
                                title="Ver detalles del activo"
                                data-bs-toggle="modal"
                                data-bs-target="#modalVisualizar2"
                                data-id="{{ $donacion->id_activo }}"
                                data-id-adquisicion="{{ $donacion->id_adquisicion }}">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>


                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No se encontraron donaciones</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3 flex-shrink-0 bg-da3nger">
    {{ $donaciones->links('pagination::bootstrap-5')}}
</div>

<div class="modal fade" id="modalVisualizar2" tabindex="-1" aria-labelledby="modalVisualizarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalVisualizarLabel">Detalle Completo del Activo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Contenido cargado por AJAX -->
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>
