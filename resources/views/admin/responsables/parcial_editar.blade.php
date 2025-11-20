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
            <i class="bi bi-briefcase-fill me-1"></i> Profesion y cargo
        </h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="cargoEditar" class="form-label">Profesión</label>
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
                <label for="rolEditar" class="form-label">Cargo</label>
                <select id="rolEditar" name="rol" class="form-select" required>
                    <option value="">Seleccione un Cargo</option>

                    <option value="">Seleccione un rol</option>
                    @php
                        $roles = [
                            'director',
                            'administrador',
                            'subdirector',
                            'coordinador',
                            'coordinador de pediatría',
                            'coordinador de radiología',
                            'coordinador de emergencias',
                            'coordinador de cirugía',
                            'coordinador de urología',
                            'coordinador cardiología',
                            'jefe de enfermería',
                            'enfermero jefe',
                            'enfermero general',
                            'auxiliar de enfermería',
                            'técnico en laboratorio',
                            'responsable de laboratorio',
                            'responsable de farmacia',
                            'responsable de nutrición',
                            'responsable de nutrición clínica',
                            'responsable de fisioterapia',
                            'responsable de psicología',
                            'responsable de servicios generales',
                            'responsable de docencia',
                            'responsable de investigación',
                            'médico general',
                            'médico especialista',
                            'cirujano',
                            'ginecólogo',
                            'pediatra',
                            'cardiólogo',
                            'urólogo',
                            'farmacéutico',
                            'nutricionista',
                            'psicólogo clínico',
                            'fisioterapeuta',
                            'personal operativo',
                            'administrativo',
                            'secretaria',
                            'recepcionista',
                            'auxiliar administrativo',
                            'contador',
                            'coordinador de logística',
                            'coordinador de recursos humanos',
                            'responsable de calidad',
                            'responsable de seguridad e higiene',
                            'responsable de mantenimiento',
                            'técnico en radiología',
                            'técnico en emergencias',
                            'técnico en farmacia',
                            'técnico en informática',
                            'tecnólogo médico',
                            'responsable de compras',
                            'responsable de archivo',
                            'coordinador de docencia',
                            'coordinador de investigación',
                            'jefe de departamento',
                            'subjefe de departamento',
                            'invitado',
                            'pasante / becario',
                            'voluntario'
                        ];
                    @endphp

                    @foreach ($roles as $rol)
                        <option value="{{ ucwords(strtolower($rol)) }}" {{ strtolower($responsable->rol ?? '') == strtolower($rol) ? 'selected' : '' }}>
                            {{ ucwords(strtolower($rol)) }}
                        </option>
                    @endforeach

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
