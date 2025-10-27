<div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Número</th>
                <th>Gestión</th>
                <th>Fecha</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Observaciones</th>
                <th>Estado</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($traslados as $t)
                <tr>
                    <td>{{ $t->id_traslado }}</td>
                    <td>{{ $t->numero_documento }}</td>
                    <td>{{ $t->gestion }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $t->servicioOrigen->nombre ?? 'N/D' }}</td>
                    <td>{{ $t->servicioDestino->nombre ?? 'N/D' }}</td>
                    <td>{{ $t->observaciones }}</td>
                    <td>
                        <span class="badge p-2 {{ $t->estado == 'finalizado' ? 'bg-danger' : 'bg-success' }}">
                            {{ ucfirst($t->estado) }}
                        </span>
                    </td>

                    <td>
                        <button type="button" id="seleccionar_traslado" class="btn btn-sm btn-primary btn-seleccionar-traslado"
                                data-id="{{ $t->id_traslado }}">
                            Seleccionar
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No se encontraron traslados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
