<form id="formEditarResponsable" method="POST" action="{{ route('responsables.update', $responsable->id_responsable ?? '') }}">
    @csrf
    @method('PUT') <!-- Para update -->
    <input type="hidden" name="id_responsable" value="{{ $responsable->id_responsable }}">
    <!-- 🧾 Sección 1: Datos personales -->
    <div class="mb-4 p-3 rounded" style="background-color: #b8cce92f;">
        <h6 class="fw-bold border-bottom pb-1 mb-3">
            <i class="bi bi-person-vcard me-1"></i> Información personal
        </h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nombreEditar" class="form-label">Nombre completo</label>
                <input type="text" id="nombreEditar" name="nombre" class="form-control"
                    placeholder="Ej: Juan Pérez" value="{{ $responsable->nombre ?? '' }}" required>
            </div>
            <div class="col-md-3">
                <label for="ciEditar" class="form-label">C.I.</label>
                <input type="text" id="ciEditar" name="ci" class="form-control"
                    placeholder="Ej: 9876543" value="{{ $responsable->ci ?? '' }}" required>
            </div>
            <div class="col-md-3">
                <label for="telefonoEditar" class="form-label">Teléfono</label>
                <input type="text" id="telefonoEditar" name="telefono" class="form-control"
                    placeholder="Ej: 71234567" value="{{ $responsable->telefono ?? '' }}">
            </div>
        </div>
    </div>

    <!-- 🏢 Sección 2: Cargo y rol -->
    <div class="mb-4 p-3 rounded" style="background-color: #c6fde827;">
        <h6 class="fw-bold border-bottom pb-1 mb-3">
            <i class="bi bi-briefcase-fill me-1"></i> Cargo y rol
        </h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="cargoEditar" class="form-label">Cargo</label>
                <select id="cargoEditar" name="id_cargo" class="form-select" required>
                    <option value="">Seleccione un cargo</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id_cargo }}" {{ ($responsable->id_cargo ?? '') == $cargo->id_cargo ? 'selected' : '' }}>
                            {{ $cargo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="rolEditar" class="form-label">Rol del sistema</label>
                <select id="rolEditar" name="rol" class="form-select" required>
    <option value="">Seleccione un rol</option>
    <option value="administrador" {{ ($responsable->rol ?? '') == 'administrador' ? 'selected' : '' }}>Administrador</option>
    <option value="director" {{ ($responsable->rol ?? '') == 'director' ? 'selected' : '' }}>Director</option>
    <option value="coordinador" {{ ($responsable->rol ?? '') == 'coordinador' ? 'selected' : '' }}>Coordinador</option>
    <option value="medico" {{ ($responsable->rol ?? '') == 'medico' ? 'selected' : '' }}>Médico / Doctor</option>
    <option value="enfermero" {{ ($responsable->rol ?? '') == 'enfermero' ? 'selected' : '' }}>Enfermero / Técnico de enfermería</option>
    <option value="administrativo" {{ ($responsable->rol ?? '') == 'administrativo' ? 'selected' : '' }}>Personal administrativo / Secretaria</option>
    <option value="personal_operativo" {{ ($responsable->rol ?? '') == 'personal_operativo' ? 'selected' : '' }}>Personal operativo</option>
    <option value="invitado" {{ ($responsable->rol ?? '') == 'invitado' ? 'selected' : '' }}>Visitante / Invitado</option>
</select>

            </div>
        </div>
    </div>

    <!-- 🟢 Estado y usuario -->
    <div class="mb-4 p-3 rounded" style="background-color: #d6f0e241;">
        <h6 class="fw-bold border-bottom pb-1 mb-3">
            <i class="bi bi-check2-circle me-1"></i> Estado y usuario
        </h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="estadoEditar" class="form-label">Estado</label>
                <select id="estadoEditar" name="estado" class="form-select" required>
                    <option value="">Seleccione estado</option>
                    <option value="activo" {{ ($responsable->estado ?? '') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ ($responsable->estado ?? '') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>
    </div>

</form>
