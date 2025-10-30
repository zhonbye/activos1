<div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Número</th>
                <th>Gestión</th>
                <th>Fecha</th>
                <th>Servicio</th>
                <th>Observaciones</th>
                <th>Estado</th>
                <th>Seleccionar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($devoluciones as $d)
                <tr>
                    <td>{{ $d->id_devolucion }}</td>
                    <td>{{ $d->numero_documento }}</td>
                    <td>{{ $d->gestion }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $d->servicio->nombre ?? 'N/D' }}</td>
                    <td>{{ $d->observaciones }}</td>
                    <td>
                        <span class="badge p-2 {{ $d->estado == 'finalizado' ? 'bg-danger' : 'bg-success' }}">
                            {{ ucfirst($d->estado) }}
                        </span>
                    </td>
                    <td>
                        <button type="button" id="seleccionar_devolucion" 
                                class="btn btn-sm btn-primary btn-seleccionar-devolucion"
                                data-id="{{ $d->id_devolucion }}">
                            Seleccionar
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No se encontraron devoluciones.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
