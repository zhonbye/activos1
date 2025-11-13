<div style="height: 90%; overflow:auto;">
    <table class="table table-striped mb-0 rounded">
      <thead class="table-light">
        <tr>
          <th>Nombre</th>
          <th>CI</th>
          <th>Teléfono</th>
          <th>Cargo</th>
          <th>Rol</th>
          <th>
            <div class="d-flex align-items-center">
              <span>Estado</span>
              <div class="dropdown fst-normal fw-normal">
                <button class="btn btn-link p-0 text-primary fw-normal" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1rem;">
                  <i class="bi bi-info-lg"></i>
                </button>
                <ul class="dropdown-menu p-2 fw-normal" style="min-width: 250px;">
                  <li class="d-flex align-items-center mb-1">
                    <span class="badge bg-success me-2">&nbsp;</span> Personal activo actualmente
                  </li>
                  <li class="d-flex align-items-center">
                    <span class="badge bg-secondary me-2">&nbsp;</span> Personal inactivo
                  </li>
                </ul>
              </div>
            </div>
          </th>
          <th>Usuario del sistema</th>
          <th>Fecha de registro</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>

      <tbody>
        @forelse ($personales as $personal)
        <tr data-id="{{ $personal->id_responsable }}">
          <td>{{ $personal->nombre }}</td>
          <td>{{ $personal->ci }}</td>
          <td>{{ $personal->telefono ?? '—' }}</td>
          <td>{{ $personal->cargo->nombre ?? 'Sin cargo' }}</td>
          <td>{{ $personal->rol ?? '—' }}</td>

          {{-- Estado --}}
          <td>
            @if ($personal->estado === 'activo')
              <span class="badge bg-success">Activo</span>
            @elseif ($personal->estado === 'inactivo')
              <span class="badge bg-secondary">Inactivo</span>
            @else
              <span class="badge bg-dark">Desconocido</span>
            @endif
          </td>

          {{-- Usuario asignado --}}
          <td>
            @if ($personal->usuario)
              <span class="badge bg-primary">Tiene usuario</span>
            @else
              <span class="badge bg-dark">No tiene usuario</span>
            @endif
          </td>

          <td>{{ $personal->created_at->format('d/m/Y') }}</td>

          {{-- Botones de acción --}}
          <td class="text-center">

            {{-- Editar personal --}}
            <button class="btn btn-sm btn-outline-primary editar-btn" data-bs-toggle="modal" data-bs-target="#modalEditarResponsable"
                    data-id="{{ $personal->id_responsable }}"
                    title="Editar personal">
              <i class="bi bi-pencil"></i>
            </button>

            {{-- Eliminar personal --}}
            <button class="btn btn-sm btn-outline-danger eliminar-btn"
                    data-id="{{ $personal->id_responsable }}"
                    title="Eliminar personal">
              <i class="bi bi-trash"></i>
            </button>

            {{-- Botón condicional según tenga usuario --}}
            @if ($personal->usuario)
              {{-- Editar usuario existente --}}
              <button class="btn btn-sm btn-outline-dark editar-usuario-btn"
              data-bs-toggle="modal" data-bs-target="#modalEditarUsuario"
                      data-id="{{ $personal->usuario->id_usuario }}"
                      title="Editar usuario">
                <i class="bi bi-person-gear"></i>
              </button>
            @else
              {{-- Agregar nuevo usuario --}}
              <button class="btn btn-sm btn-outline-secondary agregar-usuario-btn"
                      data-id="{{ $personal->id_responsable }}"  data-bs-toggle="modal" 
        data-bs-target="#modalNuevoUsuario"
                      title="Crear usuario para este personal">
                <i class="bi bi-person-plus"></i>
              </button>
             

            @endif

          </td>
        </tr>
      @empty
        <tr>
          <td colspan="9" class="text-center">No se encontraron registros.</td>
        </tr>
      @endforelse

      </tbody>
    </table>
  </div>

  <div class="mt-3 flex-shrink: 0; bg-da3ng3er">
    {{ $personales->links('pagination::bootstrap-5') }}
  </div>
