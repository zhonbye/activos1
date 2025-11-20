<div class="table-responsive" style="max-height: 80vh; overflow-y: auto;">
    <table class="table table-striped table-hover mb-0 rounded">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Lugar</th>
                <th>Contacto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->lugar }}</td>
                    <td>{{ $proveedor->contacto }}</td>
                    <td>
                        <!-- Botón de acción: editar -->
                        <button class="btn btn-outline-primary btn-sm" data-id="{{ $proveedor->id_proveedor }}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay proveedores para mostrar</td>
                </tr>
            @endforelse

            @for ($i = 1; $i <= 20; $i++)
            <tr>
                    <td>Col {{ $i }}</td>
                </tr>
                @endfor

        </tbody>
    </table>
</div>

<!-- Paginación automática con Bootstrap 5 -->
<div class="mt-3 flex-shrink-0 bg-da3nger">
    {{ $proveedores->links('pagination::bootstrap-5') }}
</div>
