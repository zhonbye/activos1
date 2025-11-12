<div style="height: 90%; overflow:auto;">
    <table class="table table-striped mb-0 rounded">
      <thead class="table-light">
        <tr>
          {{-- <th>ID</th> --}}
          <th>Personal   (CI)</th>
          <th>Usuario</th>
          <th>Rol</th>
          <th>Estado</th>
          <th>Creado</th>
          <th>Actualizado</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>

      <tbody>
        @forelse ($usuarios as $usuario)
        <tr data-id="{{ $usuario->id_usuario }}">
            <td>{{ $usuario->responsable ? $usuario->responsable->nombre . ' (' . $usuario->responsable->ci . ')' : '—' }}</td>
            {{-- <td>{{ $usuario->responsable->nombre ?? '—' }}</td> --}}
            {{-- <td>{{ $usuario->id_usuario }}</td> --}}
          <td>{{ $usuario->usuario }}</td>
          <td>{{ ucfirst($usuario->rol) ?? '—' }}</td>

          {{-- Estado --}}
          <td>
            @if ($usuario->estado === 'activo')
              <span class="badge bg-success">Activo</span>
            @elseif ($usuario->estado === 'inactivo')
              <span class="badge bg-secondary">Inactivo</span>
            @else
              <span class="badge bg-dark">Desconocido</span>
            @endif
          </td>

          <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
          <td>{{ $usuario->updated_at->format('d/m/Y') }}</td>

          {{-- Botones de acción --}}
          <td class="text-center">
            {{-- Editar usuario --}}
            <button class="btn btn-sm btn-outline-dark editar-usuario-btn"
                    data-id="{{ $usuario->id_usuario }}"
                    data-bs-toggle="modal" data-bs-target="#modalEditarUsuario"
                    title="Editar usuario">
              <i class="bi bi-person-gear"></i>
            </button>

            {{-- Eliminar usuario --}}
            <button class="btn btn-sm btn-outline-danger eliminar-usuario-btn"
                    data-id="{{ $usuario->id_usuario }}"
                    title="Eliminar usuario">
              <i class="bi bi-trash"></i>
            </button>

            {{-- Opcional: Ver responsable --}}
            @if ($usuario->id_responsable)
              <button class="btn btn-sm btn-outline-primary ver-responsable-btn"
                      data-id="{{ $usuario->id_responsable }}"
                      title="Ver responsable">
                <i class="bi bi-person-lines-fill"></i>
              </button>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center">No se encontraron registros.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $usuarios->links('pagination::bootstrap-5') }}
</div>
