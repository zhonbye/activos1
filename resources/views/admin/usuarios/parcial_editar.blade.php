<form id="formEditarUsuario" method="POST" action="{{ route('usuarios.update', ['usuario' => $usuario->id_usuario]) }}">
    @csrf
    @method('PUT') <!-- Para actualizar -->

    <!-- 🧾 Sección 1: Datos de usuario -->
    <div class="mb-4 p-3 rounded" style="background-color: #e7eef886;">
        <h6 class="fw-bold border-bottom pb-1 mb-3">
            <i class="bi bi-person-vcard me-1"></i> Datos de usuario
        </h6>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="usuarioEditar" class="form-label">Nombre de usuario</label>
                <input type="text" id="usuarioEditar" name="usuario" class="form-control"
                    value="{{ $usuario->usuario }}" required>
            </div>
            <div class="col-md-6">
                <label for="rolEditar" class="form-label">Rol del sistema</label>
                <select id="rolEditar" name="rol" class="form-select" required>
                    <option value="">Seleccione un rol</option>
                    <option value="administrador" {{ $usuario->rol == 'administrador' ? 'selected' : '' }}>Administrador
                    </option>
                    <option value="usuario" {{ $usuario->rol == 'usuario' ? 'selected' : '' }}>Usuario</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mt-2">

            <div class="col-md-6">
                <label for="claveEditar" class="form-label">Nueva contraseña</label>
                <input type="password" id="claveEditar" name="clave" class="form-control"
                    placeholder="Dejar en blanco para no cambiar">
            </div>

                <div class="col-md-6">
                    <label for="claveConfirmEditar" class="form-label">Confirmar nueva contraseña</label>
                    <input type="password" id="claveConfirmEditar" name="clave_confirmation" class="form-control"
                        placeholder="Repita contraseña">
                </div>
           
        </div>
        {{-- </div> --}}

        <!-- 🔄 Sección 2: Estado -->
        <div class="mb-4 p-3 rounded" style="background-color: #f0f7e896;">
            <h6 class="fw-bold border-bottom pb-1 mb-3">
                <i class="bi bi-toggle-on me-1"></i> Estado del usuario
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="estadoEditar" class="form-label">Estado</label>
                    <select id="estadoEditar" name="estado" class="form-select" required>
                        <option value="activo" {{ $usuario->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ $usuario->estado == 'inactivo' ? 'selected' : '' }}>Inactivo
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-end">
            <button type="reset" class="btn btn-secondary">
                <i class="bi bi-eraser-fill"></i> Limpiar
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2-circle"></i> Guardar cambios
            </button>
        </div>
</form>
