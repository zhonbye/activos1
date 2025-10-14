<div style="max-height:80vh; height: 80vh; overflow-y: auto;">
    <table class="table table-striped mb-0 rounded">
      
       <thead class="table-light">
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Detalle</th>
        <th>Categoría</th>
        <th>Unidad/Servicio</th>
        <th>Estado físico</th>
        <th>Fecha</th> <!-- Nueva columna -->
        <th class="text-center">Acciones</th>
    </tr>
</thead>

<tbody>
    @forelse ($activos as $activo)
        <tr  data-id="{{ $activo->id_activo }}" >
            <td>{{ $activo->codigo }}</td>
            <td>{{ $activo->nombre }}</td>
            <td>{{ $activo->detalle }}</td>
            <td>{{ $activo->categoria->nombre ?? 'N/A' }}</td>
            <td>{{ $activo->unidad->nombre ?? 'N/A' }}</td>
            <td>{{ $activo->estado->nombre ?? 'N/A' }}</td>
            <td>{{ $activo->created_at->format('d/m/Y') }}</td> <!-- Mostrar fecha -->
            <td class="text-center">
                <button class="btn btn-sm btn-outline-warning editar-btn"  data-id="{{ $activo->id_activo }}" title="Editar">
                    <i class="bi bi-pencil"></i>
                </button>
                {{-- <button class="btn btn-sm btn-outline-danger dar-baja-btn" data-id="{{ $activo->id_activo }}" title="Dar de baja">
                    <i class="bi bi-trash"></i>
                </button> --}}
                <button class="btn btn-sm btn-outline-primary visualizar-btn" data-id="{{ $activo->id_activo }}" title="Visualizar">
                    <i class="bi bi-eye"></i>
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">No se encontraron resultados.</td>
        </tr>
    @endforelse
</tbody>

    </table>
</div>

@if ($activos->hasPages())
    <nav class="mt-2 bg-dark bg-opacity-10 rounded">
        <ul class="pagination pagination-sm justify-content-center mb-0">
            {{-- Página anterior --}}
            @if ($activos->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $activos->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            {{-- Links de páginas --}}
            @foreach ($activos->links()->elements[0] as $page => $url)
                @if ($page == $activos->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            {{-- Página siguiente --}}
            @if ($activos->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $activos->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
