<div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Categoría</th>
                <th>Estado Actual</th> <!-- Estado actual del detalle_inventario -->
                <th>Cantidad</th>
                <th>Agregar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detalles as $detalle)
                <tr>
                    <td>{{ $detalle->activo->codigo ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->nombre ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->detalle ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->categoria->nombre ?? 'N/D' }}</td>
                    <td>{{ $detalle->estado_actual ?? 'N/D' }}</td> <!-- Aquí -->
                    <td>{{ $detalle->cantidad }}</td>
                    <td>
                        <button type="button"
                            class="btn btn-sm btn-primary btn_agregar_activo"
                            data-id="{{ $detalle->activo->id_activo ?? '' }}">
                            Agregar
                        </button>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No se encontraron activos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
