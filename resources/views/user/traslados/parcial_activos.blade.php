<table class="table table-striped" id="tabla_activos">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Detalle</th>
            <th>Estado</th>
            <th>Unidad</th>
            <th>Cantidad</th>
            {{-- <th>Observaciones</th> --}}
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($detalles as $detalle)
            <tr data-id-activo="{{ $detalle->id_activo }}">
                <td>{{ $detalle->activo->codigo }}</td>
                <td>{{ $detalle->activo->nombre }}</td>
                <td>{{ $detalle->activo->detalle }}</td>
                <td>{{ $detalle->activo->estado->nombre ?? 'N/D' }}</td>
                <td>{{ $detalle->activo->unidad->nombre ?? 'N/D' }}</td>

                <!-- Cantidad -->
                {{-- <td>{{ $detalle->cantidad ?? 'N/D' }}</td> --}}
                {{-- @php
                    $cantidadInventario = $detalle->activo->detalleInventario->cantidad ?? 0;
                    $cantidadTraslado = $detalle->cantidad;
                @endphp --}}

                <td>
                    {{-- {{ $detalle->cantidad_usada}}  --}}
                    {{-- {{ $detalle->cantidad_disponible-$detalle->cantidad_usada+$detalle->cantidad_en_acta }}  --}}
                  @if ($detalle->cantidad_disponible > 1)
                        <div class="d-flex align-items-center gap-2">
                            <input disabled type="number" class="form-control form-control-sm cantidad-activo"
                                data-id-activo="{{ $detalle->id_activo }}" value="{{ $detalle->cantidad_en_acta }}" min="1"
                                max="{{ $detalle->cantidad_disponible-$detalle->cantidad_usada+$detalle->cantidad_en_acta }}"  style="width:80px;">

                            <div class="form-check mb-0">
                                <input type="checkbox" class="form-check-input chk-editar-cantidad"
                                    data-id-activo="{{ $detalle->id_activo }}" id="chk_{{ $detalle->id_activo }}"
                                    {{ $detalle->cantidad_disponible > 1 ? '' : 'disabled' }}>
                                <label class="form-check-label" for="chk_{{ $detalle->id_activo }}">Editar</label>
                            </div>
                        </div>
                    @else
                        <span class="fw-semibold">{{ $cantidadTraslado }}</span>
                    @endif
                </td>



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
        let debounceTimeout;
        // const baseUrl = '';


        // Asegúrate de ejecutar esto una sola vez (por ejemplo en $(document).ready)
        // 1) Quitamos handlers previos y registramos el nuevo (evita duplicados)
        $(document).off('click', '.btn-eliminar-activo').on('click', '.btn-eliminar-activo', function(e) {
            e.preventDefault();
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
                        // const $div = $('#modalInventario').find(`.d-flex[data-id-activo="${idActivo}"]`);
                        // const $divs = $('#modalInventario').find('.d-flex');
                        // console.log('divs encontrados:', $divs.length);
                        // console.log('idActivo:', idActivo);
                        const $tr = $('#modalInventario').find(
                            `tr[data-id-activo="${idActivo}"]`);
                        const $div = $tr.find('.d-flex');

                        // console.log($('#modal_body_inventario').length); // ¿Devuelve 1?

                        if ($div.length) {
                            $div.html(`
            <span class="text-success fw-semibold">Disponible</span>
            <button class="btn btn-sm btn-outline-primary btn_agregar_activo"
                data-id="${idActivo}">
                Agregar
            </button>
        `);
                            // alert("entro al if")
                        } else {
                            console.warn("No se encontró el div dentro del modal.");
                        }
                        cargarTablaActivos();
                    } else {
                        mensaje(response.error || 'No se pudo eliminar el activo.',
                            'danger',
                            'error');
                    }
                },
                //                 success: function(response) {
                //                     if (response.success) {
                //                         mensaje(response.message, 'success');
                //                         const $div = $btn.closest('div.d-flex');
                // if ($('#modalInventario')) {

                // alert("el modal invenatrio esa visible")
                // }else{
                //     alert("no esta vbisible")
                // }
                //                         // Volver a mostrar "Disponible" + Agregar
                //                         $div.html(`
                //                     <span class="text-success fw-semibold">Disponible</span>
                //                     <button class="btn btn-sm btn-outline-primary btn_agregar_activo"
                //                         data-id="${idActivo}">
                //                         Agregar
                //                     </button>
                //                 `);
                //                         cargarTablaActivos();
                //                     } else {
                //                         mensaje(response.error || 'No se pudo eliminar el activo.',
                //                             'danger',
                //                             'error');
                //                     }
                //                 },
                error: function(xhr) {
                    console.error(xhr
                        .responseText); // por si quieres verlo completo en consola

                    // Intentar obtener el mensaje del backend
                    let msg = 'Ocurrió un error al eliminar el activo.';

                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        msg = xhr.responseJSON.error;
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    // Mostrar mensaje al usuario
                    mensaje(msg, 'danger');
                },

                complete: function() {
                    // siempre limpiar el estado del botón
                    $btn.data('processing', false).prop('disabled', false);
                }
            });
        });

        $('#overlayComentario').off('click', '#btnGuardarComentario').on('click', '#btnGuardarComentario',
            function() {
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
        $(document).off('change', '.chk-editar-cantidad').on('change', '.chk-editar-cantidad', function() {
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
        // let debounceTimeout;  // Declárala una vez en el scope global o superior

        $(document).off('focus', '.cantidad-activo').on('focus', '.cantidad-activo', function() {
            // Guarda el valor original cuando entra en foco
            const input = $(this);
            input.data('valor-original', input.val());
        });

        $(document).off('blur', '.cantidad-activo').on('blur', '.cantidad-activo', function() {
            const input = $(this);
            const idActivo = input.data('id-activo');
            const valorOriginal = input.data('valor-original');
            const valorActual = input.val();

            // Si el valor cambió, hacer la petición
            if (valorActual !== valorOriginal) {
                $.post(`${baseUrl}/traslados/${traslado_id}/activos/editar`, {
                        id_activo: idActivo,
                        cantidad: valorActual,
                        _token: '{{ csrf_token() }}'
                    },
                    function(res) {
                        if (res.success) {
                            console.log(`Cantidad actualizada a ${valorActual}`);
                        } else {
                            console.warn('Error al actualizar cantidad');
                        }
                    }
                );
            }
            // Si no cambió, no hace nada
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
