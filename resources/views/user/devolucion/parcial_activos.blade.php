<table class="table table-striped" id="tabla_activos">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Detalle</th>
            <th>Estado</th>
            <th>Unidad</th>
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
                {{-- <td class="d-flex justify-content-end  gap-2"> --}}
                <td >
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-activo"
                        data-id-activo="{{ $detalle->id_activo }}" data-id-devolucion="{{ $detalle->id_devolucion }}">
                        <i class="bi bi-trash"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary btn-comentar">
                        <i class="bi bi-chat-dots"></i>
                      </button>
                    <input type="hidden" class="comentario-activo" value="{{ $detalle->observaciones }}">
                </td>
            </tr>
        @empty
            <tr id="fila_vacia">
                <td colspan="6" class="text-center text-muted">No hay activos</td>
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

        var filaActual = null;
        const devolucion_id = $('#devolucion_id').val();
        var debounceTimeout;





$(document).off('click', '.btn_agregar_activo')
    .on('click', '.btn_agregar_activo', function(e) {
        e.preventDefault();

        const $btn = $(this);
        if ($btn.data('processing')) return;

        const idActivo = $btn.data('id');
        const idDevolucion = $('#btn_editar_devolucion').data('id');

        if (!idDevolucion) {
            mensaje('No se encontró el ID de la devolucion.', 'warning');
            return;
        }

        if (!idActivo) {
            mensaje('No se encontró el ID del activo.', 'warning');
            return;
        }

        $btn.data('processing', true).prop('disabled', true);

        $.ajax({
            url: `${baseUrl}/devolucion/${idDevolucion}/activos/agregar`,
            type: 'POST',
            data: {
                id_activo: idActivo,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    mensaje(response.message || 'Activo agregado correctamente.', 'success');

                    // Reemplazar botón Agregar por botón Eliminar
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
                    cargarTablaActivos(idDevolucion)

                } else {
                    mensaje(response.error || 'No se pudo agregar el activo.', 'danger');
                }
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





        $(document).off('click', '.btn-eliminar-activo').on('click', '.btn-eliminar-activo', function(e) {
                e.preventDefault();

                const $btn = $(this);

                // Evitar clicks múltiples
                if ($btn.data('processing')) return;

                const idActivo = $btn.data('id-activo');
                const idDevolucion = $btn.data('id-devolucion');

                if (!idActivo || !idDevolucion) {
                    mensaje('Faltan datos: no se pudo identificar el devolucion o el activo.', 'warning');
                    return;
                }

                $btn.data('processing', true).prop('disabled', true);

                $.ajax({
                    url: `${baseUrl}/devolucion/${idDevolucion}/activos/eliminar`,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id_activo: idActivo
                    },
                    success: function(response) {
                        if (response.success) {
                            mensaje(response.message, 'success');

                            const $tdBoton = $('#modalInventario')
    .find(`tr[data-id-activo="${idActivo}"]`)
    .find('button') // buscar el botón dentro de ese tr
    .closest('td'); // obtener el td que lo contiene

                $tdBoton.html(`
                    <button class="btn btn-sm btn-outline-primary btn_agregar_activo"
                        data-id="${idActivo}">
                        Agregar
                    </button>
                `);
                            

                            // Recargar tabla principal si tienes
                            cargarTablaActivos();

                        } else {
                            mensaje(response.error || 'No se pudo eliminar el activo.',
                                'danger');
                        }
                    },
                    error: function(xhr) {
                        const msg = xhr.responseJSON?.error ||
                            'Ocurrió un error al eliminar el activo.';
                        mensaje(msg, 'danger');
                        console.error(xhr.responseText);
                    },
                    complete: function() {
                        $btn.data('processing', false).prop('disabled', false);
                    }
                });
            });












      $('#overlayComentario').off('click', '#btnGuardarComentario').on('click', '#btnGuardarComentario', function() {
    const comentario = $('#textareaComentario').val();
    const idActivo = filaActual.data('id-activo');
    // console.log(`${baseUrl}/devolucion/${devolucion_id}/activos/editar`);

    $.post(`${baseUrl}/devolucion/${devolucion_id}/activos/editar`, {
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
            let mensaje2 = 'Ocurrió un error al guardar la observación.';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                mensaje2 = xhr.responseJSON.error;
            }
            mensaje(mensaje2, 'danger');
        });
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
