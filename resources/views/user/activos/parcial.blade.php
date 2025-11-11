
      <div style="height: 90%; overflow:auto;">
    <table class="table table-striped mb-0 rounded">
        <thead class="table-light">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Categoría</th>
                <th>Unidad de Medida</th>
                <th>Estado físico</th>


                <th>
                    <div class="d-flex align-items-center">
                      <span>Situación</span>
                      <div class="dropdown fst-normal fw-normal">
                        <button class="btn btn-link p-0 text-primary fw-normal" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1rem;">
                            <i class="bi bi-info-lg"></i>
                          </button>

                        <ul class="dropdown-menu p-2  fw-normal" style="min-width: 250px;">
                          <li class="d-flex align-items-center mb-1">
                            <span class="badge bg-success me-2">&nbsp;</span>
                            No está siendo usado por ninguna área
                          </li>
                          <li class="d-flex align-items-center mb-1">
                            <span class="badge bg-danger me-2">&nbsp;</span>
                            Actualmente asignado a un área
                          </li>
                          <li class="d-flex align-items-center">
                            <span class="badge bg-dark me-2">&nbsp;</span>
                            El activo ha sido dado de baja
                          </li>
                        </ul>
                      </div>
                  </th>
                <th>Fecha</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($activos as $activo)
                <tr data-id="{{ $activo->id_activo }}">
                    <td>{{ $activo->codigo }}</td>
                    <td>{{ $activo->nombre }}</td>
                    <td>{{ $activo->detalle }}</td>
                    <td>{{ $activo->categoria->nombre ?? 'N/A' }}</td>
                    <td>{{ $activo->unidad->nombre ?? 'N/A' }}</td>
                    <td>{{ $activo->estado->nombre ?? 'N/A' }}</td>
                    <td>
    @if(isset($activo->estado_situacional))
        @switch($activo->estado_situacional)
            @case('activo')
                <span class="badge bg-danger">En uso</span>
                @break
            @case('inactivo')
                <span class="badge bg-success">Libre</span>
                @break
            @case('baja')
                <span class="badge bg-dark">Baja</span>
                @break
            @default
                <span class="badge bg-secondary">{{ $activo->estado_situacional }}</span>
        @endswitch
    @else
        <span class="badge bg-secondary">N/A</span>
    @endif
</td>

                    <td>{{ $activo->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-primary editar-btn" data-id="{{ $activo->id_activo }}" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-dark visualizar-btn" data-id="{{ $activo->id_activo }}" title="Visualizar">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No se encontraron resultados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div >

         <div style="flex-shrink: 0; margin-top: 10px;">
{{-- <div style="max-height:10vh; height: 10vh; overflow-y: auto; display: flex; position-bottom: 0%;" class="mt-2 bg-danger"> --}}
{{-- <div  class="mt-2 bg-danger"> --}}
    {{ $activos->links('pagination::bootstrap-5') }}
</div>
