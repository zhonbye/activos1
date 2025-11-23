<div class="table-responsive" style="max-height: 80vh; overflow-y: auto;">
    <table class="table table-striped table-hover mb-0 rounded">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Contacto</th>
                <th>Fecha de ingreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donantes as $donante)
                <tr>
                    <td class="nombre">{{ $donante->nombre }}</td>
                    <td class="tipo">{{ $donante->tipo }}</td>
                    <td class="contacto">{{ $donante->contacto }}</td>
                 <td class="fecha">{{ optional($donante->created_at)->format('Y-m-d') }}</td>


                    <td>
                        <!-- Botón de acción: editar -->

                        <button class="btn btn-outline-primary  btn-sm btnEditarDonante" data-id="{{ $donante->id_donante }}"
                            title="Ver detalles del activo"

                            data-bs-toggle="modal"
                            data-bs-target="#modalEditarDonante">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm btnVerDonaciones"
                        title="Ver donaciones"
                         data-id="{{ $donante->id_donante }}">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay donantes para mostrar</td>
                </tr>
            @endforelse

            {{-- @for ($i = 1; $i <= 20; $i++)
            <tr>
                    <td>Col {{ $i }}</td>
                </tr>
                @endfor --}}

        </tbody>
    </table>
</div>

<!-- Paginación automática con Bootstrap 5 -->
<div class="mt-3 flex-shrink-0 bg-da3nger">
    {{ $donantes->links('pagination::bootstrap-5') }}
</div>
