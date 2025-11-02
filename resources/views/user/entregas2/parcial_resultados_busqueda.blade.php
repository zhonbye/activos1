<div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Número</th>
                <th>Gestión</th>
                <th>Fecha</th>
                <th>Servicio de destino</th>
                <th>Observaciones</th>
                <th>Estado</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entregas as $t)
                <tr>
                    <td>{{ $t->id_entrega }}</td>
                    <td>{{ $t->numero_documento }}</td>
                    <td>{{ $t->gestion }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $t->servicio->nombre ?? 'N/D' }}</td>
                    <td>{{ $t->observaciones }}</td>
                    <td>
                        <span class="badge p-2 {{ $t->estado == 'finalizado' ? 'bg-danger' : 'bg-success' }}">
                            {{ ucfirst($t->estado) }}
                        </span>
                    </td>

                    <td>
                        <button type="button" id="seleccionar_entrega" class="btn btn-sm btn-primary btn-seleccionar-entrega"
                                data-id="{{ $t->id_entrega }}">
                            Seleccionar
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No se encontraron entregas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
