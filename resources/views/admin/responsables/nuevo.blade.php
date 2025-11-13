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
                <input type="text" id="nombreResponsable" name="nombre" class="form-control" placeholder="Ej: Juan Pérez" required>
            </div>
            <div class="col-md-3">
                <label for="ciResponsable" class="form-label">C.I.</label>
                <input type="text" id="ciResponsable" name="ci" class="form-control" placeholder="Ej: 9876543" required>
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
            <i class="bi bi-briefcase-fill me-1"></i> Cargo y rol
        </h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="cargoResponsable" class="form-label">Cargo</label>
                <select id="cargoResponsable" name="id_cargo" class="form-select" required>
                    <option value="">Seleccione un cargo</option>
                    @foreach ($cargos as $cargo)
                        <option value="{{ $cargo->id_cargo }}">{{ $cargo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="rolResponsable" class="form-label">Rol que cumple</label>
                <select id="rolResponsable" name="rol" class="form-select" required>
                      <option value="">Seleccione un rol</option>
    <option value="administrador">Administrador</option>
    <option value="director">Director</option>
    <option value="coordinador">Coordinador</option>
    <option value="medico">Médico / Doctor</option>
    <option value="enfermero">Enfermero / Técnico de enfermería</option>
    <option value="administrativo">Personal administrativo / Secretaria</option>
    <option value="personal_operativo">Personal operativo</option>
    <option value="invitado">Visitante / Invitado</option>
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
