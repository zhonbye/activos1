<style>

</style>


{{-- <div class="row  p-0 mb-4 pb-4" style="height: 90vh;">
    <div class="sidebar-wrapper col-md-12 col-lg-2 order-lg-2 order-2 d-flex flex-column gap-3 transition"
        style=" max-height: 95vh;">

        <div class="sidebar-col card p-3">
            <div class="sidebar-header d-flex justify-content-between align-items-start">
                <button class="toggleSidebar btn btn-primary">⮞</button>
                <h2 class="sidebar-title fs-5 text-fw mb-0 ms-2">Acta</h2><br>
            </div>
            <h3>Buscar acta</h3>
            <div class="row g-2 align-items-center my-1">
                <div class="col-md-6">
                    <input type="number" id="numero_acta_buscar" class="con-ceros form-control input-form"
                        placeholder="Número de Acta" value="002" required>
                </div>

                <div class="col-md-6">
                    <input type="number" id="gestion_acta_buscar" class=" form-control input-form "
                        value="{{ date('Y') }}" placeholder="Gestión (Ej. 2025)" required>
                </div>

                <div class="col-md-12">
                    <select id="tipo_acta_buscar" class="form-control input-form" required>
                        <option value="entrega">Entrega</option>
                        <option value="devolucion">Devolución</option>
                        <option value="traslado">Traslado</option>
                    </select>
                </div>



            </div>
            <div class="row g-2 align-items-center my-1">

                <div class="col-md-12">
                    <button class="btn btn-primary w-100" id="btn_buscar_acta" type="button">Buscar
                        Acta</button>
                </div>
            </div>
            <div class="resultado_busqueda_acta" class="mt-4" style="display: none;">
                <div class="alert alert-success" role="alert">
                    <strong>Acta encontrada:</strong>

                    <div class="mt-3">
                        <p class="mb-1"><strong>Estado:</strong> <span id="acta_estado">12345</span></p>
                        <p class="mb-1"><strong>Número:</strong> <span id="acta_numero">12345</span></p>
                        <p class="mb-1"><strong>Gestión:</strong> <span id="acta_gestion">2025</span></p>
                        <p class="mb-1"><strong>Fecha:</strong> <span id="acta_fecha">2025-09-10</span></p>
                        <p class="mb-1"><strong>Tipo:</strong> <span id="acta_tipo">entrega</span></p>
                        <p class="mb-1"><strong>Detalle:</strong> <span id="acta_detalle">Algo aquí</span></p>
                    </div>





                </div>
            </div>
        </div>
    </div> --}}



    {{-- <div class="col-md-12 col-lg-10 text-white order-lg-1 order-1">
        <div class="card mt-4 p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 90vh;">
            <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Registro de Activo</h2> --}}
    <div class="main-col col-md-12 col-lg-10 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;">

        <div class="card  p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 100vh;">
            <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Registro de Activo</h2>

            <div id="alerta_estado_finalizado" class="alert alert-danger d-none text-center fw-bold" role="alert">
                ❌ Esta acta ya fue finalizada y no puedes agregar mas activos.
            </div>
            <form method="POST" id="form_activo" action="{{ route('activos.store') }}">
                @csrf
                <input type="hidden" id="acta_id" name="acta_id" value="">
                <input type="hidden" id="tipo_acta_oculto" name="tipo_acta" value="">

                <!-- Sección: Datos del Activo -->
                <div class="row g-3 mb-4 align-items-center ">
                    <h5>Datos del Activo</h5>

                    <div class="col-md-6 col-lg-4">
                        <label for="codigo" class="form-label">Código</label>
                        <div class="input-group">
                            <input type="text" class="form-control input-form" name="codigo" id="codigo"
                                placeholder="Código del activo" value="amd-001" required>
                            <button class="btn btn-outline-primary" type="button" id="buscarCodigoBtn">
                                <i class="bi bi-search"></i> <!-- ícono lupa usando Bootstrap Icons -->
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control input-form" name="nombre" id="nombre">
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <label for="detalle" class="form-label">Detalle</label>
                        <input type="text" class="form-control input-form" name="detalle" id="detalle">
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <label for="id_categoria" class="form-label">Categoría</label>
                        <select class="form-select input-form" name="id_categoria" id="id_categoria" required>
                            <option value="" disabled selected>Seleccione una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <label for="id_unidad" class="form-label">Unidad de Medida</label>
                        <select class="form-select input-form" name="id_unidad" id="id_unidad" required>
                            <option value="" disabled selected>Seleccione unidad</option>
                            @foreach ($unidadesmed as $unidad)
                                <option value="{{ $unidad->id_unidad }}">
                                    {{ $unidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <label for="id_estado" class="form-label">Estado</label>
                        <select class="form-select input-form" name="id_estado" id="id_estado" required>
                            <option value="" disabled selected>Seleccione estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado }}">
                                    {{ $estado->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                </div>

                <!-- Sección: Información de Adquisición -->
                <div class="row g-3 mb-4">
                    <h5 class="">Información de Adquisición</h5>

                    <div class="col-md-4">
                        <label for="fecha" class="form-label" required>Fecha</label>
                        <input type="date" class="form-control input-form" name="fecha" id="fecha">
                    </div>

                    <div class="col-md-8">
                        <label for="comentarios" class="form-label">Comentarios</label>
                        <input type="text" class="form-control input-form" name="comentarios" id="comentarios">
                    </div>

                    <div class="col-md-12">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="sin_datos_checkbox" name="sin_datos"
                                value="0">

                            <label class="form-check-label" for="sin_datos_checkbox">
                                No tengo los datos necesarios
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4" id="tipo_adquisicion_seccion">
                        <label for="tipo_adquisicion" class="form-label">Tipo de Adquisición</label>
                        <select class="form-select input-form" id="tipo_adquisicion" name="tipo_adquisicion">
                            <option value="" disabled selected>Seleccione tipo</option>
                            <option value="compra">Compra</option>
                            <option value="donacion">Donación</option>
                        </select>
                    </div>
                </div>

                <!-- Sección: Compra -->
                <div class="row g-3 mb-4" id="form_compra" style="display: none;">
                    <h6 class="">Datos de la Compra</h6>

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
                        <label for="precio_compra" class="form-label">Precio</label>
                        <input type="number" class="form-control input-form" name="precio_compra"
                            id="precio_compra" step="0.01">
                    </div>
                </div>

                <!-- Sección: Donación -->
                <div class="row g-3 mb-4" id="form_donacion" style="display: none;">
                    <h6 class="">Datos de la Donación</h6>

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
                        <input type="text" class="form-control input-form" name="motivo" id="motivo">
                    </div>

                    <div class="col-md-3">
                        <label for="precio_donacion" class="form-label">Precio Estimado</label>
                        <input type="number" class="form-control input-form" name="precio_donacion"
                            id="precio_donacion" step="0.01">
                    </div>
                </div>

                <!-- Botón de envío -->
                <div class="row mt-4">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary px-5">Registrar Activo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS para interactividad -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $(function() {
            $('#buscarCodigoBtn').trigger('click');
        });
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

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        mensaje('Activo registrado correctamente.', 'success');
                        $('#form_activo')[0].reset(); // Resetea formulario
                        $('#buscarCodigoBtn').trigger('click');
                        if (response.numeroSiguiente) {
                            $('#numero_documento').val(response.numeroSiguiente);
                        }
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

            if (!codigo) {
                alert('Por favor ingresa un código');
                return;
            }

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
            if ($(this).is(':checked')) {
                $('#tipo_adquisicion_seccion').hide();
                $('#form_compra, #form_donacion').hide();
                $('#tipo_adquisicion').val('');
            } else {
                $('#tipo_adquisicion_seccion').show();
            }
        });

        $('#tipo_adquisicion').change(function() {
            const tipo = $(this).val();
            if (tipo === 'compra') {
                $('#form_compra').show();
                $('#form_donacion').hide();
            } else if (tipo === 'donacion') {
                $('#form_donacion').show();
                $('#form_compra').hide();
            } else {
                $('#form_compra, #form_donacion').hide();
            }
        });
    });
</script>
