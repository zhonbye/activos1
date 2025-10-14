{{-- <div class="table-responsive" style="max-height: 60vh; overflow-y: auto;"> --}}
<div style="max-height:80vh; height: 80vh;overflow-y: auto;">
    <table class="table table-striped mb-0 rounded">
        <thead class="table-light">
            <tr>
                <th>Número</th>
                <th>Servicio</th>
                <th>Responsable</th>
                <th>Observaciones</th>
                <th>Fecha</th>
                <th class="text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($inventarios as $item)
                    <tr>
                        <td>{{ $item->numero_documento }}</td>
                        <td>{{ $item->servicio->nombre ?? 'N/A' }}</td>
                        <td>{{ $item->responsable->nombre ?? 'N/A' }}</td>
                        <td>{{ $item->observaciones }}</td>
                        <td>{{ $item->fecha }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary visualizar-btn"
                                data-id="{{ $item->id_inventario }}" title="Visualizar">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron resultados.</td>
                    </tr>
                @endforelse
            </tbody>
    </table>

</div>

@if ($inventarios->hasPages())
    <nav class="mt-2 bg-dark bg-opacity-10 rounded">
        <ul class="pagination pagination-sm justify-content-center mb-0">
            {{-- Link a página anterior --}}
            @if ($inventarios->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Anterior">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $inventarios->previousPageUrl() }}" rel="prev"
                        aria-label="Anterior">&laquo;</a>
                </li>
            @endif

            {{-- Links de páginas --}}
            @foreach ($inventarios->links()->elements[0] as $page => $url)
                @if ($page == $inventarios->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            {{-- Link a página siguiente --}}
            @if ($inventarios->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $inventarios->nextPageUrl() }}" rel="next"
                        aria-label="Siguiente">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Siguiente">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

