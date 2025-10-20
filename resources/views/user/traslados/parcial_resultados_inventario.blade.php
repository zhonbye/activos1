<div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Categoría</th>
                <th>Estado Actual</th>
                <th>Cantidad</th>
                <th>Disponibilidad / Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detalles as $detalle)
                @php
                    $idActivo = $detalle->activo->id_activo ?? '';
                    $nombreActivo = $detalle->activo->nombre ?? '';
                    $estado = $detalle->estado_asignacion ?? '';
                    $trasladoInfo = $detalle->traslado_info ?? null;
                @endphp
                <tr data-id-activo="{{ $idActivo }}">
                    <td>{{ $detalle->activo->codigo ?? 'N/D' }}</td>
                    <td>{{ $nombreActivo }}</td>
                    <td>{{ $detalle->activo->detalle ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->categoria->nombre ?? 'N/D' }}</td>
                    <td>{{ $detalle->estado_actual ?? 'N/D' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>
                        <div class="d-flex align-items-center border p-2 rounded justify-content-between"
                           >
                            @if ($estado === 'Disponible')
                                <span class="text-success fw-semibold">Disponible</span>
                                <button class="btn btn-sm btn-outline-primary btn_agregar_activo"
                                    data-id="{{ $idActivo }}">Agregar</button>
                            @elseif(str_contains($estado, 'esta acta'))
                                <span class="text-primary fw-semibold">Añadido</span>
                                <button class="btn btn-sm btn-outline-danger btn-eliminar-activo"
                                    data-id-activo="{{ $idActivo }}"
                                    data-id-traslado="{{ $trasladoInfo['id_traslado'] ?? '' }}"
                                    data-acta="${numero}">Remover</button>
                            @elseif(str_contains($estado, 'otro acta'))
                                <span class="text-danger fw-semibold">Registrado en otra acta</span>
                                <!-- Toggle button nativo de Bootstrap -->
                                <button type="button" class="btn btn-sm btn-outline-info btn-ver-detalle"
                                    data-bs-toggle="button" data-nombre="{{ $nombreActivo }}"
                                    data-numero="{{ $trasladoInfo['numero'] ?? 'N/A' }}"
                                    data-id-activo="{{ $idActivo }}"
                                    data-id-traslado="{{ $trasladoInfo['id_traslado'] ?? '' }}">
                                    Más detalle
                                </button>
                            @endif
                        </div>
                        {{-- Div para detalles dinámicos --}}
                        {{-- <div class="detalle-activo mt-2" style="display:none; border:1px solid #ccc; padding:10px; border-radius:5px;"></div> --}}
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No se encontraron activos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('.detalle-activo:visible').each(function() {
            $(this).remove();
            // alert("div encotado")
        });

        $(document).off('click', '.btn-ver-detalle').on('click', '.btn-ver-detalle', function(e) {
            e.preventDefault();

            var $btn = $(this);
            var $td = $btn.closest('td');
            var $detalleDiv = $td.find('.detalle-activo');
            // alert($detalleDiv.length)
            // Si ya existe y está visible → ocultar
            if ($detalleDiv.length && $detalleDiv.is(':visible')) {
                // Quitar clase de toggle
                $btn.removeClass('active');

                // Opcional: animación de ocultar y luego eliminar
                $detalleDiv.slideUp(200, function() {
                    $(this).remove(); // elimina del DOM cuando termina la animación
                });

                return;
            }


            // Si no existe, crear o si existe pero está oculto → mostrar
            if ($detalleDiv.length === 0) {
                // alert("mostrando")
                $detalleDiv = $('<div class="detalle-activo mt-2 border p-2 rounded"></div>');
                $td.append($detalleDiv);
            }

            var nombre = $btn.data('nombre');
            var numero = $btn.data('numero');
            var idActivo = $btn.data('id-activo');
            var idTraslado = $btn.data('id-traslado');

            $detalleDiv.html(`
        <p>Activo: <strong>${nombre}</strong></p>
        <p>Acta: N°<strong>${numero}</strong></p>
        <button id="popover-btn" class="btn btn-sm btn-danger btn-eliminar-activo" 
        data-id-activo="${idActivo}" 
        data-id-traslado="${idTraslado}" 
        data-acta="${numero}">
        Eliminar de esta acta
        </button>
        `).slideDown();

        $btn.addClass('active'); // opcional, solo visual
    });
    
    $(document).off('click', '#popover-btn').on('click', '#popover-btn', function(e) {
        // alert("hola")
            var $btn = $(this);
const $td = $btn.closest('td');
const idActivo = $btn.data('id-activo');
restaurarBotonDisponible($td, idActivo);

    });

function restaurarBotonDisponible($td, idActivo) {
    $td.html(`
        <div class="d-flex align-items-center border p-2 rounded justify-content-between">
            <span class="text-success fw-semibold">Disponible</span>
            <button class="btn btn-sm btn-outline-primary btn_agregar_activo" data-id="${idActivo}">
                Agregar
            </button>
        </div>
    `);
}
    });
</script>
