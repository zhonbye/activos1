<div class="table-responsive bg-dark" style="max-height: 60vh; overflow-y: auto;">
    <table class="table table-striped table-bordered table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>ID Activo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th class="text-center">Cantidad</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->activo->id_activo ?? 'N/A' }}</td>
                    <td>{{ $detalle->activo->nombre ?? 'N/A' }}</td>
                    <td>{{ $detalle->activo->descripcion ?? 'N/A' }}</td>
                    <td>{{ $detalle->activo->estado ?? 'N/A' }}</td>
                    <td class="text-center">{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->observaciones }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No se encontraron activos para este inventario.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($detalles->hasPages())
    <nav class="mt-2">
        <ul class="pagination pagination-sm justify-content-center mb-0">
            @if ($detalles->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $detalles->previousPageUrl() }}">«</a></li>
            @endif

            @foreach ($detalles->links()->elements[0] as $page => $url)
                @if ($page == $detalles->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($detalles->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $detalles->nextPageUrl() }}">»</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">»</span></li>
            @endif
        </ul>
    </nav>
@endif
