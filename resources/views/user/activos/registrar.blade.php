<div class="main-col col-md-12 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 50vh;">
    <form method="POST" id="form_activo" action="{{ route('activos.store') }}">
        @csrf
        <input type="hidden" id="acta_id" name="acta_id" value="">
        <input type="hidden" id="tipo_acta_oculto" name="tipo_acta" value="">

        <!-- Sección 1: Datos del Activo -->
        <div class="row g-3 mb-4 p-3 rounded" style="background-color: #f0f4f8;">
            <h5 class="mb-3 fw-bold"><i class="bi bi-box-seam me-2"></i>Datos del Activo</h5>

            <div class="col-md-6 col-lg-4">
                <label for="codigo" class="form-label">Código</label>
                <div class="input-group">
                    <input type="text" class="form-control input-form" name="codigo" id="codigo"
                        placeholder="Ej: AMD-EMG-001" value="{{ $siguienteCodigo }}" required>
                    <button class="btn btn-outline-primary" type="button" id="buscarCodigoBtn">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control input-form" name="nombre" id="nombre" required
                    placeholder="Ej: Sofá">
            </div>

            <div class="col-md-6 col-lg-4">
                <label for="detalle" class="form-label">Detalle</label>
                <input type="text" class="form-control input-form" name="detalle" id="detalle" required
                    placeholder="Ej: Color café">
            </div>

            <div class="col-md-6 col-lg-3">
                <label for="id_categoria" class="form-label">Categoría</label>
                <select class="form-select input-form" name="id_categoria" id="id_categoria" required>
                    <option value="" disabled selected>Seleccione una categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 col-lg-3">
                <label for="id_unidad" class="form-label">Unidad de Medida</label>
                <select class="form-select input-form" name="id_unidad" id="id_unidad" required>
                    <option value="" disabled selected>Seleccione unidad</option>
                    @foreach ($unidades as $unidad)
                        <option value="{{ $unidad->id_unidad }}">{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 col-lg-3">
                <label for="id_estado" class="form-label">Estado</label>
                <select class="form-select input-form" name="id_estado" id="id_estado" required>
                    <option value="" disabled selected>Seleccione estado</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_estado }}"
                            {{ strtolower($estado->nombre) === 'nuevo' ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Sección 2: Información de Adquisición -->
        <div class="row g-3 mb-4 p-3 rounded" style="background-color: #f7f7f7;">
            <h5 class="mb-3 fw-bold"><i class="bi bi-credit-card-2-front me-2"></i>Información de Adquisición</h5>

            <div class="col-md-4">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control input-form" name="fecha" id="fecha" required>
            </div>

            <div class="col-md-8">
                <label for="comentarios" class="form-label">Comentarios</label>
                <input type="text" class="form-control input-form" name="comentarios" id="comentarios"
                    placeholder="Ej: Compra realizada en almacén central">
            </div>

            <div class="col-md-12">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="sin_datos_checkbox" name="sin_datos"
                        value="1" {{ old('sin_datos') ? 'checked' : '' }}>
                    <label class="form-check-label" for="sin_datos_checkbox">
                        No tengo los datos necesarios
                    </label>
                </div>
            </div>

            <div class="col-md-4" id="tipo_adquisicion_seccion">
                <label for="tipo_adquisicion" class="form-label">Tipo de Adquisición</label>
                <select class="form-select input-form" id="tipo_adquisicion" name="tipo_adquisicion" required>
                    <option value="" disabled {{ old('tipo_adquisicion') ? '' : 'selected' }}>Seleccione tipo
                    </option>
                    <option value="compra" {{ old('tipo_adquisicion') == 'compra' ? 'selected' : '' }}>Compra</option>
                    <option value="donacion" {{ old('tipo_adquisicion') == 'donacion' ? 'selected' : '' }}>Donación
                    </option>
                </select>
            </div>
        </div>

        <!-- Sección 3: Compra -->
        <div class="row g-3 mb-4 p-3 rounded" id="form_compra" style="display: none; background-color: #eef7f1;">
            <h6 class="mb-3 fw-bold"><i class="bi bi-bag-check me-2"></i>Datos de la Compra</h6>

            <div class="col-md-6">
                <label for="id_proveedor" class="form-label">Proveedor</label>
                <div class="input-group">
                    <select class="form-select input-form" name="id_proveedor" id="id_proveedor">
                        <option value="" disabled selected>Seleccione proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary" type="button">Agregar</button>
                </div>
            </div>

            <div class="col-md-6">
                <label for="precio_compra" class="form-label">Precio de Compra</label>
                <div class="input-group">
                    <span class="input-group-text">Bs.</span>
                    <input type="number" class="form-control input-form" name="precio_compra" id="precio_compra"
                        step="0.01" placeholder="Ej: 2,500.00">
                </div>
            </div>

        </div>

        <!-- Sección 4: Donación -->
        <div class="row g-3 mb-4 p-3 rounded" id="form_donacion" style="display: none; background-color: #fff4e6;">
            <h6 class="mb-3 fw-bold"><i class="bi bi-gift me-2"></i>Datos de la Donación</h6>

            <div class="col-md-6">
                <label for="id_donante" class="form-label">Donante</label>
                <div class="input-group">
                    <select class="form-select input-form" name="id_donante" id="id_donante">
                        <option value="" disabled selected>Seleccione donante</option>
                        @foreach ($donantes as $donante)
                            <option value="{{ $donante->id_donante }}">{{ $donante->nombre }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary" type="button">Agregar</button>
                </div>
            </div>

            <div class="col-md-3">
                <label for="motivo" class="form-label">Motivo</label>
                <input type="text" class="form-control input-form" name="motivo" id="motivo"
                    placeholder="Ej: Donación empresa XYZ">
            </div>

            <div class="col-md-3">
                <label for="precio_donacion" class="form-label">Precio Estimado</label>
                <div class="input-group">
                    <input type="number" class="form-control input-form" name="precio_donacion" id="precio_donacion"
                        step="0.01" placeholder="Ej: 2000.00">
                    <span class="input-group-text">Bs.</span>
                </div>
            </div>

        </div>

    </form>


    {{-- </div> --}}
</div>


<!-- JS para interactividad -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        // $(function() {
        //     $('#buscarCodigoBtn').trigger('click');
        // });
        $('#form_activo').submit(function(e) {
            e.preventDefault(); // Evita recargar la página al enviar el formulario

            let formDataArray = $(this).serializeArray();

            // Eliminar cualquier campo 'sin_datos' previo para evitar duplicados
            formDataArray = formDataArray.filter(function(field) {
                return field.name !== 'sin_datos';
            });

            // Agregar el checkbox manualmente con el valor correcto (1 si está marcado, 0 si no)
            formDataArray.push({
                name: 'sin_datos',
                value: $('#sin_datos_checkbox').is(':checked') ? 1 : 0
            });

            // Convertir array de datos a query string para enviarlo
            let formData = $.param(formDataArray);
            let sinDatos = $('#sin_datos_checkbox').prop('checked');
            let tipoAdq = $('#tipo_adquisicion').val();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    //     if (response.success) {



                    if (response.success) {
                        if (response.numeroSiguiente) {
                            // $('#numero_documento').val(response.numeroSiguiente);
                        }else{
                        }

                        mensaje('Activo registrado correctamente.', 'success');
                        $('#form_activo')[0].reset(); // Resetea formulario
                        $('#sin_datos_checkbox').prop('checked', sinDatos);
                        $('#tipo_adquisicion').val(tipoAdq);
                        // $('#form_activo')[0].reset();
                        $('#buscarCodigoBtn').trigger('click');

                        const a = response.activo;
// alert(a.situacion)

const badges = {
    activo: '<span class="badge bg-danger">En uso</span>',
    inactivo: '<span class="badge bg-success">Libre</span>',
    baja: '<span class="badge bg-dark">Baja</span>',
};
const badgeSituacion = badges[a.situacion] || `<span class="badge bg-secondary">${a.situacion}</span>`;


                        // Construir la nueva fila
                        const nuevaFila = `
            <tr data-id="${a.id}">
                <td>${a.codigo}</td>
                <td>${a.nombre}</td>
                <td>${a.detalle}</td>
                <td>${a.categoria}</td>
                <td>${a.unidad}</td>
                <td>${a.estado_fisico}</td>
                   <td>${badgeSituacion}</td>
                <td>${a.fecha}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-primary editar-btn" data-id="${a.id}" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-dark visualizar-btn" data-id="${a.id}" title="Visualizar">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            </tr>
        `;

                        // Insertar al inicio de la tabla
                        $('table tbody').prepend(nuevaFila);
                    } else {
                        mensaje('Ocurrió un error inesperado.', 'danger');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);

                    let msg = 'Error inesperado en el servidor.';

                    if (xhr.status === 422 && xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            msg = Object.values(xhr.responseJSON.errors).flat().join(
                                '<br>');
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








        $('#buscarCodigoBtn').on('click', function() {
            const codigo = $('#codigo').val();

            // if (!codigo) {
            //     alert('Por favor ingresa un código');
            //     return;
            // }

            $.ajax({
                url: `${baseUrl}/activo/siguiente-codigo`, // Cambia la ruta según tu ruta en Laravel
                method: 'POST',
                data: {
                    codigo_base: codigo,
                    _token: '{{ csrf_token() }}' // Asegúrate de pasar el token CSRF
                },
                success: function(response) {
                    if (response.success) {
                        $('#codigo').val(response.siguiente_codigo);
                        mensaje('Código generado', 'success');
                    } else {
                        mensaje('Error: ' + response.message, 'danger');
                    }
                },
                error: function() {
                    mensaje('Error al buscar el siguiente código', 'danger');
                }
            });
        });








        // $('.toggleSidebar').click(function() {
        //     const $sidebar = $('.sidebar-col');
        //     const $main = $('.main-col'); // Asegúrate que exista este div para que funcione
        //     const $card = $('.sidebar-card');
        //     const $header = $('.sidebar-header');
        //     const $title = $('.sidebar-title');
        //     const $button = $('.toggleSidebar');

        //     const isExpanded = $sidebar.hasClass('col-lg-2');

        //     if (isExpanded) {
        //         // Minimizar sidebar
        //         $sidebar.removeClass('col-lg-2').addClass(
        //             'sidebar-collapsed card-minimized'); // usa tus clases personalizadas si quieres
        //         $main.removeClass('col-lg-10').addClass('col-lg-11'); // o col-lg-12 según diseño
        //         $card.removeClass('p-3 ').addClass('p-0 ');
        //         $header.removeClass('justify-content-between align-items-start').addClass(
        //             'justify-content-center align-items-center flex-column h-100');
        //         $button.addClass('w-100 h-100');
        //         $title.addClass('d-none'); // Ocultar título
        //         $button.text($title
        //             .text()); // O usar tooltip con title: $button.attr('title', 'Registro de Activo');
        //     } else {
        //         // Restaurar sidebar
        //         $sidebar.removeClass('sidebar-collapsed card-minimized').addClass('col-lg-2');
        //         $card.css('max-height', '100px');

        //         $main.removeClass('col-lg-11').addClass('col-lg-10');
        //         $card.removeClass('p-0').addClass('p-3');
        //         $header.removeClass('justify-content-center align-items-center flex-column h-100')
        //             .addClass('justify-content-between align-items-start');
        //         $button.removeClass('w-100 h-100');
        //         $title.removeClass('d-none');
        //         $button.text('⮞');
        //     }
        // });








        $('#sin_datos_checkbox').change(function() {
        const checked = $(this).is(':checked');

        if (checked) {
            // Si marca "Sin datos"
            $('#tipo_adquisicion_seccion').hide();
            $('#form_compra, #form_donacion').hide();
            $('#tipo_adquisicion').val('');

            // Quitar required de todo
            $('#tipo_adquisicion').prop('required', false);
            $('#form_compra input, #form_donacion input, #form_compra select, #form_donacion select').prop('required', false);
        } else {
            // Si desmarca "Sin datos"
            $('#tipo_adquisicion_seccion').show();

            // Hacer obligatorio elegir un tipo de adquisición
            $('#tipo_adquisicion').prop('required', true);
        }
    });

    // 🟢 Select Tipo de adquisición
    $('#tipo_adquisicion').change(function() {
        const tipo = $(this).val();

        if (tipo === 'compra') {
            $('#form_compra').show();
            $('#form_donacion').hide();

            // Requerir solo los campos visibles
            $('#form_compra input, #form_compra select').prop('required', true);
            $('#form_donacion input, #form_donacion select').prop('required', false);

        } else if (tipo === 'donacion') {
            $('#form_donacion').show();
            $('#form_compra').hide();

            // Requerir solo los campos visibles
            $('#form_donacion input, #form_donacion select').prop('required', true);
            $('#form_compra input, #form_compra select').prop('required', false);

        } else {
            // Si no hay tipo seleccionado
            $('#form_compra, #form_donacion').hide();
            $('#form_compra input, #form_donacion input, #form_compra select, #form_donacion select').prop('required', false);
        }
    });

    });
</script>
