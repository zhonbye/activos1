<div class="table-responsive shadow-sm">
  <table class="table table-bordered align-middle">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Código</th>
        <th>Activo</th>
        <th>Tipo</th>
        <th>Origen</th>
        <th>Destino</th>
        <th>Responsable</th>
        <th>Observaciones</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($historial as $item)
      <tr>
        <td>{{ $item['fecha'] ?? '-' }}</td>
        <td>{{ $item['codigo'] ?? '-' }}</td>
        <td>{{ $item['activo'] ?? '-' }}</td>
        <td>{{ ucfirst($item['tipo_movimiento'] ?? '-') }}</td>
        <td>{{ $item['origen'] ?? '-' }}</td>
        <td>{{ $item['destino'] ?? '-' }}</td>
        <td>{{ $item['usuario'] ?? '-' }}</td>
        <td>{{ $item['observaciones'] ?? '-' }}</td>
        <td>
          <button 
            class="btn btn-sm btn-outline-primary btnVerDetalle" 
            data-item='@json($item)' 
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
        <td colspan="9" class="text-center">No se encontraron registros</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
