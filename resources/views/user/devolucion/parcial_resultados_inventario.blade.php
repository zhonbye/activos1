<style>
    .table-light td {
        background-color: #f8f9fa !important;
        border-top: 2px solid #dee2e6;
    }
</style>
<div class="table-responsive mt-3">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Categoría</th>
                <th>Estado Actual</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($detalles as $detalle)
                @php
                    $idActivo = $detalle->activo->id_activo ?? '';
                    $nombreActivo = $detalle->activo->nombre ?? '';
                    // $cantidadTotal = $detalle->cantidad_inventario ?? 0;
                    // $cantidadRestante = $detalle->cantidad_restante ?? 0;
                    // $estadoTipo = $detalle->estado_tipo ?? 'none';
                @endphp

                <tr data-id-activo="{{ $idActivo }}">
                    <td>{{ $detalle->activo->codigo ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->nombre ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->detalle ?? 'N/D' }}</td>
                    <td>{{ $detalle->activo->categoria->nombre ?? 'N/D' }}</td>
                    <td>{{ $detalle->estado_actual ?? 'N/D' }}</td>
                    <td>
                        {{-- {{ $detalle->en_otras_devolucions }} --}}
                        @if ($detalle->en_devolucion_actual ?? false)
                            <button class="btn btn-sm btn-outline-danger btn-eliminar-activo"
                                data-id-activo="{{ $idActivo }}"
                                data-id-devolucion="{{ $detalle->id_devolucion_actual }}">
                                Eliminar
                            </button>
                        @elseif($detalle->en_otras_devoluciones ?? false)
                            <button class="btn btn-sm btn-outline-secondary btn-ver-detalle"
                                data-id-activo="{{ $idActivo }}" data-actas='@json($detalle->actas_info)'>
                                Revisar
                            </button>
                        @else
                            <button class="btn btn-sm btn-outline-primary btn_agregar_activo"
                                data-id="{{ $idActivo }}">
                                Agregar
                            </button>
                        @endif
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


<script>
    $(document).ready(function() {






  $(document).off('click', '.btn-ver-detalle').on('click', '.btn-ver-detalle', function() {
            const idActivo = $(this).data('id-activo');
            const actas = $(this).data('actas') || [];

            // Toggle: si ya existe fila de detalle, la eliminamos
            const $filaDetalleExistente = $(`tr[data-detalle-id="${idActivo}"]`);
            if ($filaDetalleExistente.length > 0) {
                $filaDetalleExistente.remove();
                return;
            }

            // Creamos los botones tal como estaban, solo agregando data-id-activo y data-id-devolucion
            let botonesHTML = '';
            actas.forEach(acta => {
                botonesHTML += `
            <button type="button" id="seleccionar_devolucion" class="btn btn-sm btn-outline-secondary btn-seleccionar-devolucion"
                data-id-activo="${idActivo}" data-id="${acta.id_devolucion}">
                Revisar esta acta
            </button>
            <button type="button" class="btn btn-sm btn-danger btn-eliminar-activo"
                data-id-activo="${idActivo}" data-id-devolucion="${acta.id_devolucion}">
                Eliminar de esta acta
            </button>
        `;
            });

            // Fila expandida con detalles
            const detalleHTML = `
        <tr class="table-light" data-detalle-id="${idActivo}">
            <td colspan="6">
                <div class="p-3 d-flex justify-content-between flex-wrap align-items-center gap-2">
                    <div>
                        <strong>Activo usado en la Acta: </strong>
                        ${actas.length > 0 ? ` ${actas[0].numero_documento}` : ''}
                    </div>
                    <div class="d-flex gap-2">
                        ${botonesHTML}
                    </div>
                </div>
            </td>
        </tr>
    `;

            // $filaDetalleExistente.remove();
            $(`tr[data-detalle-id="${idActivo}"]`).remove();
            $(this).closest('tr').after(detalleHTML);

        });

        




// ✅ SOLO cerrar el detalle si el botón pertenece al detalle (data-detalle="true")
$(document).on('click', '.btn-eliminar-activo', function() {
    if ($(this).data('detalle') === true) {
        const idActivo = $(this).data('id-activo');
        $(`tr[data-detalle-id="${idActivo}"]`).remove();
    }
});
//

    // Limpiar filas de detalle al cerrar el modal
    $('#modalInventario').on('hidden.bs.modal', function() {
        $(this).find('tr[data-detalle-id]').remove();
    });









    });
</script>
