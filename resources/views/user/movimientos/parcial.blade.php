<div style="height: 70vh; max-height: 70vh; overflow-y: auto; overflow-x: hidden; position: relative;">
    <table class="table table-striped mb-0 rounded">
        <thead class="table-light">
            <tr>
                <th class="text-center">N° Documento</th>
                <th class="text-center">Gestión</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Tipo Acta</th>
                <th class="text-center">Responsable</th>
                <th class="text-center">Servicio</th>
                <th class="text-center">Estado</th>
                <th class="text-center4234">Registrado por</th>
                {{-- <th class="text-center">Creado</th> --}}
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
        @foreach($inventarios as $inv)
            <tr>
                <td class="text-center">{{ $inv->numero_documento }}</td>
                <td>{{ $inv->gestion }}</td>
                <td>{{ \Carbon\Carbon::parse($inv->fecha)->format('d/m/Y') }}</td>
                <td class="text-center">
    <span class="badge bg-secondary" style="min-width: 80px; display:inline-block;">
        {{ ucfirst(trim($inv->tipo_acta)) }}
    </span>
</td>
              
                <td class="text-center">
    @if($inv->tipo_acta === 'traslado')
        <span class="text-secondary d-block">
            {{ $inv->responsable_origen ?? '-' }}
        </span>
        <span class="d-block">
            {{ $inv->responsable_destino ?? '-' }}
        </span>
    @else
        {{ $inv->responsable ?? '-' }}
    @endif
</td>
<td class="text-center">
    @if($inv->tipo_acta === 'traslado')
        <span class="text-secondary d-block">
            {{ $inv->servicio_origen ?? '-' }}
        </span>
        <span class="d-block">
            {{ $inv->servicio_destino ?? '-' }}
        </span>
    @else
        {{ $inv->servicio ?? '-' }}
    @endif
</td>

                {{-- <td>{{ $inv->estado ?? '-fdsafdsafdaf' }}</td> --}}
                
                {{-- Estado --}}
               <td class="text-center">
    @php
        $estadoRaw = strtolower(trim($inv->estado ?? ''));
        
        switch($estadoRaw) {
            case 'pendiente':
                $badgeClass = 'bg-success';
                break;
            case 'finalizado':
                $badgeClass = 'bg-danger';
                break;
            default:
                $badgeClass = 'bg-secondary';
        }
    @endphp
    <span class="badge {{ $badgeClass }} " style="min-width: 80px; display:inline-block;">
        {{ ucfirst($estadoRaw) }}
    </span>
</td>


  <td>{{ $inv->usuario ?? '-' }}</td>


                {{-- <td>{{ \Carbon\Carbon::parse($inv->created_at)->format('d/m/Y H:i') }}</td> --}}
<td class="text-center">
    <div class="btn-group" role="group">
        <!-- Revisar Acta -->
        <button class="btn btn-sm btn-primary btn-revisar-acta" 
                style="width: 40px; height: 40px;" 
                data-id="{{ $inv->id }}" 
                data-tipo="{{ $inv->tipo_acta }}"
                title="Revisar Acta">
            <i class="bi bi-journal-text"></i>
        </button>

        <!-- Imprimir / Reporte -->
        <button class="btn btn-sm btn-success" style="width: 40px; height: 40px;" 
                title="Imprimir Acta"
                onclick="imprimirReporte('{{ $inv->id }}', '{{ $inv->tipo_acta }}')">
            <i class="bi bi-printer"></i>
        </button>
    </div>
</td>



            </tr>
        @endforeach

        @if($inventarios->isEmpty())
            <tr>
                <td colspan="9" class="text-center text-muted">No se encontraron registros</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $inventarios->links('pagination::bootstrap-5') }}
</div>



<!-- Modal -->
<div class="modal fade" id="detalleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle del Acta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="modalContenido">
        <!-- Aquí se cargará el contenido por AJAX -->
      </div>
    </div>
  </div>
</div>


















<script>




function imprimirReporte(id, tipoActa) {
    let baseUrl = window.location.origin;
    let url = "";

    // -------------------------
    // Definir URL según el tipo de acta
    // -------------------------
    if (tipoActa === "entrega") {
        url = `${baseUrl}/imprimir-activo/${id}`;
    }
    else if (tipoActa === "traslado") {
        url = `${baseUrl}/imprimir-traslado/${id}`;
    }
    else if (tipoActa === "devolucion") {
        url = `${baseUrl}/imprimir-devolucion/${id}`;
    }
    else {
        alert("Tipo de acta no válido.");
        return;
    }

    // -------------------------
    // Crear IFRAME oculto
    // -------------------------
    let $iframe = $('<iframe>', {
        id: 'iframeImpresion',
        style: 'position:absolute;width:0;height:0;border:0;'
    }).appendTo('body');

    // Cargar la URL dentro del iframe
    $iframe.attr('src', url);

    // Cuando el iframe cargue
    $iframe.on('load', function() {
        let iframeWin = this.contentWindow || this;

        iframeWin.focus();
        iframeWin.print();

        // Eliminar iframe después de imprimir
        setTimeout(function() {
            $iframe.remove();
        }, 1500);
    });
}

    // Cargar contenido por AJAX al hacer clic
$(document).on('click', '.btn-revisar-acta', function() {
    let $fila = $(this).closest('tr'); // fila del botón clickeado

    // Tomamos los datos visibles de la fila según el índice de columna
    let numero_documento = $fila.find('td:eq(0)').text().trim();
    let gestion = $fila.find('td:eq(1)').text().trim();
    let fecha = $fila.find('td:eq(2)').text().trim();
    let tipo_acta = $fila.find('td:eq(3)').text().trim(); // índice de Tipo Acta

    let entrega_id = $(this).data('id');
    let tipo = $(this).data('tipo');
    let baseUrl = window.location.origin; // ajusta si tu base URL es diferente
    let url = '';

    // Definir URL según tipo
    if(tipo === 'entrega') {
        url = `${baseUrl}/entregas/${entrega_id}/activos`;
    } else if(tipo === 'traslado') {
        url = `${baseUrl}/traslados/${entrega_id}/activos`;
    } else if(tipo === 'devolucion') {
        url = `${baseUrl}/devoluciones/${entrega_id}/activos`;
    }

    // Cambiar título del modal dinámicamente
    $('#detalleModal .modal-title').text(
        `Detalle Acta: ${numero_documento} | Gestión: ${gestion} | Fecha: ${fecha} | Tipo: ${tipo_acta}`
    );

    // Cargar contenido en el modal
    $.get(url, function(response) {
        $('#modalContenido').html(response);

        // Mostrar modal
        $('#detalleModal').modal('show');

        // Ocultar toda la columna 7 (índice 5)
        $('#modalContenido table').each(function() {
            // Eliminar encabezado
            $(this).find('thead tr th:eq(5)').remove();

            // Eliminar celdas del cuerpo
            $(this).find('tbody tr').each(function() {
                $(this).find('td:eq(5)').remove();
            });
        });     
    });
});



</script>




















<script>
// $(document).ready(function() {
//     $(document).on('click', '.btn-revisar-acta', function(e) {
//         e.preventDefault();

//         let id = $(this).data('id');
//         let tipo = $(this).data('tipo');

//         // Definir la URL según tipo de acta
//         let url = '';
//         if(tipo === 'entrega') {
//             url = '/entregas/' + id;
//         } else if(tipo === 'traslado') {
//             url = '/traslados/' + id;
//         } else if(tipo === 'devolucion') {
//             url = '/devolucion/' + id;
//         }

//         // AJAX para cargar la vista en #contenido
//         $.ajax({
//             url: url,
//             type: 'GET',
//             success: function(response) {
//                 $('#contenido').html(response);
//                 // opcional: scroll al div
//                 $('html, body').animate({ scrollTop: $('#contenido').offset().top }, 500);
//             },
//             error: function(xhr) {
//                 alert('Error al cargar el detalle de la acta');
//             }
//         });
//     });
// });
</script>





