<style>
    .table-light td {
        background-color: #f8f9fa !important;
        border-top: 2px solid #dee2e6;
    }
</style>


<div class="table-responsive mt-3">
    <div class="table-responsive mt-3">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Detalle</th>
                    <th>Categoría</th>
                    <th>Estado</th>
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
                        $estadoActual = $detalle->estado_actual ?? 'N/D';
                    @endphp

                    <tr data-id-activo="{{ $idActivo }}">
                        <td>{{ $codigoActivo }}</td>
                        <td>{{ $nombreActivo }}</td>
                        <td>{{ $detalleActivo }}</td>
                        <td>{{ $categoriaActivo }}</td>
                        <td>{{ $detalle->estado_actual ?? 'N/D' }}</td>
                        <td>
                            @if ($detalle->en_entrega_actual ?? false)
                                <button class="btn btn-sm btn-outline-danger btn-eliminar-activo"
                                    data-id-activo="{{ $idActivo }}"
                                    data-id-entrega="{{ $detalle->id_entrega_actual }}">
                                    Eliminar
                                </button>
                            @elseif($detalle->en_otras_entregas ?? false)
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
                // $(this).closest('tr').after(detalleHTML);
                // $('#modalBuscarActivos tbody').html(''); // limpia todo
                // o solo las filas de detalle
                // $('#modalBuscarActivos tbody tr[data-detalle-id]').remove();

                return;
            }

            // Creamos los botones tal como estaban, solo agregando data-id-activo y data-id-entrega
            let botonesHTML = '';
            actas.forEach(acta => {
                botonesHTML += `
            <button type="button" id="seleccionar_entrega" class="btn btn-sm btn-outline-secondary btn-seleccionar-entrega"
                data-id-activo="${idActivo}" data-id="${acta.id}">
                Revisar esta acta
            </button>
            <button type="button" class="btn btn-sm btn-danger btn-eliminar-activo"
                data-id-activo="${idActivo}" data-id-entrega="${acta.id}">
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
                        <strong>Activo usado en: </strong>
                        ${actas.length > 0 ? `Acta: ${actas[0].numero_documento}` : ''}
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



















        // Limpiar filas de detalle al cerrar el modal
        $('#modalBuscarActivos').on('hidden.bs.modal', function() {
            $(this).find('tr[data-detalle-id]').remove();
        });


    });
</script>
