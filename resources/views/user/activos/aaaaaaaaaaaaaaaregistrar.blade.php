<style>
    .resaltado {
        border: 2px solid #0d6efd !important;
        /* azul bootstrap o cambia por otro color */
        /* box-shadow: 0 0 5px rgba(13, 110, 253, 0.5); */
        /* transition: all 0.3s ease; */
    }

    /* Solo cambiar fondo cuando está activo */
    #vincularBtn.activo {
        background-color: #198754;
        /* verde bootstrap */
        color: white;
    }
</style>
<div class="row">
    <div class="col-md-12 col-lg-3 text-white order-lg-2 order-1">
        <div class="card mt-4 p-4 rounded shadow"
            style="background-color: var(--color-fondo); min-height: 50vh; position: sticky; top: 3%;">
            <h2 class="mb-1 text-center fs-3" style="color: var(--color-texto-principal);">Agregar a acta</h2>


            {{-- <form method="POST" class="" id="docto" action="{{ route('activos.store') }}"> --}}
            {{-- @csrf --}}

            <div class="row ">
                {{-- Código --}}

                <div class="col-12 mb-3 ">
                    <label class="form-label fs-4">Buscar Acta para agregar activo</label>

                    <div class="row g-2 align-items-center my-1">
                        <div class="col-md-6">
                            <input type="text" id="numero_acta_buscar" class="form-control input-form"
                                placeholder="Número de Acta" value="002" required>
                        </div>
                        <div class="col-md-6">
                            <input type="number" id="gestion_acta_buscar" class="form-control input-form"
                                value="{{ date('Y') }}" placeholder="Gestión (Ej. 2025)" required>
                        </div>


                    </div>
                    <div class="row g-2 align-items-center my-1">

                        <div class="col-md-12">
                            <button class="btn btn-primary w-100" id="btn_buscar_acta" type="button">Buscar
                                Acta</button>
                        </div>
                    </div>
                    {{-- Resultado de la búsqueda --}}
                    <div class="resultado_busqueda_acta" class="mt-4" style="display: none;">
                        <div class="alert alert-success" role="alert">
                            <strong>Acta encontrada:</strong>

                            <div class="mt-3">
                                <p class="mb-1"><strong>Número:</strong> <span id="acta_numero">12345</span></p>
                                <p class="mb-1"><strong>Gestión:</strong> <span id="acta_gestion">2025</span></p>
                                <p class="mb-1"><strong>Fecha:</strong> <span id="acta_fecha">2025-09-10</span></p>
                                <p class="mb-1"><strong>Tipo:</strong> <span id="acta_tipo">Donación</span></p>
                                <p class="mb-1"><strong>Detalle:</strong> <span id="acta_detalle">Algo aquí</span></p>
                            </div>





                            {{-- Confirmación para agregar activo --}}


                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}






        </div>
    </div>

    <div class="col-md-12 col-lg-9 text-white order-lg-1 order-1">
        <div class="card mt- p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 90vh;">
            <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Registro de Activos</h2>






            {{-- <hr class="my-4"> --}}
            {{-- <hr class="my-4 border-secondary"> --}}


            <form method="POST" id="regactivo" action="{{ route('activos.store') }}">
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        Guardar Activo
                    </button>
                    <button type="reset" class="btn btn-danger" id="reset">
                        Limpiar
                    </button>
                </div>
                @csrf
                <div class="row g-3">


                    <label class="form-label fs-4">Datos del activo</label>
                    <div class="col-md-6 col-lg-4">
                        <label for="codigo" class="form-label">Código</label>
                        <div class="input-group">
                            <input type="text" class="form-control input-form" name="codigo" id="codigo"
                                placeholder="Código del activo" required>
                            <button class="btn btn-outline-secondary" type="button" id="buscarCodigoBtn">
                                <i class="bi bi-search"></i> <!-- ícono lupa usando Bootstrap Icons -->
                            </button>
                        </div>
                    </div>


                    {{-- Nombre --}}
                    <div class="col-md-6 col-lg-5">
                        <label for="nombre" class="form-label">Nombre</label>
                        <div class="input-group">
                            <input type="text" class="form-control input-form" name="nombre" id="nombre"
                                placeholder="Nombre del activo" required>
                            <button class="btn btn-outline-secondary vincular-btn" type="button" id="vincularBtn"
                                data-vinculado="true">
                                <i class="bi bi-link"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6 col-lg-3">
                        <label for="id_estado" class="form-label">Estado</label>
                        <select name="id_estado" id="id_estado" class="form-select input-form" required>
                            <option value="" selected disabled>Seleccione estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>


                    {{-- Categoría --}}
                    <div class="col-md-6 col-lg-4">
                        <label for="id_categoria" class="form-label">Categoría</label>
                        <select name="id_categoria" id="id_categoria" class="form-select input-form" required>
                            <option value="" selected disabled>Seleccione categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Detalle --}}

                    <div class="col-md-6 col-lg-5">
                        <label for="detalle" class="form-label">Descripcion</label>
                        <textarea name="detalle" id="detalle" class="form-control input-form" rows="2"
                            placeholder="Descripción detallada " required></textarea>
                    </div>
                    {{-- Cantidad --}}
                    <div class="col-md-6 col-lg-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" min="1" class="form-control input-form" name="cantidad"
                            id="cantidad" value="1" required>
                    </div>

                    {{-- Procedencia --}}
                    <div class="col-md-6 col-lg-3">
                        <label for="procedencia" class="form-label">Procedencia</label>
                        <input type="text" class="form-control input-form" value="ALMACEN" name="procedencia"
                            id="procedencia" placeholder="Procedencia del activo (opcional)">
                    </div>





                    {{-- Unidad de medida --}}
                    <div class="col-md-6 col-lg-3">
                        <label for="id_unidadmed" class="form-label">Unidad de Medida</label>
                        <select name="id_unidadmed" id="id_unidadmed" class="form-select input-form" required>
                            <option value="" selected disabled>Seleccione unidad</option>
                            @foreach ($unidadesmed as $unidad)
                                <option value="{{ $unidad->id_unidadmed }}">{{ $unidad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Origen --}}
                    <div class="col-md-6 col-lg-3">
                        <label for="origen" class="form-label">Origen</label>
                        <select class="form-select input-form" name="origen" id="origen">
                            <option value="Sin especificar" selected>Sin especificar</option>
                            <option value="compra">Compra</option>
                            <option value="donacion">Donación</option>
                        </select>
                    </div>

                    {{-- Fecha --}}
                    <div class="col-md-6 col-lg-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control input-form" name="fecha" id="fecha"
                            value="{{ date('Y-m-d') }}" required>
                    </div>

                    {{-- <div class="col-md-6 col-lg-4">
                        <label for="origen" class="form-label">Origen</label>
                        <select class="form-select input-form" name="origen" id="origen">
                            <option value="" selected>Sin especificar</option>
                            <option value="compra">Compra</option>
                            <option value="donacion">Donación</option>
                        </select>
                    </div> --}}


                    {{-- Depreciación --}}
                    <!-- Select de depreciación -->
    <div class="col-md-6 col-lg-4">
        <label for="depreciacion" class="form-label">Depreciación</label>
        <select class="form-select" name="depreciacion" id="depreciacion">
            <option value="">Seleccione</option>
            <option value="con">Con depreciación</option>
            <option value="sin">Sin depreciación</option>
        </select>
    </div>

    <!-- Campos adicionales si hay depreciación -->
    <div class="col-md-6 col-lg-8" id="campos-depreciacion" style="display: none;">
        <div class="row">
            <div class="col-md-4">
                <label for="anios" class="form-label">Años de depreciación</label>
                <input type="number" class="form-control" name="anios" id="anios" placeholder="Ej: 5">
            </div>
            <div class="col-md-4">
                <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio">
            </div>
            <div class="col-md-4">
                <label for="fecha_fin" class="form-label">Fecha de vencimiento</label>
                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
            </div>
        </div>
    </div>



                </div>


            </form>
            <!-- Formulario Compra -->
            <form id="formCompra" style="display:none;" class="mt-3 ">
                <h5>Formulario Compra</h5>
                <input type="hidden" name="id_compra" id="id_compra">
                <input type="hidden" name="id_activo_compra" id="id_activo_compra">

                <div class="mb-3">
                    <label for="id_proveedor" class="form-label">ID Proveedor</label>
                    <input type="number" class="form-control" id="id_proveedor" name="id_proveedor" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_compra" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha_compra" name="fecha" required
                        value="2025-09-08">
                </div>

                <div class="mb-3">
                    <label for="precio_compra" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio_compra" name="precio"
                        required value="0.00">
                </div>

                <div class="mb-3">
                    <label for="comentarios_compra" class="form-label">Comentarios</label>
                    <textarea class="form-control" id="comentarios_compra" name="comentarios" rows="2"></textarea>
                </div>
            </form>

            <!-- Formulario Donación -->
            <form id="formDonacion" style="display:none;" class="mt-3 ">
                <h5>Formulario Donación</h5>
                <input type="hidden" name="id_donacion" id="id_donacion">
                <input type="hidden" name="id_activo_donacion" id="id_activo_donacion">

                <div class="mb-3">
                    <label for="id_donante" class="form-label">ID Donante</label>
                    <input type="number" class="form-control" id="id_donante" name="id_donante" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_donacion" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha_donacion" name="fecha" required>
                </div>

                <div class="mb-3">
                    <label for="motivo_donacion" class="form-label">Motivo</label>
                    <input type="text" class="form-control" id="motivo_donacion" name="motivo">
                </div>

                <div class="mb-3">
                    <label for="precio_donacion" class="form-label">Precio (opcional)</label>
                    <input type="number" step="0.01" class="form-control" id="precio_donacion" name="precio">
                </div>

                <div class="mb-3">
                    <label for="comentarios_donacion" class="form-label">Comentarios</label>
                    <textarea class="form-control" id="comentarios_donacion" name="comentarios" rows="2"></textarea>
                </div>
            </form>

        </div>
    </div>


</div> {{--  row --}}
<script>
    $(document).ready(function() {

        $('#depreciacion').on('change', function () {
            if ($(this).val() === 'con') {
                $('#campos-depreciacion').slideDown(); // Muestra con animación
            } else {
                $('#campos-depreciacion').slideUp(); // Oculta con animación
            }
        });


        $('#origen').on('change', function() {
            const valor = $(this).val();
            if (valor === 'compra') {
                $('#formCompra').show();
                $('#formDonacion').hide();
            } else if (valor === 'donacion') {
                $('#formCompra').hide();
                $('#formDonacion').show();
            } else {
                $('#formCompra').hide();
                $('#formDonacion').hide();
            }
        });

        let vinculado = true;

        $('#vincularBtn').addClass('activo');

        $('#reset').on('click', function() {
            reset($('#regactivo'));

        });
        $('#vincularBtn').on('click', function() {
            vinculado = !vinculado;

            if (vinculado) {
                $(this).addClass('activo');
                $(this).html('<i class="bi bi-link"></i>');
            } else {
                $(this).removeClass('activo');
                $(this).html('<i class="bi bi-link-45deg"></i>');
            }
        });

        // Solo funciona si está activado
        $('#nombre').on('input', function() {
            if (!vinculado) return;

            const valor = $(this).val();
            $('#detalle').val(valor);
        });

        $('#nombre').on('keydown', function() {
            if (!vinculado) return;

            $('#detalle').addClass('resaltado');
        });

        $('#nombre').on('blur', function() {
            if (!vinculado) return;

            $('#detalle').removeClass('resaltado');
            console.log('Salió del input');
        });















        $('#btn_buscar_acta').on('click', function() {
            const numero = $('#numero_acta_buscar').val();
            const gestion = $('#gestion_acta_buscar').val();

            if (!numero || !gestion) {
                mensaje("Debe ingresar el número y la gestión del acta", "danger");
                return;
            }

            $.ajax({
                url: `${baseUrl}/actas/buscar/${numero}/${gestion}`,
                method: 'GET',
                success: function(response) {
                    if (response.success && response.acta) {
                        const acta = response.acta;

                        // Mostrar detalles del acta
                        $('#acta_numero').text(acta.numero);
                        $('#acta_gestion').text(acta.gestion);
                        $('#acta_fecha').text(acta.fecha);
                        $('#acta_tipo').text(acta.tipo);
                        $('#acta_detalle').text(acta.detalle);

                        $('.resultado_busqueda_acta').show();
                        $('#confirmar_agregar_activo').prop('checked', false);
                        // $('#seccion_agregar_activo').hide();

                        mensaje("Acta encontrada correctamente", "success");
                    } else {
                        mensaje("Acta no encontrada", "warning");
                        $('.resultado_busqueda_acta').hide();
                    }
                },
                error: function() {
                    mensaje("Error al buscar el acta", "danger");
                    $('.resultado_busqueda_acta').hide();
                }
            });
        });

        // Mostrar u ocultar sección para agregar activos
        $('#confirmar_agregar_activo').on('change', function() {
            if ($(this).is(':checked')) {
                $('#seccion_agregar_activo').show();
            } else {
                $('#seccion_agregar_activo').hide();
            }
        });
    });
</script>
