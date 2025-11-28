<table class="table table-striped" id="tabla_activos">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Detalle</th>
            <th>Estado</th>
            <th>Unidad</th>
            {{-- <th>Cantidad</th> --}}
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
                    $cantidadEntrega = $detalle->cantidad;
                @endphp --}}

                {{-- <td> --}}
                    {{-- {{ $detalle->cantidad_usada}}  --}}
                    {{-- {{ $detalle->cantidad_disponible-$detalle->cantidad_usada+$detalle->cantidad_en_acta }}  --}}
                    {{-- {{$detalle->cantidad_disponible}} --}}
                    {{-- @if ($detalle->cantidad_disponible > 1)
                        <div class="d-flex align-items-center gap-2">
                            <input disabled type="number" class="form-control form-control-sm cantidad-activo"
                                data-id-activo="{{ $detalle->id_activo }}" value="{{ $detalle->cantidad_en_acta }}"
                                min="1"
                                max="{{ $detalle->cantidad_disponible - $detalle->cantidad_usada + $detalle->cantidad_en_acta }}"
                                style="width:80px;">

                            <div class="form-check mb-0">
                                <input type="checkbox" class="form-check-input chk-editar-cantidad"
                                    data-id-activo="{{ $detalle->id_activo }}" id="chk_{{ $detalle->id_activo }}"
                                    {{ $detalle->cantidad_disponible > 1 ? '' : 'disabled' }}>
                                <label class="form-check-label" for="chk_{{ $detalle->id_activo }}">Editar</label>
                            </div>
                        </div>
                    @else --}}
                        {{-- <span class="fw-semibold">{{ $detalle->cantidad }}</span>
                    @endif
                </td> --}}



                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-activo"
                        data-id-activo="{{ $detalle->id_activo }}" data-id-entrega="{{ $detalle->id_entrega }}">
                        <i class="bi bi-trash"></i>
                    </button>

                    <button type="button" class="btn btn-sm btn-secondary btn-comentar">
                        <i class="bi bi-chat-dots"></i>
                    </button>


                    <input type="hidden" class="comentario-activo" value="{{ $detalle->observaciones }}">
                    {{-- <button type="button" class="btn btn-lg rounded-circle p-0 btn-ver-detalle-principal border-0"
                        data-id-activo="{{ $detalle->id_activo }}" data-nombre="{{ $detalle->activo->nombre }}"
                        data-cantidad-actas="{{ count($detalle->actas_info) }}"
                        data-actas='@json($detalle->actas_info)' title="Ver detalles">
                        <i class="bi bi-info-circle"></i>
                    </button> --}}

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

        var filaActual = null;
        const entrega_id = $('#entrega_id').val();
        var debounceTimeout;
        // const baseUrl = '';










    $(document).off('click', '.btn-eliminar-activo').on('click', '.btn-eliminar-activo', function(e) {
    e.preventDefault();

    const $btn = $(this);

    // Evitar clicks múltiples
    if ($btn.data('processing')) return;

    const idActivo = $btn.data('id-activo');
    const idEntrega = $btn.data('id-entrega');

    if (!idActivo || !idEntrega) {
        mensaje('Faltan datos: no se pudo identificar el entrega o el activo.', 'warning');
        return;
    }

    $btn.data('processing', true).prop('disabled', true);

    $.ajax({
        url: `${baseUrl}/entregas/${idEntrega}/activos/eliminar`,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id_activo: idActivo
        },
        success: function(response) {
            if (response.success) {
                mensaje(response.message, 'success');

                // Reemplazar el botón de Eliminar por el de Agregar
                    // const $tr =
                const $tdBoton = $('.modal tbody')
    .find(`tr[data-id-activo="${idActivo}"]`)
    .find('button') // buscar el botón dentro de ese tr
    .closest('td'); // obtener el td que lo contiene

                $tdBoton.html(`
                    <button class="btn btn-sm btn-outline-primary btn_agregar_activo"
                        data-id="${idActivo}">
                        Agregar
                    </button>
                `);

                // Opcional: refrescar tabla principal si quieres
                cargarTablaActivos();
  // 🔥 NUEVO: actualizar stock dinámico
  cargarDetalleStock();
            } else {
                mensaje(response.error || 'No se pudo eliminar el activo.', 'danger');
            }
        },
        error: function(xhr) {
            const msg = xhr.responseJSON?.error || 'Ocurrió un error al eliminar el activo.';
            mensaje(msg, 'danger');
            console.error(xhr.responseText);
        },
        complete: function() {
            $btn.data('processing', false).prop('disabled', false);
        }
    });
});









$(document).off('click', '.btn_agregar_activo')
    .on('click', '.btn_agregar_activo', function(e) {
        e.preventDefault();

        const $btn = $(this);
        if ($btn.data('processing')) return;

        const idActivo = $btn.data('id');
        const idEntrega = $('#btn_editar_entrega').data('id');

        if (!idEntrega) {
            mensaje('No se encontró el ID del entrega.', 'warning');
            return;
        }

        if (!idActivo) {
            mensaje('No se encontró el ID del activo.', 'warning');
            return;
        }

        $btn.data('processing', true).prop('disabled', true);

        $.ajax({
            url: `${baseUrl}/entregas/${idEntrega}/activos/agregar`,
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
                                    data-id-entrega="${idEntrega}">
                                Eliminar
                            </button>
                        `);
                        $btnAgregar.replaceWith($btnEliminar);
                    }
                    cargarTablaActivos(idEntrega)
                    cargarDetalleStock()
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




















        $('#overlayComentario').off('click', '#btnGuardarComentario').on('click',
            '#btnGuardarComentario',
            function() {
                const comentario = $('#textareaComentario').val();
                const idActivo = filaActual.data('id-activo');
                console.log(`${baseUrl}/entregas/${entrega_id}/activos/editar`);

                $.post(`${baseUrl}/entregas/${entrega_id}/activos/editar`, {
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


        // $(document).off('change', '.chk-editar-cantidad').on('change', '.chk-editar-cantidad',
        //     function() {
        //         const idActivo = $(this).data('id-activo');
        //         const inputCantidad = $(`.cantidad-activo[data-id-activo="${idActivo}"]`);

        //         if (this.checked) {
        //             if (confirm("Está seguro que desea cambiar la cantidad?")) {
        //                 inputCantidad.prop('disabled', false);
        //             } else {
        //                 this.checked = false;
        //             }
        //         } else {
        //             inputCantidad.prop('disabled', true);
        //         }
        //     });

        // Guardar cantidad cuando se cambia
        // let debounceTimeout;  // Declárala una vez en el scope global o superior


        // $(document).off('focus', '.cantidad-activo').on('focus', '.cantidad-activo', function() {
        //     $(this).data('valor-original', parseInt($(this).val()) || 0);
        // });








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
