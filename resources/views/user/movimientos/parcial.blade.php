<div style="height: 70vh; max-height: 70vh; overflow-y: auto; overflow-x: hidden; position: relative;">
    <table class="table table-striped mb-0 rounded">
        <thead class="table-light">
            <tr>
                <th>N° Documento</th>
                <th>Gestión</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Responsable / Servicio</th>
                <th>Observaciones</th>
                <th>Estado</th>
                <th>Creado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($inventarios as $acta)
                <tr>
                    <td>{{ $acta->numero_documento }}</td>
                    <td>{{ $acta->gestion }}</td>
                    <td>{{ \Carbon\Carbon::parse($acta->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $acta->usuario->usuario ?? 'N/A' }}</td>
                    <td>
                        @if(isset($acta->responsable->nombre))
                            {{ $acta->responsable->nombre }}
                        @elseif(isset($acta->servicio_origen))
                            Origen: {{ $acta->servicio_origen->nombre ?? '-' }} <br>
                            Destino: {{ $acta->servicio_destino->nombre ?? '-' }}
                        @else
                            {{ $acta->servicio->nombre ?? '-' }}
                        @endif
                    </td>
                    <td>{{ $acta->observaciones ?? '-' }}</td>
                    <td>{{ ucfirst($acta->estado) ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($acta->created_at)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-dark ver-detalles-btn"
                                data-id_acta="{{ $acta->id ?? $acta->id_entrega ?? $acta->id_devolucion ?? $acta->id_traslado }}"
                                title="Ver detalles">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No se encontraron actas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $inventarios->links('pagination::bootstrap-5') }}
</div>
