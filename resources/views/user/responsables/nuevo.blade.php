<form id="formNuevoResponsable" method="POST"  action="{{ route('responsables.store') }}">

        @csrf

    <!-- 🧾 Sección 1: Datos personales -->
    <div class="mb-4 p-3 rounded" style="background-color: #e7eef886;">
        <h6 class="fw-bold border-bottom pb-1 mb-3">
            <i class="bi bi-person-vcard me-1"></i> Información personal
        </h6>
        <div class="row g-3">
            <div class="col-md-6">
    <label for="nombreResponsable" class="form-label">Nombre completo</label>
    <input 
        type="text" 
        id="nombreResponsable" 
        name="nombre" 
        class="form-control"
        placeholder="Ej: Juan Pérez" 
        required
        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ]+( [A-Za-zÁÉÍÓÚáéíóúÑñ]+){0,4}$"
        title="Solo letras y hasta 5 nombres o apellidos. Sin números."
    >
</div>
<div class="col-md-3">
    <label for="ciResponsable" class="form-label">C.I.</label>
    <input 
        type="text" 
        id="ciResponsable" 
        name="ci" 
        class="form-control"
        placeholder="Ej: 9876543" 
        required
        pattern="^[0-9]{1,8}$"
        title="El C.I. debe tener solo números (máximo 8 dígitos)."
        maxlength="8"
    >
</div>

            <div class="col-md-3">
                <label for="telefonoResponsable" class="form-label">Teléfono</label>
                <input type="text" id="telefonoResponsable" name="telefono" class="form-control" placeholder="Ej: 71234567">
            </div>
        </div>
    </div>

    <!-- 🏢 Sección 2: Cargo y rol -->
    <div class="mb-4 p-3 rounded" style="background-color: #f0f7e896;">
        <h6 class="fw-bold border-bottom pb-1 mb-3">
            <i class="bi bi-briefcase-fill me-1"></i> Profesion y cargo
        </h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="cargoResponsable" class="form-label">Profesión</label>
                <select id="cargoResponsable" name="id_cargo" class="form-select" required>
                    <option value="">Seleccione un cargo</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id_cargo }}">{{ $cargo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="rolResponsable" class="form-label">Cargo que cumple</label>
                <select id="rolResponsable" name="rol" class="form-select" required>
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

</form>
<script>
$('#formNuevoResponsable').submit(function (e) {
    e.preventDefault();

    let form = $(this);
    let formDataArray = form.serializeArray();
    let formData = $.param(formDataArray);

    // Limpia errores previos
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.invalid-feedback').remove();

    const tabla = @json($tabla);
    const datos = @json($datos);

    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: formData,
        success: function (response) {
            if (response.success) {
                mensaje2('Responsable registrado correctamente.', 'success');
                $('#modalNuevoResponsable').modal('hide');
                form[0].reset();
// alert(response.responsable.id_responsable);
                const responsable = response.responsable;
                const datosFiltrados = datos.map(campo => ({ [campo]: responsable[campo] ?? '-' }));
                const filas = datosFiltrados.reduce((acc, obj) => {
                    if (acc.length === 0) acc.push({});
                    Object.assign(acc[0], obj);
                    return acc;
                }, []);
                cargarDatos(tabla, filas);

            } else {
                mensaje2('Ocurrió un error inesperado.', 'danger');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            let msg = 'Error inesperado en el servidor.';

            // 🔹 Errores de validación (422)
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                const errores = xhr.responseJSON.errors;
                msg = xhr.responseJSON.message || 'Errores de validación.';

                // Recorre cada campo con error
                $.each(errores, function (campo, mensajes) {
                    const input = form.find(`[name="${campo}"]`);
                    if (input.length) {
                        input.addClass('is-invalid'); // Marca campo
                        // Inserta mensaje2 debajo
                        input.after(`<div class="invalid-feedback">${mensajes.join('<br>')}</div>`);
                    }
                });
            }
            else if (xhr.responseJSON?.message) {
                msg = xhr.responseJSON.message;
            }

            mensaje2(msg, 'danger');
        }
    });
});


</script>
