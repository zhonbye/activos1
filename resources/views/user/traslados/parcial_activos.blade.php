<table class="table table-striped" id="tabla_activos">
    <thead>
        <tr>
            <th>Código</th>
            <th>Cantidad</th>
            <th>Unidad</th>
            <th>Nombre</th>
            <th>Detalle</th>
            <th>Estado</th>
            {{-- <th>Observaciones</th> --}}
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($detalles as $detalle)
            <tr data-id-activo="{{ $detalle->id_activo }}">
                <td>{{ $detalle->activo->codigo }}</td>

                <!-- Cantidad -->
                <td>fdsafdaf{{ $detalle->cantidad ?? 'N/D' }}fdsafdsa</td>
                <td>
                    @if ($detalle->cantidad > 1)
                        <!-- Si la cantidad > 1: mostrar input editable -->
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" class="form-control form-control-sm cantidad-activo"
                                data-id-activo="{{ $detalle->id_activo }}" value="{{ $detalle->cantidad }}" min="1"
                                max="{{ $detalle->cantidad }}" disabled style="width:80px;">

                            <div class="form-check mb-0">
                                <input type="checkbox" class="form-check-input chk-editar-cantidad"
                                    data-id-activo="{{ $detalle->id_activo }}" id="chk_{{ $detalle->id_activo }}">
                                <label class="form-check-label" for="chk_{{ $detalle->id_activo }}">Editar</label>
                            </div>
                        </div>
                    @else
                        <!-- Si la cantidad = 1: solo texto -->
                        <span class="fw-semibold">{{ $detalle->cantidad }}</span>
                    @endif
                </td>

                <td>{{ $detalle->activo->unidad->nombre ?? 'N/D' }}</td>
                <td>{{ $detalle->activo->nombre }}</td>
                <td>{{ $detalle->activo->detalle }}</td>
                <td>{{ $detalle->activo->estado->nombre ?? 'N/D' }}</td>

                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-activo"
                        data-id-activo="{{ $detalle->id_activo }}" data-id-traslado="{{ $detalle->id_traslado }}">
                        <i class="bi bi-trash"></i>
                    </button>

                    <button type="button" class="btn btn-sm btn-secondary btn-comentar">💬</button>

                    <input type="hidden" class="comentario-activo" value="{{ $detalle->observaciones }}">
                </td>
            </tr>
        @empty
            <tr id="fila_vacia">
                <td colspan="8" class="text-center text-muted">No hay activos</td>
            </tr>
        @endforelse
    </tbody>

</table>

<!-- Overlay para editar observaciones -->
<div id="overlayComentario"
    style="display:none; width:30%; position:fixed; top:20%; left:50%; transform:translateX(-50%); background:#fff; border:1px solid #ccc; padding:15px; z-index:9999; box-shadow:0 2px 10px rgba(0,0,0,0.2);">

    <textarea id="textareaComentario" class="form-control" rows="4" maxlength="100"></textarea>

    <div style="font-size: 0.9em; color: #666; text-align: right; margin-top: 5px;">
        Máximo 100 caracteres
    </div>

    <div class="mt-2 text-end">
        <button id="btnGuardarComentario" class="btn btn-primary btn-sm">Guardar</button>
        <button id="btnCerrarComentario" class="btn btn-secondary btn-sm">Cerrar</button>
    </div>
</div>

<script>
    $(document).ready(function() {

        let filaActual = null;
        const traslado_id = $('#traslado_id').val();
        // const baseUrl = '';


        // Asegúrate de ejecutar esto una sola vez (por ejemplo en $(document).ready)
        // 1) Quitamos handlers previos y registramos el nuevo (evita duplicados)
        $(document).off('click', '.btn-eliminar-activo').on('click', '.btn-eliminar-activo', function(e) {
                e.preventDefault();
// alert("jhon")
// return;
                const $btn = $(this);

                // 2) Protegemos contra clicks repetidos: si ya está procesando, salimos
                if ($btn.data('processing')) return;

                // const idTraslado = $('#traslado_id').val();
                const idActivo = $btn.data('id-activo'); 
                const idTraslado = $btn.data('id-traslado'); 
                // alert("activo"+idActivo +" traslado "+ idTraslado)
                if (!idTraslado || !idActivo) {
                    mensaje('Faltan datos: no se pudo identificar el traslado o el activo.', 'warning');
                    return;
                }

                // Marcar como procesando y deshabilitar visualmente
                $btn.data('processing', true).prop('disabled', true);

                $.ajax({
                    url: `${baseUrl}/traslados/${idTraslado}/activos/eliminar`,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id_activo: idActivo
                    },
                    success: function(response) {
                        if (response.success) {
                            mensaje(response.message, 'success');
                             const $div = $btn.closest('div.d-flex');

                // Volver a mostrar "Disponible" + Agregar
                $div.html(`
                    <span class="text-success fw-semibold">Disponible</span>
                    <button class="btn btn-sm btn-outline-primary btn_agregar_activo"
                        data-id="${idActivo}">
                        Agregar
                    </button>
                `);
                            cargarTablaActivos
                        (); // recarga la tabla (evita manipular filas manualmente)
                        } else {
                            mensaje(response.error || 'No se pudo eliminar el activo.','danger',
                            'error');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        mensaje('Ocurrió un error al eliminar el activo.', 'error');
                    },
                    complete: function() {
                        // siempre limpiar el estado del botón
                        $btn.data('processing', false).prop('disabled', false);
                    }
                });
            });

            $('#overlayComentario').off('click', '#btnGuardarComentario').on('click', '#btnGuardarComentario', function() {
            const comentario = $('#textareaComentario').val();
            const idActivo = filaActual.data('id-activo');
            console.log(`${baseUrl}/traslados/${traslado_id}/activos/editar`);

            $.post(`${baseUrl}/traslados/${traslado_id}/activos/editar`, {
                    id_activo: idActivo,
                    observaciones: comentario,
                    _token: '{{ csrf_token() }}'
                })
                .done(function(res) {
                    if (res.success) {
                        filaActual.find('.comentario-activo').val(comentario);
                        $('#overlayComentario').hide();
                        mensaje('Observación guardada', 'success');
                    }
                })
                .fail(function(xhr) {
                    // Intentamos obtener el mensaje de error del JSON
                    let mensaje2 = 'Ocurrió un error al guardar la observación.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        mensaje2 = xhr.responseJSON.error;
                    }
                    mensaje(mensaje2, 'danger');
                });
        });








        // Activar edición de cantidad con checkbox
        $(document).on('change', '.chk-editar-cantidad', function() {
            const idActivo = $(this).data('id-activo');
            const inputCantidad = $(`.cantidad-activo[data-id-activo="${idActivo}"]`);

            if (this.checked) {
                if (confirm("Está seguro que desea cambiar la cantidad?")) {
                    inputCantidad.prop('disabled', false);
                } else {
                    this.checked = false;
                }
            } else {
                inputCantidad.prop('disabled', true);
            }
        });

        // Guardar cantidad cuando se cambia
        $(document).on('input', '.cantidad-activo', function() {
            const input = $(this);
            const idActivo = input.data('id-activo');
            const cantidad = input.val();

            // Limpiar timeout previo
            clearTimeout(debounceTimeout);

            // Crear nuevo timeout de 5 segundos
            debounceTimeout = setTimeout(function() {
                // Aquí se ejecuta la petición solo después de 5s de inactividad
                $.post(`${baseUrl}/traslados/${traslado_id}/activos/editar`, {
                        id_activo: idActivo,
                        cantidad: cantidad,
                        _token: '{{ csrf_token() }}'
                    },
                    function(res) {
                        if (res.success) {
                            console.log('Cantidad actualizada a', cantidad);
                        }
                    }
                );
            }, 5000); // 5000ms = 5 segundos
        });

        // Mostrar overlay para observaciones
        $(document).on('click', '.btn-comentar', function() {
            filaActual = $(this).closest('tr');
            const comentario = filaActual.find('.comentario-activo').val();
            $('#textareaComentario').val(comentario);
            $('#overlayComentario').show();
            $('#textareaComentario').focus();
        });

        // Guardar comentario



        $('#btnCerrarComentario').click(function() {
            $('#overlayComentario').hide();
        });

    });
</script>
