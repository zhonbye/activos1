    <div style="height: 70vh; max-height: 70vh; overflow-y: auto; overflow-x: hidden; position: relative;">
        <table class="table table-striped mb-0 rounded">
            <thead class="table-light">
                <tr>
                    <th>N° Documento</th>
                    <th>Gestión</th>
                    <th>Fecha</th>
                    <th>Registrado por</th>
                    <th>Responsable</th>
                    <th>Servicio</th>
                    <th>
                        <div class="d-flex align-items-center">
                            <span>Estado</span>
                            <div class="dropdown">
                                <button class="btn btn-link text-primary p-0 ms-1" data-bs-toggle="dropdown">
                                    <i class="bi bi-info-lg"></i>
                                </button>
                                <ul class="dropdown-menu p-2" style="min-width:250px;">
                                    <li class="mb-1"><span class="badge bg-success me-2">&nbsp;</span>Vigente</li>
                                    <li class="mb-1"><span class="badge bg-secondary me-2">&nbsp;</span>Finalizado</li>
                                    <li><span class="badge bg-primary me-2">&nbsp;</span>Pendiente</li>
                                </ul>
                            </div>
                        </div>
                    </th>
                    <th>Total Activos</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($inventarios as $inv)
                    <tr>
                        <td>{{ $inv->numero_documento }}</td>
                        <td>{{ $inv->gestion }}</td>
                        <td>{{ \Carbon\Carbon::parse($inv->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $inv->usuario->usuario ?? 'N/A' }}</td>
                        <td>{{  ucfirst($inv->responsable->nombre ?? 'N/A') }}</td>
                        <td>{{  ucfirst( $inv->servicio->nombre ?? 'N/A') }}</td>
                        <td>
                            @php
                                $estadoClase = match($inv->estado) {
                                    'vigente' => 'bg-success',
                                    'finalizado' => 'bg-dark',
                                    'pendiente' => 'bg-primary',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $estadoClase }}" style="min-width:70px; display:inline-block; text-align:center;">
                                {{ ucfirst($inv->estado) }}
                            </span>
                        </td>
                       <td>{{ $inv->total_activos }}</td>

                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-dark ver-detalles-btn"
                                    data-id_inventario="{{ $inv->id_inventario }}"
                                    title="Ver detalles">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No se encontraron inventarios.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 flex-shrink-0 bg-da3nger">
        {{ $inventarios->links('pagination::bootstrap-5') }}
    </div>
