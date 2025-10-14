<style>
    /* Destacar inputs activos */
    .input-activo {
        border: 2px solid #0d6efd !important;
        background-color: #e7f1ff !important;
    }

    #iframeOverlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
    }

    .iframe-container {
        position: relative;
        width: 80vw;
        height: 80vh;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px #000;
    }

    .iframe-container iframe {
        width: 100%;
        height: 100%;
        border-radius: 0 0 8px 8px;
        border: none;
    }

    #iframeOverlay #closeIframe {
        position: absolute;
        top: 8px;
        right: 8px;
        background: red;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 4px 8px;
        font-weight: bold;
        cursor: pointer;
    }
</style>





<div class="row  p-0 mb-4 pb-4 " style="height: 90vh;">















    {{-- <div class="main-col col-md-12 col-lg-10 text-white order-lg-1 order-1 transition"> --}}

    {{-- <div class="main-col col-md-12 col-lg-12 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;"> --}}
    {{-- <div class="card  p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 100vh;"> --}}

    {{-- <div class="main-col col-md-12 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;"> --}}
    {{-- <div class="row g-3" style="min-height: 95vh;"> --}}

    <!-- Columna filtros (más ancha) -->
    <div class="col-12 col-lg-3">
        <div class= "scroll-card-sm card p-3 rounded shadow"
            style="background-color: var(--color-fondo); min-height:  scrollbar-width: none;
    -ms-overflow-style: none;
    max-height: 950vh;
    overflow-y: auto;
    height: 95vh;">
            <h5 class="text-center mb-4" style="color: var(--color-texto-principal);">🔍 Filtros de búsqueda
            </h5>

            {{-- <form id="formFiltros" action="" method="GET" class="d-flex flex-column gap-3"> --}}
            <form id="formFiltrosActivos" action="{{ route('activos.filtrar') }}" method="GET"
                class="d-flex flex-column gap-3">

                <!-- Botones -->
                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" id="btnfiltrar" class="btn btn-primary"><i class="bi bi-search"></i>
                        Filtrar</button>
                    <button type="reset" id="btnLimpiarActivos" class="btn btn-secondary"><i
                            class="bi bi-x-circle"></i> Limpiar filtros</button>
                </div>
                <!-- Código -->
                <div>
                    <label for="filtro_codigo" class="form-label fw-bold">Código</label>
                    <input type="text" id="filtro_codigo" name="codigo" class="form-control"
                        placeholder="Ej: AMD-003">
                </div>

                <!-- Nombre -->
                <div>
                    <label for="filtro_nombre" class="form-label fw-bold">Nombre</label>
                    <input type="text" id="filtro_nombre" name="nombre" class="form-control"
                        placeholder="Nombre del activo">
                </div>

                <!-- Detalle -->
                <div>
                    <label for="filtro_detalle" class="form-label fw-bold">Detalle</label>
                    <input type="text" id="filtro_detalle" name="detalle" class="form-control"
                        placeholder="Palabras clave">
                </div>

                <!-- Categoría -->
                <div>
                    <label for="filtro_categoria" class="form-label fw-bold">Categoría</label>
                    <select id="filtro_categoria" name="categoria" class="form-select">
                        <option value="all" selected>Todos</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Unidad/Servicio -->
                <div>
                    <label for="filtro_unidad" class="form-label fw-bold">Unidad/Servicio</label>
                    <select id="filtro_unidad" name="unidad" class="form-select">
                        <option value="all" selected>Todos</option>
                        @foreach ($unidades as $unidad)
                            <option value="{{ $unidad->id_unidad }}">{{ $unidad->nombre }}</option>
                        @endforeach
                    </select>
                </div>



                <!-- Estado físico -->
                <div>
                    <label for="filtro_estado" class="form-label fw-bold">Estado</label>
                    <select id="filtro_estado" name="estado" class="form-select">
                        <option value="all" selected>Todos</option>
                        <option value="nuevo">Nuevo</option>
                        <option value="usado">Usado</option>
                        <option value="mal_estado">Mal estado</option>
                    </select>
                </div>
                <!-- Ordenar por -->
                <div>
                    <label for="ordenar_por" class="form-label fw-bold">Ordenar por</label>
                    <select id="ordenar_por" name="ordenar_por" class="form-select">
                        <option value="created_at" selected>Fecha de creación</option>
                        <option value="codigo">Código</option>
                        <option value="nombre">Nombre</option>
                        <option value="detalle">Detalle</option>
                    </select>
                </div>

                <!-- Dirección -->
                <div>
                    <label for="direccion" class="form-label fw-bold">Dirección</label>
                    <select id="direccion" name="direccion" class="form-select">
                        <option value="desc" selected>Descendente</option>
                        <option value="asc">Ascendente</option>
                    </select>
                </div>

                <div>
                    {{-- <label class="form-label fw-bold mb-1">mostrar mas...</label> --}}
                    <button type="button" id="toggleFechas" class="btn btn-outline-primary mt-4"
                        title="Activar filtro por fechas">
                        <i class="bi bi-calendar-event"> mostrar mas</i>
                    </button>

                </div>



                <!-- Rango de fechas -->
                <div id="rangoFechas" class="d-none">
                    <label class="form-label fw-bold mb-1">Rango de fechas</label>
                    <div class="row g-3 mb-3">
                        <!-- Fecha Inicio -->
                        <div class="col-12 col-md-6">
                            <label for="fecha_inicio" class="form-label small text-muted">Fecha Inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                value="2017-01-01">
                            <!-- Slider para fecha_inicio -->
                            <input type="range" id="slider_start" value="0" min="0" max="100"
                                step="1" class="form-range mt-1">
                        </div>

                        <!-- Fecha Fin -->
                        <div class="col-12 col-md-6">
                            <label for="fecha_fin" class="form-label small text-muted">Fecha Fin</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control"
                                value="{{ date('Y-m-d') }}">
                            <!-- Slider para fecha_fin -->
                            <input type="range" id="slider_end" value="100" min="0" max="100"
                                step="1" class="form-range mt-1">
                        </div>
                    </div>
                </div>


            </form>

        </div>
    </div>

    <!-- Columna principal vacía (más grande) -->
    <div class="col-12 col-lg-9">
        <div class="card p-3 rounded shadow" style="background-color: var(--color-fondo); min-height: 95vh;">

            {{-- <div class="col-12 col-lg-9 h-100">
                <div class="card p-4 rounded shadow d-flex flex-column" --}}
            {{-- style="height: 90vh; background-color: var(--color-fondo); border: 2px dashed var(--color-texto-principal);"> --}}

            <h3 class="text-center text-muted mb-3">Lista de activos </h3>

            <div id="contenedorResultados" class="d-flex flex-column flex-grow-1 bg-secondary rounded bg-opacity-10">
                {{-- Aquí se cargará el contenido dinámico por AJAX --}}
                {{-- @include('user.inventario.parcial', ['inventarios' => $inventarios]) --}}
            </div>
        </div>
    </div>


    {{-- </div> --}}
    {{-- </div> --}}

    <!-- Scripts al final de tu body -->

    <div id="iframeContainer"
        style="display:none; position:fixed; top:10%; left:10%; width:80%; height:70%; background:#fff; border:1px solid #ccc; z-index:9999;">
        <button id="cerrarIframe" style="position:absolute; top:5px; right:10px;">Cerrar X</button>
        <iframe id="iframeActivos" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>

    <!-- Modal -->
    <!-- Modal -->
    <!-- Modal Visualizar Activo -->
    <!-- Modal Visualizar Activo -->
    <!-- Modal Visualizar Activo -->
    <div class="modal fade" id="modalVisualizar" tabindex="-1" aria-labelledby="modalVisualizarLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="modalVisualizarLabel">Detalle Completo del Activo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Contenido cargado por AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="modalEditarLabel">Detalle del Activo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Contenido cargado por AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="guardarCambiosActivo">Guardar cambios</button>
                    <button type="button" class="btn btn-warning" id="restablecerActivo">Restablecer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>







</div>








<script>
    $(document).ready(function() {
        // $('#formFiltrosActivos submit').trigger('click')









        // Botón de restablecer
        $('#restablecerActivo').on('click', function() {
            var form = $('#formEditarActivo')[0]; // Obtener el DOM puro del formulario
            form.reset(); // Resetea todos los campos al estado cargado en el modal

            // Disparar el cambio en el select tipo de adquisición para ajustar los campos dependientes
            $('#tipoAdquisicion').trigger('change');
        });

        // $('#restablecerActivo').on('click', function() {
        // //     var form = $('#modalEditar').find('form#formEditarActivo')[0];
        // //     $('#tipoAdquisicion').change(); 
        // // $('#tipoAdquisicion').triggerHandler('change');
        // // $('#modalEditar').on('shown.bs.modal', function () {
        // //     $('#tipoAdquisicion').change(); // dispara el cambio y ajusta los campos visibles
        // // });

        //     // Tomamos el elemento DOM
        //     form.reset(); // Restablece todos los campos a los valores cargados originalmente
        // });

        // Cuando se hace click en "Guardar cambios"
        $('#guardarCambiosActivo').on('click', function() {
            if (!confirm('¿Está seguro que desea guardar los cambios en este activo?')) return;

            var form = $('#modalEditar').find('form#formEditarActivo');
            var idActivo = form.find('input[name="id_activo"]').val();
            var url = baseUrl + '/activo/' + idActivo + '/update';

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function() {
                    form.find('.is-invalid').removeClass('is-invalid');
                    form.find('.invalid-feedback').remove();
                },
                success: function(response) {
                    if (response.success) {
                        mensaje(response.message, 'success');

                        // ===== ACTUALIZAR LA FILA =====
                        var fila = $('tbody tr[data-id="' + response.data.id_activo + '"]');
                        // $('#modalEditar').modal('hide');
                        bootstrap.Modal.getInstance(document.getElementById('modalEditar'))
                            .hide();

                        if (fila.length) {
                            fila.find('td:eq(0)').text(response.data.codigo);
                            fila.find('td:eq(1)').text(response.data.nombre);
                            fila.find('td:eq(2)').text(response.data.detalle);
                            fila.find('td:eq(3)').text(response.data.categoria);
                            fila.find('td:eq(4)').text(response.data.unidad);
                            fila.find('td:eq(5)').text(response.data.estado);
                            fila.find('td:eq(6)').text(response.data.fecha);
                            fila.addClass('table-primary bg-opacity-10'); // Bootstrap verde
                            setTimeout(function() {
                                fila.removeClass('table-primary bg-opacity-10');
                            }, 2000); // dura 2 segundos
                        }

                    } else {
                        mensaje(response.message, 'danger');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, msgs) {
                            var input = form.find('[name="' + key + '"]');
                            input.addClass('is-invalid');
                            if (input.next('.invalid-feedback').length === 0) {
                                input.after('<div class="invalid-feedback">' + msgs[
                                    0] + '</div>');
                            }
                        });
                        mensaje('Existen errores en el formulario.', 'danger');
                    } else {
                        mensaje('Ocurrió un error inesperado al actualizar.', 'danger');
                    }
                }
            });
        });













        $(function() {
            $('#formFiltrosActivos').triggerHandler('submit');
        });





















        $(document).on('click', '.editar-btn', function() {
            var idActivo = $(this).data('id');
            var url = baseUrl + '/activo/' + idActivo +
                '/editar'; // Ruta Laravel que devuelve la vista parcial

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    // Insertar la vista parcial en el modal
                    $('#modalEditar .modal-body').html(data);

                    // Mostrar modal
                    const modal = new bootstrap.Modal(document.getElementById(
                        'modalEditar'));
                    modal.show();
                },
                error: function() {
                    alert('No se pudo cargar el detalle del activo.');
                }
            });
        });














        $(document).on('click', '.visualizar-btn', function() {
            var idActivo = $(this).data('id');
            var url = baseUrl + '/activo/' + idActivo + '/detalle';

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#modalVisualizar .modal-body').html(data);
                    // $('#modalVisualizar').modal('show');
                    const modal = new bootstrap.Modal(document.getElementById(
                        'modalVisualizar'));
                    modal.show();


                },
                error: function() {
                    alert('No se pudo cargar el detalle del activo.');
                }
            });
        });


















        let usandoFechas = false;

        $('#toggleFechas').on('click', function() {
            usandoFechas = !usandoFechas;

            if (usandoFechas) {
                // Activar fechas, desactivar gestión
                $('#rangoFechas').removeClass('d-none');

                $('#fecha_inicio, #fecha_fin').prop('disabled', false);
                $(this).addClass('active'); // opcional para estilo
            } else {
                // Activar gestión, desactivar fechas
                $('#rangoFechas').addClass('d-none');

                $('#fecha_inicio, #fecha_fin').prop('disabled', true);
                $(this).removeClass('active');
            }
        });


        $('#fecha_inicio, #fecha_fin').prop('disabled', true);


        $('#btnLimpiar').on('click', function() {
            // if (!$('#rangoFechas').hasClass('d-none')) {
            //     $('#rangoFechas').addClass('d-none');
            //     $('#toggleFechas i').removeClass('bi-calendar-event-fill').addClass('bi-calendar-event');
            //     $('#toggleFechas').attr('title', 'Activar filtro por fechas');
            // }
        });

        $('#formFiltrosActivos').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'GET',
                data: $(this).serialize(),
                success: function(data) {
                    // Actualizar contenedor de resultados
                    $('#contenedorResultados').html(data);

                    // Opcional: actualizar URL sin recargar
                    // const newUrl = window.location.pathname + '?' + $('#formFiltrosActivos').serialize();
                    // window.history.pushState(null, '', newUrl);
                },
                error: function(xhr) {
                    let mensaje = 'Error al cargar activos.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        mensaje = xhr.responseJSON.message;
                    }
                    alert(mensaje);
                }
            });
        });

    });

    // Paginación por AJAX
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            data: $('#filtro-form').serialize(), // ENVÍO LOS FILTROS AL AJAX
            success: function(data) {
                $('#contenedorResultados').html(data);
                // window.history.pushState(null, '', url); // opcional
            },
            error: function() {
                alert('Error al cargar página.');
            }
        });
    });










    $(function() {
        // Fecha mínima fija
        const fechaMin = new Date('2017-01-01');

        // Fecha máxima = hoy del sistema
        const fechaMax = new Date();
        const fechaMaxISO = fechaMax.toISOString().slice(0, 10);

        // Ajustamos los atributos min/max en los inputs date
        $('#fecha_inicio, #fecha_fin').attr('min', '2017-01-01').attr('max', fechaMaxISO);

        // Función que convierte un valor slider (0-100) a fecha ISO
        function sliderToDate(val) {
            const diff = fechaMax.getTime() - fechaMin.getTime();
            const date = new Date(fechaMin.getTime() + (val / 100) * diff);
            return date.toISOString().slice(0, 10);
        }

        // Función que convierte una fecha ISO a valor slider (0-100)
        function dateToSlider(fechaStr) {
            const date = new Date(fechaStr);
            if (isNaN(date)) return 0;
            const diff = fechaMax.getTime() - fechaMin.getTime();
            let val = ((date.getTime() - fechaMin.getTime()) / diff) * 100;
            return Math.min(100, Math.max(0, val));
        }

        // Al cargar, sincronizamos sliders con los inputs de fecha (ambos hoy)
        $('#slider_start').val(dateToSlider($('#fecha_inicio').val()));
        $('#slider_end').val(dateToSlider($('#fecha_fin').val()));

        // Slider inicio controla fecha_inicio
        $('#slider_start').on('input change', function() {
            let val = +$(this).val();
            let finVal = +$('#slider_end').val();

            if (val > finVal) {
                val = finVal; // no permitir pasar el slider fin
                $(this).val(val);
            }

            $('#fecha_inicio').val(sliderToDate(val));
        });

        // Slider fin controla fecha_fin
        $('#slider_end').on('input change', function() {
            let val = +$(this).val();
            let inicioVal = +$('#slider_start').val();

            if (val < inicioVal) {
                val = inicioVal; // no permitir bajar del slider inicio
                $(this).val(val);
            }

            $('#fecha_fin').val(sliderToDate(val));
        });

        // Cambios manuales en fecha_inicio actualizan slider inicio
        $('#fecha_inicio').on('change', function() {
            let val = dateToSlider($(this).val());
            let finVal = +$('#slider_end').val();

            if (val > finVal) {
                val = finVal; // evitar cruzar
                $(this).val(sliderToDate(val));
            }

            $('#slider_start').val(val);
        });

        // Cambios manuales en fecha_fin actualizan slider fin
        $('#fecha_fin').on('change', function() {
            let val = dateToSlider($(this).val());
            let inicioVal = +$('#slider_start').val();

            if (val < inicioVal) {
                val = inicioVal; // evitar cruzar
                $(this).val(sliderToDate(val));
            }

            $('#slider_end').val(val);
        });
    });
</script>
