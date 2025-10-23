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
                <th>Disponibilidad</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detalles as $detalle)
                @php
                    $idActivo = $detalle->activo->id_activo ?? '';
                    $nombreActivo = $detalle->activo->nombre ?? '';
                    $cantidadTotal = $detalle->cantidad_inventario ?? 0;
                    $cantidadRestante = $detalle->cantidad_restante ?? 0;
                    $estadoTipo = $detalle->estado_tipo ?? 'none';
                @endphp

                <tr data-id-activo="{{ $idActivo }}">
                    <td>{{ $detalle->activo->codigo ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->id_activo ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->detalle ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->categoria->nombre ?? 'N/D' }}</td>
                    <td>{{ $detalle->estado_actual ?? 'N/D' }}</td>
                    <td>{{ $cantidadTotal }}</td>
                    <td>
                        {{-- <div class="d-flex align-items-center border p-2 rounded justify-content-between" data-id-activo="{{ $idActivo }}"> --}}
                        {{-- Mostrar cantidad disponible --}}
                        @if ($cantidadRestante > 0)
                            <span class="text-success fw-semibold">
                                {{ $cantidadRestante }} disponibles
                            </span>
                        @else
                            <span class="text-danger fw-semibold">
                                Sin disponibilidad
                            </span>
                        @endif


</div>
</td>
<td>
    {{-- Mostrar botón según estado real --}}
    @if ($detalle->cantidad_en_acta > 0)
        {{-- Ya está en esta acta --}}
        <button class="btn btn-sm btn-outline-danger btn-eliminar-activo" data-id-activo="{{ $idActivo }}"
            data-id-traslado="{{ $detalle->id_traslado }}">
            Eliminar
        </button>
    @elseif ($detalle->cantidad_en_acta == 0 && $detalle->cantidad_restante > 0)
        {{-- Disponible para agregar --}}
        <button class="btn btn-sm btn-outline-primary btn_agregar_activo" data-id="{{ $idActivo }}"
            data-cantidad-restante="{{ $detalle->cantidad_restante }}"
            data-cantidad-total="{{ $detalle->cantidad_inventario }}">
            Agregar
        </button>
    @elseif ($detalle->cantidad_en_acta == 0 && $detalle->cantidad_restante == 0)
        {{-- Sin stock, revisar --}}
        <button type="button" class="btn btn-sm btn-outline-secondary btn-ver-detalle"
            data-id-activo="{{ $idActivo }}" data-nombre="{{ $nombreActivo }}">
            Revisar
        </button>
    @endif

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
