<form id="formNuevoResponsable" method="POST"  action="{{ route('responsables.store') }}">

        @csrf

    <!-- 🧾 Sección 1: Datos personales -->
    <div class="mb-4 p-3 rounded" style="background-color: #e9f2ff;">
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
    <div class="mb-4 p-3 rounded" style="background-color: #f0f7e8;">
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
                <label for="rolResponsable" class="form-label">Rol del sistema</label>
                <select id="rolResponsable" name="rol" class="form-select" required>
                    <option value="">Seleccione un rol</option>
                    <option value="admin">Administrador</option>
                    <option value="user">Usuario</option>
                    <option value="tecnico">Técnico</option>
                </select>
            </div>
        </div>
    </div>

</form>
<script>
$('#formNuevoResponsable').submit(function (e) {
    e.preventDefault();

    let formDataArray = $(this).serializeArray();
    let formData = $.param(formDataArray);

    // Detecta si se pasó una variable global "tabla" (por ejemplo desde Blade)
    const tabla = @json($tabla);
    const datos = @json($datos);

    console.log("🧩 Nombre de tabla:", tabla);
    console.log("📋 Campos recibidos:", datos);

    // 🔹 Función para "recuperar" todo y mostrar en un alert


    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: formData,
        success: function (response) {
            if (response.success) {
                mensaje('Responsable registrado correctamente.', 'success');
                $('#modalNuevoResponsable').modal('hide');
                $('#formNuevoResponsable')[0].reset();

                const responsable = response.responsable;

                // 🔹 Crear un objeto nuevo solo con los campos que existen en "datos"
                const datosFiltrados = datos.map(campo => {
                    return { [campo]: responsable[campo] ?? '-' };
                });

                // 🔹 Convertirlo a formato que la función cargarDatos espera
                // (una lista de objetos con solo los valores)
                const filas = datosFiltrados.reduce((acc, obj) => {
                    if (acc.length === 0) acc.push({});
                    Object.assign(acc[0], obj);
                    return acc;
                }, []);

                // 🔹 Llamar a la función para insertar en la tabla
                cargarDatos(tabla, filas);

            } else {
                mensaje('Ocurrió un error inesperado.', 'danger');
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            let msg = 'Error inesperado en el servidor.';

            if (xhr.status === 422 && xhr.responseJSON) {
                if (xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if (xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
            } else if (xhr.responseJSON?.message) {
                msg = xhr.responseJSON.message;
            }

            mensaje(msg, 'danger');
        }
    });
});


</script>
