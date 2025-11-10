<div class="table-responsive shadow-sm">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>Fecha</th>
          <th>Código</th>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Origen</th>
          <th>Destino</th>
          <th>Responsable</th>
          <th>Observaciones</th>
          <th>Estado situacional</th>
          <th>Acciones</th>
        </tr>
      </thead>

      <tbody>
        @forelse($historial as $h)
          @php
            // Convertir array en objeto si es necesario
            if (is_array($h)) $h = (object) $h;
          @endphp

          <tr>
            <td>{{ !empty($h->fecha) ? \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') : '-' }}</td>
            <td>{{ $h->codigo ?? '-' }}</td>
            <td>{{ $h->nombre ?? '-' }}</td>
            <td>{{ $h->tipo ?? '-' }}</td>
            <td>{{ $h->origen ?? '-' }}</td>
            <td>{{ $h->destino ?? '-' }}</td>
            <td>{{ $h->responsable ?? '-' }}</td>
            <td>{{ $h->observaciones ?? '-' }}</td>
            <td>{{ ucfirst($h->estado_situacional ?? '-') }}</td>

            <td class="text-center">
              <button
                class="btn btn-sm btn-outline-primary btnVerDetalle"
                data-h='@json($h)'
                title="Ver detalle">
                <i class="bi bi-eye"></i>
              </button>
              <button class="btn btn-sm btn-outline-success" title="Imprimir">
                <i class="bi bi-printer-fill"></i>
              </button>
              <button class="btn btn-sm btn-rojo" title="Descargar PDF">
                <i class="bi bi-file-earmark-pdf"></i>
              </button>
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
