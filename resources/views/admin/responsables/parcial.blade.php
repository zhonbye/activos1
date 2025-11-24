<div style="height: 90%; overflow:auto;">
    <table class="table table-striped mb-0 rounded">
      <thead class="table-light">
        <tr>
          <th>Nombre</th>
          <th>CI</th>
          <th>Teléfono</th>
          <th>Profesión</th>
          <th>Cargo</th>
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
              <span class="badge bg-primary">Tiene acceso</span>
            @else
              <span class="badge bg-dark">Sin acceso</span>
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

<br>
{{-- 
@if ($personal->servicio)
    <button class="btn btn-sm btn-outline-success editar-servicio-btn"
            data-bs-toggle="modal" 
            data-bs-target="#modalEditarServicio"
            data-id="{{ $personal->servicio->id_servicio }}"
            title="Editar servicio / área asignada">
        <i class="bi bi-building-gear"></i>
    </button>
@else
    <button class="btn btn-sm btn-outline-primary asignar-servicio-btn"
            data-bs-toggle="modal"
            data-bs-target="#modalAsignarServicio"
            data-id="{{ $personal->id_responsable }}"
            title="Asignar servicio / área a este responsable">
        <i class="bi bi-building-add"></i>
    </button>
@endif --}}











            {{-- Botón condicional según tenga usuario --}}
            @if ($personal->usuario)
              {{-- Editar usuario existente --}}
              <button class="btn btn-sm btn-outline-success editar-usuario-btn"
              data-bs-toggle="modal" data-bs-target="#modalEditarUsuario"
                      data-id="{{ $personal->usuario->id_usuario }}"
                      title="Editar usuario">
                <i class="bi bi-person-gear"></i>
              </button>
            @else
              {{-- Agregar nuevo usuario --}}
              <button class="btn btn-sm btn-outline-d agregar-usuario-btn"
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
