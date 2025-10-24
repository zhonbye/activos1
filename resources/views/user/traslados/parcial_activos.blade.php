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
                    <button type="button" class="btn btn-sm rounded-circle p-0 btn-ver-detalle-principal"
                        data-id-activo="{{ $detalle->id_activo }}" data-nombre="{{ $detalle->activo->nombre }}"
                        data-cantidad-actas="{{ count($detalle->actas_info) }}"
                        data-actas='@json($detalle->actas_info)' title="Ver detalles">
                        <i class="bi bi-info-circle"></i>
                    </button>

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

                $(document).off('click', '.btn-ver-detalle-principal').on('click', '.btn-ver-detalle-principal', function(e) {
                            e.preventDefault();

                            const $btn = $(this);
                            if ($btn.data('processing')) return;
                            $btn.data('processing', true);

                            const idActivo = $btn.data('id-activo');
                            const nombreActivo = $btn.data('nombre');
                            const actas = $btn.data('actas') || [];

                            // Obtener traslado actual desde el input hidden
                            const idTrasladoActual = parseInt($('#id_traslado').val()) || null;
                            //  alert($('#id_traslado').val())
                            // Actualizar encabezado del modal
                            $('#modalActivoNombre').text(nombreActivo);
                            $('#modalActivoCantidad').text(''); // limpiar al abrir

                            const $wheel = $('#actasWheel');
                            $wheel.empty(); // limpiar lista anterior

                            if (actas.length === 0) {
                                $wheel.append('<li class="text-muted">No hay actas registradas</li>');
                            } else {
                                actas.forEach(a => {
                                    const isSelected = idTrasladoActual && idTrasladoActual === a.id_traslado ?
                                        'selected' : '';
                                    $wheel.append(`
            <li class="${isSelected}"
                data-id-traslado="${a.id_traslado}"
                data-num-documento="${a.numero_documento}"
                data-cantidad="${a.cantidad || 1}">
                ${a.numero_documento}
            </li>
        `);

                                    // Si coincide con el traslado actual, mostrar su cantidad
                                    if (isSelected) {
                                        $('#modalActivoCantidad').text(`Cantidad: ${a.cantidad || 1}`);
                                    }
                                });
                            }

                            // Mostrar modal
                            $('#modalDetalleActivos').modal('show');

                            // Acción al hacer click en un número de documento
                            $wheel.find('li').off('click').on('click', function() {
                                $wheel.find('li').removeClass('selected');
                                $(this).addClass('selected');

                                const cantidad = $(this).data('cantidad') || 1;
                                $('#modalActivoCantidad').text(`Cantidad: ${cantidad}`);
                            });

                            // Reset al cerrar el modal
                            $('#modalDetalleActivos').off('hidden.bs.modal').on('hidden.bs.modal', function() {
                                $wheel.empty();
                                $('#modalActivoCantidad').text('');
                            });

                            $btn.data('processing', false);









                            const $tr = $('#modalInventario').find(
                                `tr[data-id-activo="${idActivo}"]`);

                            if ($tr.length) {
                                // Encontrar el span que contiene la cantidad
                                const $spanCantidad = $tr.find('span[data-cantidad-restante]');

                                if ($spanCantidad.length === 0) {
                                    console.warn(
                                        'No se encontró el span con data-cantidad-restante en esta fila'
                                    );
                                    return;
                                }

                                // Tomamos la cantidad actual desde el atributo data
                                let cantidadActual = parseInt($spanCantidad.data(
                                    'cantidad-restante')) || 0;

                                // Sumar la cantidad eliminada
                                const cantidadNueva = cantidadActual + (response
                                    .cantidad_eliminada || 0);

                                // Actualizamos el span con data-cantidad-restante y texto correcto
                                if (cantidadNueva > 0) {
                                    $spanCantidad
                                        .attr('data-cantidad-restante', cantidadNueva)
                                        .removeClass('text-danger')
                                        .addClass('text-success')
                                        .text(
                                            `${cantidadNueva} disponible${cantidadNueva > 1 ? 's' : ''}`
                                        );
                                } else {
                                    $spanCantidad
                                        .attr('data-cantidad-restante', 0)
                                        .removeClass('text-success')
                                        .addClass('text-danger')
                                        .text('Sin disponibilidad');
                                }

                            }
                            });

                        // Botón de “Seleccionar acta”
                        $('#btnSeleccionarActa').on('click', function() {
                            const seleccionado = $('#actasWheel li.selected');
                            if (seleccionado.length === 0) {
                                alert('Seleccione un acta');
                                return;
                            }
                            const idTraslado = seleccionado.data('id-traslado');
                            const numeroDoc = seleccionado.data('num-documento');
                            alert(`Seleccionaste el acta ${numeroDoc} del traslado ${idTraslado}`);
                        });









                        $(document).off('click', '.btn-eliminar-activo')
                        .on('click', '.btn-eliminar-activo', function(e) {
                            e.preventDefault();

                            const $btn = $(this);

                            // Evitar clicks múltiples
                            if ($btn.data('processing')) return;

                            const idActivo = $btn.data('id-activo');
                            const idTraslado = $btn.data('id-traslado');

                            if (!idActivo || !idTraslado) {
                                mensaje('Faltan datos: no se pudo identificar el traslado o el activo.', 'warning');
                                return;
                            }

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

                                        // Actualizar la fila de inventario en el modal
                                        const $tr = $('#modalInventario').find(
                                            `tr[data-id-activo="${idActivo}"]`);

                                        if ($tr.length) {
                                            // Encontrar el span que contiene la cantidad
                                            const $spanCantidad = $tr.find(
                                                'span[data-cantidad-restante]');

                                            if ($spanCantidad.length === 0) {
                                                console.warn(
                                                    'No se encontró el span con data-cantidad-restante en esta fila'
                                                );
                                                return;
                                            }

                                            // Tomamos la cantidad actual desde el atributo data
                                            let cantidadActual = parseInt($spanCantidad.data(
                                                'cantidad-restante')) || 0;

                                            // Sumar la cantidad eliminada
                                            const cantidadNueva = cantidadActual + (response
                                                .cantidad_eliminada || 0);

                                            // Actualizamos el span con data-cantidad-restante y texto correcto
                                            if (cantidadNueva > 0) {
                                                $spanCantidad
                                                    .attr('data-cantidad-restante', cantidadNueva)
                                                    .removeClass('text-danger')
                                                    .addClass('text-success')
                                                    .text(
                                                        `${cantidadNueva} disponible${cantidadNueva > 1 ? 's' : ''}`
                                                    );
                                            } else {
                                                $spanCantidad
                                                    .attr('data-cantidad-restante', 0)
                                                    .removeClass('text-success')
                                                    .addClass('text-danger')
                                                    .text('Sin disponibilidad');
                                            }

                                            // Reemplazar botón por "Agregar" solo si hay stock
                                            const $tdBoton = $tr.find('button').closest('td');
                                            if (cantidadNueva > 0) {
                                                $tdBoton.html(`
                                <button class="btn btn-sm btn-outline-primary btn_agregar_activo"
                                    data-id="${idActivo}"
                                    data-cantidad-restante="${cantidadNueva}">
                                    Agregar
                                </button>
                            `);
                                            } else {
                                                // Opcional: si no hay stock, puedes poner un botón deshabilitado o de "Revisar"
                                                                                    $tdBoton.html(`
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-ver-detalle"
                                                    data-id-activo="${idActivo}">
                                                    Revisar
                                                </button>
                                            `);
                                            }
                                        }

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








                        $('#overlayComentario').off('click', '#btnGuardarComentario').on('click',
                            '#btnGuardarComentario',
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


                        $(document).off('change', '.chk-editar-cantidad').on('change', '.chk-editar-cantidad',
                        function() {
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
    $(this).data('valor-original', parseInt($(this).val()) || 0);
});





$(document).off('blur', '.cantidad-activo').on('blur', '.cantidad-activo', function() {
    const input = $(this);
    const idActivo = input.data('id-activo');
    const valorOriginal = parseInt(input.data('valor-original')) || 0;
    const valorActual = parseInt(input.val()) || 0;

    if (valorActual === valorOriginal) return; // No cambió

    const $spanCantidad = $(`tr[data-id-activo="${idActivo}"]`).find('span[data-cantidad-restante]');
    if ($spanCantidad.length === 0) {
        console.warn('No se encontró el span con data-cantidad-restante');
        return;
    }

    // Tomamos la cantidad original total disponible + la cantidad original seleccionada
    // Esto evita que se acumulen cambios
    let cantidadTotal = parseInt($spanCantidad.data('cantidad-total')) || 0;
    if (!cantidadTotal) {
        // Si no existe, lo inicializamos: total = disponible + seleccionada
        cantidadTotal = parseInt($spanCantidad.data('cantidad-restante')) + valorOriginal;
        $spanCantidad.attr('data-cantidad-total', cantidadTotal);
    }

    // Nueva cantidad disponible
    let cantidadRestante = cantidadTotal - valorActual;
    if (cantidadRestante < 0) cantidadRestante = 0;

    // Actualizamos el span
    $spanCantidad
        .attr('data-cantidad-restante', cantidadRestante)
        .removeClass('text-success text-danger')
        .addClass(cantidadRestante > 0 ? 'text-success' : 'text-danger')
        .text(cantidadRestante > 0 ? `${cantidadRestante} disponible${cantidadRestante > 1 ? 's' : ''}` : 'Sin disponibilidad');

    // Actualizamos valor original del input para la próxima edición
    input.data('valor-original', valorActual);

    // Enviar al servidor
    const traslado_id = $('input[name="id_traslado"]').val();
    $.post(`${baseUrl}/traslados/${traslado_id}/activos/editar`, {
        id_activo: idActivo,
        cantidad: valorActual,
        _token: $('meta[name="csrf-token"]').attr('content')
    }, function(res) {
        if (!res.success) {
            console.warn('Error al actualizar cantidad');
            // Revertimos cambios si hay error
            input.val(valorOriginal);
            let revertCantidad = cantidadTotal - valorOriginal;
            $spanCantidad.attr('data-cantidad-restante', revertCantidad)
                         .text(revertCantidad > 0 ? `${revertCantidad} disponible` : 'Sin disponibilidad');
        }
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
