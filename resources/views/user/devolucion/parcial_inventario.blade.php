<div class="card border-0 shadow-sm p-4 pt-0 mx-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <!-- Formulario de búsqueda -->
            <div class="flex-grow-1">
                <form id="form_buscar_inventario" class="row g-3 text-start">
                    @csrf

                    <div class="col-md-4">
                        <label for="codigo_activo" class="form-label fw-semibold">Código de Activo</label>
                        <input type="text" name="codigo_activo" id="codigo_activo" class="form-control"
                            placeholder="Ej. ACT123">
                    </div>

                    <div class="col-md-4">
                        <label for="nombre_activo" class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="nombre_activo" id="nombre_activo" class="form-control"
                            placeholder="Nombre del activo">
                    </div>

                    <div class="col-md-4">
                        <label for="categoria_activo" class="form-label fw-semibold">Categoría</label>
                        <select name="categoria_activo" id="categoria_activo" class="form-select">
                            <option value="">Todos...</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Botones -->
                    <div class="col-12 text-center mt-4 d-flex gap-3 justify-content-center">
                        <button type="button" id="btn_buscar_inventario" class="btn btn-primary w-75">
                            <i class="bi bi-search me-1"></i> Buscar
                        </button>
                        <button type="reset" class="btn btn-danger w-25">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Icono y título a la derecha -->
            <div class="ms-4 text-center">
                <i class="bi bi-search text-primary fs-1"></i>
                <h4 class="fw-bold mt-2">Buscar activos</h4>
                <p class="text-muted small">Ingrese los criterios para encontrar activos en el inventario</p>
            </div>
        </div>

        <!-- Resultados -->
        <div id="resultado_inventario" class="mt-4"></div>
    </div>
</div>

<script>
   $(document).off('click', '.btn_agregar_activo')
    .on('click', '.btn_agregar_activo', function(e) {
        e.preventDefault();

        const $btn = $(this);

        // Evita clics múltiples
        if ($btn.data('processing')) return;

        const idActivo = $btn.data('id');
        const idDevolucion = $('#btn_editar_devolucion').data('id'); // Cambiado
        const cantidadRestante = parseInt($btn.data('cantidad-restante') ?? 0, 10);

        if (!idDevolucion) {
            mensaje('No se encontró el ID de la devolución.', 'warning');
            return;
        }

        if (!idActivo) {
            mensaje('No se encontró el ID del activo.', 'warning');
            return;
        }

        if (cantidadRestante <= 0) {
            mensaje('No hay disponibilidad para este activo.', 'warning');
            return;
        }

        // 🔹 Determinar cantidad
        let cantidad = 1;

        if (cantidadRestante > 1) {
            const input = prompt(`Ingrese la cantidad a agregar (máximo ${cantidadRestante}):`, "1");
            if (input === null) return; // Canceló
            cantidad = parseInt(input, 10);

            if (isNaN(cantidad) || cantidad < 1) {
                mensaje('Cantidad inválida.', 'warning');
                return;
            }

            if (cantidad > cantidadRestante) {
                mensaje(`Solo hay ${cantidadRestante} disponibles.`, 'warning');
                return;
            }
        }

        // Marca el botón como procesando
        $btn.data('processing', true).prop('disabled', true);

        // 🔹 Enviar al servidor
        $.ajax({
            url: `${baseUrl}/devolucion/${idDevolucion}/activos/agregar`, // Cambiado
            type: 'POST',
            data: {
                id_activo: idActivo,
                cantidad: cantidad,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    mensaje(response.message || 'Activo agregado correctamente.', 'success');

                    // 🔹 Reemplazar botón Agregar por botón Eliminar
                    const $btnAgregar = $(`.btn_agregar_activo[data-id="${idActivo}"]`);
                    if ($btnAgregar.length) {
                        const $btnEliminar = $(`
                            <button class="btn btn-sm btn-outline-danger btn-eliminar-activo"
                                    data-id-activo="${idActivo}"
                                    data-id-devolucion="${idDevolucion}">
                                Eliminar
                            </button>
                        `);
                        $btnAgregar.replaceWith($btnEliminar);
                    }

                    // 🔹 Actualizar cantidad restante en la misma fila
                    const $fila = $(`button.btn-eliminar-activo[data-id-activo="${idActivo}"]`).closest('tr');
                    const $tdCantidad = $fila.find('td').eq(6); // Columna de cantidad restante

                    if ($tdCantidad.length) {
                        let cantidadActual = parseInt($tdCantidad.text().replace(/\D/g, '')) || 0;
                        let nuevaCantidad = cantidadActual - cantidad;

                        if (nuevaCantidad > 0) {
                            $tdCantidad.html(
                                `<span class="text-success fw-semibold" data-cantidad-restante="${nuevaCantidad}">${nuevaCantidad} disponibles</span>`
                            );
                        } else {
                            $tdCantidad.html(
                                `<span class="text-danger fw-semibold" data-cantidad-restante="${nuevaCantidad}">Sin disponibilidad</span>`
                            );
                        }
                    }

                } else {
                    mensaje(response.error || 'No se pudo agregar el activo.', 'danger');
                }

                cargarTablaActivos(idDevolucion); // Cambiado

            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.error || 'Ocurrió un error al agregar el activo.';
                mensaje(msg, 'danger');
                console.error(xhr.responseText);
            },
            complete: function() {
                $btn.data('processing', false).prop('disabled', false);
            }
        });
    });





    // Evita múltiples bindings del mismo evento
    $(document).off('click', '#btn_buscar_inventario')
    .on('click', '#btn_buscar_inventario', function(e) {
          
            e.preventDefault();

            const $btn = $(this);

            // Evitar clicks repetidos mientras procesa
            if ($btn.data('processing')) return;

            const idServicio = $('#id_servicio').val(); // nuevo campo
            const idDevolucion = $('#devolucion_id').val(); // hidden del proceso de devolución
            let data = $('#form_buscar_inventario').serialize();

            // Agregar variables adicionales si existen
            if (idServicio) {
                data += '&id_servicio=' + encodeURIComponent(idServicio);
            }
            if (idDevolucion) {
                data += '&id_devolucion=' + encodeURIComponent(idDevolucion);
            }

            // Marcar como procesando (bloquear botón temporalmente)
            $btn.data('processing', true).prop('disabled', true);
            // AJAX
            $.ajax({
                url: "{{ route('devolucion.buscarActivos') }}", // ruta nueva para devoluciones
                type: 'POST',
                data: data,
                success: function(html) {
                    $('#resultado_inventario').html(html);
                },
                error: function(xhr) {
                    let msg = 'Ocurrió un error inesperado.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    mensaje(msg, 'danger');
                    console.error(xhr.responseText);
                },
                complete: function() {
                    // Restablecer estado del botón
                    $btn.data('processing', false).prop('disabled', false);
                }
            });
        });


    // Aquí puedes agregar la lógica para manejar el botón de búsqueda y mostrar resultados
</script>
