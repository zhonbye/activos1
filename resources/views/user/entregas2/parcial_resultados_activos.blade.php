<style>
    .table-light td {
        background-color: #f8f9fa !important;
        border-top: 2px solid #dee2e6;
    }
</style>


<div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Categoría</th>
                <th>Estado Actual</th>
                <th>Cantidad Total</th>
                <th>Disponibilidad</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detalles as $detalle)
               @php
    $idActivo = $detalle->id_activo ?? '';
    $nombreActivo = $detalle->nombre ?? '';
    $codigoActivo = $detalle->codigo ?? 'N/D';
    $detalleActivo = $detalle->detalle ?? 'N/D';
    $categoriaActivo = $detalle->categoria->nombre ?? 'N/D';

    $cantidadTotal = $detalle->cantidad_inventario ?? 0;
    $cantidadRestante = $detalle->cantidad_restante ?? 0;
    $cantidadEnActa = $detalle->cantidad_en_acta ?? 0;
    $estadoTipo = $detalle->estado_tipo ?? 'none';
    $estadoActual = $detalle->estado_actual ?? 'N/D';
@endphp


                <tr data-id-activo="{{ $idActivo }}">
                    <td>{{ $codigoActivo }}</td>
                    <td>{{ $nombreActivo }}</td>
                    <td>{{ $detalleActivo }}</td>
                    <td>{{ $categoriaActivo }}</td>
                    <td>{{ $estadoActual }}</td>
                    <td>{{ $cantidadTotal }}</td>
                    <td>
                        @if ($cantidadRestante > 0)
                            <span class="text-success fw-semibold" data-cantidad-restante="{{ $cantidadRestante }}">
                                {{ $cantidadRestante }} disponibles
                            </span>
                        @else
                            <span class="text-danger fw-semibold" data-cantidad-restante="{{ $cantidadRestante }}">
                                Sin disponibilidad
                            </span>
                        @endif
                    </td>
                    <td>
                        {{-- {{ $cantidadEnActa }} --}}
                        @if ($cantidadEnActa > 0)
                            <button class="btn btn-sm btn-outline-danger btn-eliminar-activo"
                                data-id-activo="{{ $idActivo }}" data-id-entrega="{{ $detalle->id_entrega }}">
                                Eliminar
                            </button>
                        @elseif ($cantidadEnActa == 0 && $cantidadRestante > 0)
                            <button class="btn btn-sm btn-outline-primary btn_agregar_activo"
                                data-id="{{ $idActivo }}"
                                data-cantidad-restante="{{ $cantidadRestante }}"
                                data-cantidad-total="{{ $cantidadTotal }}">
                                Agregar
                            </button>
                        @elseif ($cantidadEnActa == 0 && $cantidadRestante == 0)
                                   <button type="button" class="btn btn-sm btn-outline-secondary btn-ver-detalle"
                                data-id-activo="{{ $idActivo }}"
                                data-nombre="{{ $nombreActivo }}"
                                data-cantidad-actas="{{ $detalle->cantidad_actas }}"
                                data-actas='@json($detalle->actas_info)'>
                                Revisar
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No se encontraron activos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>





<script>
    $(document).ready(function() {









        $(document).on('click', '.btn-ver-detalle', function() {
        const idActivo = $(this).data('id-activo');
        const nombreActivo = $(this).data('nombre');
        const actas = $(this).data('actas') || [];
        const cantidadActas = $(this).data('cantidad-actas') || 0;

        // Si ya está visible, la quitamos (toggle)
        const $filaDetalleExistente = $(`tr[data-detalle-id="${idActivo}"]`);
        if ($filaDetalleExistente.length > 0) {
            $filaDetalleExistente.remove();
            return;
        }

        // Generar las opciones del select (solo número_documento, value = id)
        const opciones = actas.length ?
            actas.map(a => `
                <option value="${a.id}">
                    ${a.numero_documento}
                </option>
            `).join('') :
            '<option value="">Sin actas registradas</option>';

        // Crear la nueva fila de detalle
        const filaDetalle = `
            <tr class="table-light" data-detalle-id="${idActivo}">
                <td colspan="8">
                    <div class="p-3">
                        <div class="fw-semibold mb-2 text-primary">
                            <i class="bi bi-box"></i> Activo: ${nombreActivo}
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <label class="fw-semibold mb-0">Número de documento:</label>
                            <select class="form-select form-select-sm w-auto" id="select-acta-${idActivo}">
                                ${opciones}
                            </select>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-ver-acta" data-id-activo="${idActivo}">
                                Revisar acta
                            </button>
                            <span class="text-muted small ms-2">
                                (${cantidadActas} acta${cantidadActas !== 1 ? 's' : ''} registradas)
                            </span>
                        </div>
                    </div>
                </td>
            </tr>
        `;

        // Insertar debajo de la fila actual
        $(this).closest('tr').after(filaDetalle);
    });

    // Acción del botón "Revisar acta"
    // $(document).on('click', '.btn-ver-acta', function() {
    //     const idActivo = $(this).data('id-activo');
    //     const actaSeleccionada = $(`#select-acta-${idActivo}`).val();
    //     if (!actaSeleccionada) return alert('Seleccione un número de documento para revisar.');

    //     alert(`Revisando activo ${idActivo} en el acta con ID ${actaSeleccionada}`);
    // });

    // Limpiar filas de detalle al cerrar el modal
    $('#modalInventario').on('hidden.bs.modal', function() {
        $(this).find('tr[data-detalle-id]').remove();
    });












        // $('.detalle-activo:visible').each(function() {
        //     $(this).remove();
        //     // alert("div encotado")
        // });

        // $(document).off('click', '.btn-ver-detalle').on('click', '.btn-ver-detalle', function(e) {
        //     e.preventDefault();

        //     var $btn = $(this);
        //     var $td = $btn.closest('td');
        //     var $detalleDiv = $td.find('.detalle-activo');
        //     // alert($detalleDiv.length)
        //     // Si ya existe y está visible → ocultar
        //     if ($detalleDiv.length && $detalleDiv.is(':visible')) {
        //         // Quitar clase de toggle
        //         $btn.removeClass('active');

        //         // Opcional: animación de ocultar y luego eliminar
        //         $detalleDiv.slideUp(200, function() {
        //             $(this).remove(); // elimina del DOM cuando termina la animación
        //         });

        //         return;
        //     }


        //     // Si no existe, crear o si existe pero está oculto → mostrar
        //     if ($detalleDiv.length === 0) {
        //         // alert("mostrando")
        //         $detalleDiv = $('<div class="detalle-activo mt-2 border p-2 rounded"></div>');
        //         $td.append($detalleDiv);
        //     }

        //     var nombre = $btn.data('nombre');
        //     var numero = $btn.data('numero');
        //     var idActivo = $btn.data('id-activo');
        //     var idTraslado = $btn.data('id-traslado');

        //     $detalleDiv.html(`
        // <p>Activo: <strong>${nombre}</strong></p>
        // <p>Acta: N°<strong>${numero}</strong></p>
        // <button id="popover-btn" class="btn btn-sm btn-danger btn-eliminar-activo"
        // data-id-activo="${idActivo}"
        // data-id-traslado="${idTraslado}"
        // data-acta="${numero}">
        // Eliminar de esta acta
        // </button>
        // `).slideDown();

        //     $btn.addClass('active'); // opcional, solo visual
        // });

        // $(document).off('click', '#popover-btn').on('click', '#popover-btn', function(e) {
        //     // alert("hola")
        //     var $btn = $(this);
        //     const $td = $btn.closest('td');
        //     const idActivo = $btn.data('id-activo');
        //     restaurarBotonDisponible($td, idActivo);

        // });

        //     function restaurarBotonDisponible($td, idActivo) {
        //         $td.html(`
        //     <div class="d-flex align-items-center border p-2 rounded justify-content-between">
        //         <span class="text-success fw-semibold">Disponible</span>
        //         <button class="btn btn-sm btn-outline-primary btn_agregar_activo" data-id="${idActivo}">
        //             Agregar
        //         </button>
        //     </div>
        // `);
        //     }
    });
</script>
