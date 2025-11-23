<div class="table-responsive shadow-sm">
    <table class="table table-bordered align-middle">
        <thead class="table-light table-responsive">
            <tr>
                <th>Fecha</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Registrado por</th>

                

<th class="position-relative text-center">
    Observaciones
</th>



    



                <th>Estado situacional</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($historial as $h)
                @php
                    // Convertir array en objeto si es necesario
                    if (is_array($h)) {
                        $h = (object) $h;
                    }
                @endphp

                <tr>
                    <td>{{ !empty($h->fecha) ? \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $h->codigo ?? '———' }}</td>
                    <td>{{ $h->nombre ?? '———' }}</td>
                    <td>{{ $h->tipo ?? '———' }}</td>
               <td class="text-center">
    @if(empty($h->origen))
        <em class="text-muted">———</em>
    @elseif(in_array($h->origen, ['Sistema', 'Activos Fijos']))
        <em class="text-muted">{{ $h->origen }}</em>
    @else
        {{ $h->origen }}
    @endif
</td>

<td class="text-center">
    @if(empty($h->destino))
        <em class="text-muted">———</em>
    @elseif(in_array($h->destino, ['Sistema', 'Activos Fijos']))
        <em class="text-muted">{{ $h->destino }}</em>
    @else
        {{ $h->destino }}
    @endif
</td>

                    <td>{{ $h->responsable ?? '———' }}</td>
<td class="d-none d-md-table-cell  collapse col-observaciones show" 
    style="max-width: 200px; max-height: 50px; overflow: auto; word-break: break-word;">
    @if($h->observaciones)
        {{ $h->observaciones }}
    @else
        <em class="text-muted">Sin observaciones</em>
    @endif
</td>

             <td class="text-center">
    @if(($h->estado_situacional ?? '') === 'activo')
        <span class="badge bg-danger">En uso</span>
    @elseif(($h->estado_situacional ?? '') === 'inactivo')
        <span class="badge bg-success">Libre</span>
    @elseif(($h->estado_situacional ?? '') === 'de baja')
        <span class="badge bg-dark">De baja</span>
    @else
        <span class="badge bg-secondary">—</span>
    @endif
</td>


                    <td class="text-center">
                         {{-- data-id-adquisicion="{{ $donacion->id_adquisicion }}" --}}
                         <button class="btn btn-sm btn-primary ver-activo-btn"
                                title="Ver detalles del activo"
                                data-bs-toggle="modal"
                                data-bs-target="#modalVisualizar2"
                                data-id= {{ $h->id_activo ?? ''}}">
                            <i class="bi bi-eye"></i>
                        </button>
                        {{-- <button class="btn btn-sm btn-outline-primary btnVerDetalle" 
                            title="Ver detalle">
                            <i class="bi bi-eye"></i>
                        </button> --}}
                        {{-- <button class="btn btn-sm btn-outline-success" title="Imprimir">
                            <i class="bi bi-printer-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-rojo" title="Descargar PDF">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </button> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-3">
                        No se encontraron registros con los filtros aplicados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal fade " id="modalVisualizar2" tabindex="-1" aria-labelledby="modalVisualizarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-dark" id="modalVisualizarLabel">Detalle Completo del Activo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4 ">
                <!-- Contenido cargado por AJAX -->
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>
<script>


$(document).off('click', '.ver-activo-btn').on('click', '.ver-activo-btn', function() {
    var idActivo = $(this).data('id');
    var url = baseUrl + '/activo/' + idActivo + '/detalle';

    $.ajax({
        url: url,
        type: 'GET',
        success: function(data) {
            $('#modalVisualizar2 .modal-body').html(data);
            // const modal = new bootstrap.Modal(document.getElementById('modalVisualizar2'));
            // modal.show();
        },
        error: function() {
            $('#modalVisualizar2 .modal-body').html('<div class="alert alert-danger text-center">No se pudo cargar el detalle del activo.</div>');
            // const modal = new bootstrap.Modal(document.getElementById('modalVisualizar2'));
            // modal.show();
        }
    });
});


function toggleColumna(colIndex) {
    // Recorremos todas las filas
    $('table tr').each(function() {
        let celda = $(this).children().eq(colIndex);

        // No ocultar el TH, solo los TD
        if (!celda.is('th')) {
            celda.toggleClass('d-none');
        }
    });

    // Mover el botón al centro entre las dos columnas afectadas
    let btn = $('#btn-toggle-observaciones');
    let th = btn.closest('th');

    // Obtenemos el ancho visible de la columna actual y la siguiente
    let colActual = th;
    let colSiguiente = th.next();

    let anchoActual = colActual.outerWidth();
    let anchoSiguiente = colSiguiente.length ? colSiguiente.outerWidth() : 0;

    // Calcular nuevo left para centrar sobre la mitad de ambas columnas
    let nuevoLeft = (anchoActual + anchoSiguiente) / 2;

    // Aplicar inline style
    btn.css({
        left: nuevoLeft + 'px',
        transform: 'translateX(-50%) translateY(-50%)' // mantener vertical centrado
    });
}




</script>