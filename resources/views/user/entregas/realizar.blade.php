<style>
    /* Card minimizado: solo mostrar botón, sin padding ni margen extra */
</style>




<div class="row  p-0 mb-4 pb-4 " style="height: 90vh;">















    <div class="sidebar-wrapper col-md-12 col-lg-2 order-lg-2 order-2 d-flex flex-column pb-2 gap-3 transition"

        style=" max-height: 95vh;">
        {{-- <div class="sidebar-col col-md-12 col-lg-2 order-lg-2 order-2 transition h-100"> --}}
        {{-- <div class="sidebar-col order-lg-2 order-2 transition h-100"> --}}
        {{-- <div class="sidebar-card card h-auto bg-light mt-4 shadow p-3 text-nowrap overflow-hidden" style="height: 300px;"> --}}
        <div class="sidebar-col card p-3">
            <div class="sidebar-header d-flex justify-content-between align-items-start">
                <button class="toggleSidebar btn btn-primary">⮞</button>
                <h2 class="sidebar-title fs-5 text-fw mb-0 ms-2">Acta</h2><br>
            </div>
            <h3>Buscar acta</h3>
            <div class="row g-2 align-items-center my-1">
                <div class="col-md-6">
                    <input type="number" id="numero_acta_buscar" name="numero_acta_buscar"
                        class="form-control input-form con-ceros" placeholder="Número de Acta"
                        value="{{ $ultimoNumero ?? 001 }}" required>
                </div>

                <div class="col-md-6">
                    <input type="number" id="gestion_acta_buscar" class="form-control input-form"
                        value="{{ date('Y') }}" placeholder="Gestión (Ej. 2025)" required>
                </div>
            </div>
            <div class="row g-2 align-items-center my-1">

                <div class="col-md-12">
                    <button class="btn btn-outline-primary w-100" id="btn_buscar_acta" type="button">Buscar
                        Acta</button>
                </div>
            </div>
            {{-- Resultado de la búsqueda --}}
            <div class="resultado_busqueda_acta resultado overflow-auto mt-4"
                style="display: none; max-height: 300px; max-width: 100%; width: 100%;">
                <div class="alert alert-success text-break" role="alert" style="min-width: 0; white-space: normal;">

                    <strong>Acta encontrada:</strong>

                    <div class="mt-3">
                        <p class="mb-1"><strong>Estado:</strong> <span id="acta_estado" class="text-break"></span></p>
                        <p class="mb-1"><strong>Número:</strong> <span id="acta_numero"
                                class="text-break">12345</span></p>
                        <p class="mb-1"><strong>Gestión:</strong> <span id="acta_gestion"
                                class="text-break">2025</span></p>
                        <p class="mb-1"><strong>Fecha:</strong> <span id="acta_fecha"
                                class="text-break">2025-09-10</span></p>
                        <p class="mb-1"><strong>Servicio:</strong> <span id="acta_servicio" class="text-break"></span>
                        </p>
                        <p class="mb-1"><strong>Responsable:</strong> <span id="acta_responsable"
                                class="text-break"></span></p>
                        <p class="mb-1"><strong>Detalle:</strong> <span id="acta_detalle" class="text-break">Algo
                                aquí</span></p>
                    </div>

                </div>
            </div>

        </div>
        <div class="sidebar-col card p-3">
            <div class="sidebar-header d-flex justify-content-between align-items-start">
                <button class="toggleSidebar btn btn-primary">⮞</button>
                <h2 class="sidebar-title fs-5 text-fw mb-0 ms-2">Inventario</h2><br>
            </div>
            <h3>Buscar Inventario</h3>
            <div class="row g-2 align-items-center my-1">
                <div class="col-md-6">
                    <input type="number" id="numero_acta_buscar" class="form-control input-form con-ceros"
                        placeholder="Número de Acta" value="002" required>
                </div>

                <div class="col-md-6">
                    <input type="number" id="gestion_acta_buscar" class="form-control input-form"
                        value="{{ date('Y') }}" placeholder="Gestión (Ej. 2025)" required>
                </div>
            </div>
            <div class="row g-2 align-items-center my-1">

                <div class="col-md-12">
                    <button class="btn btn-outline-primary w-100" id="btn_buscar_acta" type="button">Buscar
                        Acta</button>
                </div>
            </div>
            {{-- Resultado de la búsqueda --}}
            <div class="resultado_busqueda_actaa resultado overflow-auto mt-4"
                style="display: none; max-height: 300px; max-width: 100%; width: 100%;">
                <div class="alert alert-success text-break" role="alert" style="min-width: 0; white-space: normal;">

                    <strong>Acta encontrada:</strong>

                    <div class="mt-3">
                        <p class="mb-1"><strong>Estado:</strong> <span id="acta_estado" class="text-break"></span></p>
                        <p class="mb-1"><strong>Número:</strong> <span id="acta_numero"
                                class="text-break">12345</span></p>
                        <p class="mb-1"><strong>Gestión:</strong> <span id="acta_gestion"
                                class="text-break">2025</span></p>
                        <p class="mb-1"><strong>Fecha:</strong> <span id="acta_fecha"
                                class="text-break">2025-09-10</span></p>
                        <p class="mb-1"><strong>Servicio:</strong> <span id="acta_servicio" class="text-break"></span>
                        </p>
                        <p class="mb-1"><strong>Responsable:</strong> <span id="acta_responsable"
                                class="text-break"></span></p>
                        <p class="mb-1"><strong>Detalle:</strong> <span id="acta_detalle" class="text-break">Algo
                                aquí</span></p>
                    </div>

                </div>
            </div>

        </div>

    </div>




    {{-- <div class="main-col col-md-12 col-lg-10 text-white order-lg-1 order-1 transition"> --}}
    <div class="main-col col-md-12 col-lg-10 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;">
        <div class="card  p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 100vh;">
            <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Realizar entrega</h2>
            <div id="alerta_estado_finalizado" class="alert alert-danger d-none text-center fw-bold" role="alert">
                ❌ Esta acta ya fue finalizada y no se puede modificar.
            </div>
<div id="numero_entrega" class="fs-2 fw-bold text-end">
        N° {{ $datosEntrega['numero_documento'] ?? 'N/A' }}
    </div>
            <form id="form_detalle_entrega" method="POST">
                @csrf
                <input type="hidden" id="acta_id" name="acta_id" value="">
                <div class="row g-3 align-items-center">

                    <div class="col-lg-12 col-md-6 d-flex justify-content-end align-items-center gap-3 mb-3">

                    </div>
                    <!-- Gestión oculta -->
                    <input type="hidden" id="gestion" data-label="gestion"
                        value="{{ $datosEntrega['gestion'] ?? '' }}">
                    <input type="hidden" id="id_entrega" value="{{ $datosEntrega['id_entrega'] ?? '' }}">
                    <!-- Fecha -->

                    {{-- <hr> --}}
                    <div class="col-12 mt-4" id="div_inventario">
                        <h5>Último Inventario</h5>
                        <div class="card shadow-sm mb-3">
                            <div
                                class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0" id="numero_inventario">...</h5>
                                <div>
                                    <span class="badge bg-light text-dark me-2"
                                        id="gestion_inventario">{{ Date('Y') }}</span>
                                    <!-- Botón de minimizar -->
                                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#cardBodyInventario" aria-expanded="true"
                                        aria-controls="cardBodyInventario">
                                        ⮟
                                    </button>
                                </div>
                            </div>

                            <div id="cardBodyInventario" class="collapse show">
                                <div class="card-body">
                                    <div class="row g-3 ">
                                        <div class="col-6 col-md-3">
                                            <div class="border p-2 rounded text-center h-100">
                                                <strong>Responsable</strong><br>
                                                <span id="responsable_inventario">No se encontró</span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="border p-2 rounded text-center h-100">
                                                <strong>Fecha</strong><br>
                                                <span id="fecha_inventario">...</span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2">
                                            <div class="border p-2 rounded text-center h-100">
                                                <strong>Cantidad Activos</strong><br>
                                                <span id="cantidad_activos">0</span>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="border p-2 rounded text-center">
                                                <strong>Observaciones</strong><br>
                                                <span id="observaciones_inventario">No se encontró</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    {{-- {{-- <button class="btn btn-sm btn-primary me-2" id="btn_ver_detalles">Ver Detalles</button> --}}
                                    <button class="btn btn-sm btn-outline-success"
                                        id="recargar_inventario">Recargar</button>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-5 col-md-12 order-1">
                            <!-- Agregar Activo -->
                            <div class="col-6 mt-4">
                                <h5>Agregar Activo a la Entrega</h5>
                                <div class="input-group mb-3">
                                    <input type="text" id="input_activo_codigo" class="form-control"
                                        placeholder="Código o nombre del activo">
                                    <button type="button" id="btn_agregar_activo"
                                        class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 order-1"></div>

                        <div
                            class="col-md-12 col-lg-4 mt-4 mt-lg-0 d-flex flex-lg-nowrap flex-wrap justify-content-end align-items-center gap-1 order-3 order-lg-2">
                            <!-- Botones -->
                            <button type="submit" id="btn_entregar"
                                class="btn btn-success w-100 w-lg-50 text-nowrap">
                                Entregar y Añadir a Inventario
                            </button>
                            <button type="button" id="btn_guardar_activos"
                                class="btn btn-sm btn-primary w-100 w-lg-auto text-nowrap">
                                guardar borrador
                            </button>
                            <button type="button" id="btnImprimir"
                                class="btn btn-sm btn-primary w-100 w-lg-auto text-nowrap">
                                Imprimir
                            </button>
                            <button type="reset" class="btn btn-sm btn-danger w-20 w-lg-auto text-nowrap">
                                Limpiar
                            </button>
                        </div>

                        <div class="col-12 mt-4 order-2 order-lg-3">
                            <!-- Lista de activos -->
                            <h5>Activos vinculados a esta entrega</h5>
                            <table class="table table-striped" id="tabla_activos">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Cantidad</th>
                                        <th>Unidad</th>
                                        <th>Nombre</th>
                                        <th>Detalle</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="body_activos">
                                    {{-- @forelse ($detallesActivos as $detalle) --}}

                                    {{-- @empty --}}
                                    <tr id="fila_vacia">
                                        <td colspan="6" class="text-center text-muted">No hay activos agregados
                                        </td>

                                    </tr>
                                    {{-- @endforelse --}}
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </form>

            <div id="overlayComentario"
                class="position-fixed top-50 start-50 translate-middle bg-light border rounded shadow p-4"
                style="z-index:1050; width:400px; max-width:90%; display:none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Comentario</h5>
                    <button type="button" class="btn-close cerrarComentario" aria-label="Cerrar"></button>
                </div>
                <textarea id="textareaComentario" class="form-control mb-3" rows="5" placeholder="Escribe tu comentario..."></textarea>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-success btn-sm" id="guardarComentario">Guardar</button>
                    <button type="button" class="btn btn-secondary btn-sm cerrarComentario">Cerrar</button>
                </div>
            </div>



        </div>
    </div>

</div>
<script>
    var id_servicio = 0;
    var id_entrega = 0;
    var id_inventario = 0;
    $(document).ready(function() {
        // Ejecuta automáticamente la búsqueda al cargar la página
        $('#btn_buscar_acta').trigger('click');


    });



//este boton entrega toda la acta. añade el detalle entrega  actualiza el inventario y finaliza la entrega
    $('#btn_entregar').on('click', function () {
    const activos = [];
alert("entrega  botno")
    $('#body_activos tr').each(function () {
        const $fila = $(this);
        if ($fila.attr('id') !== 'fila_vacia') {
            const id = $fila.find('.cantidad-activo').data('id-detalle');
            const id_activo = $fila.find('.cantidad-activo').data('id-activo');
            const cantidad = parseInt($fila.find('.cantidad-activo').val()) || 0;
            const comentario = $fila.find('.comentario-activo').val().trim();

            activos.push({
                id,
                id_activo,
                cantidad,
                comentario
            });
        }
    });

    if (!activos.length) {
        mensaje('No hay activos para guardar.', 'warning');
        return;
    }

    $.ajax({
        url: baseUrl + '/entregas/guardar-entrega-realizada',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            entrega_id: id_entrega,
            inventario_id: id_inventario, // esta variable debe estar definida en tu script
            activos: activos
        }),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (res) {
            mensaje(res.message || 'Guardado correctamente', 'success');
            cargarActivos(id_entrega); // recargar activos
            $('#recargar_inventario').trigger('click'); // recargar la vista de inventario
            $('#btn_buscar_acta').trigger('click'); // recargar la vista de inventario
        },
        error: function (xhr) {
            let textoError = 'Error inesperado en el servidor.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                textoError = xhr.responseJSON.message;
            }
            mensaje(textoError, 'danger');
        }
    });
});














    $(document).on('click', '.btn-eliminar-activo', function() {
        // confirm("fdsaf")
        if (confirm("Se eliminará el activo de la lista.")) {

            const id = $(this).data('id-activo'); // <- aquí debe coincidir con tu HTML
            $(`tr[data-id-activo="${id}"]`).remove();

            if ($('#body_activos tr').length === 0) {
                $('#body_activos').append(`
                <tr id="fila_vacia">
                    <td colspan="7" class="text-center text-muted">No hay activos agregados</td>
                    </tr>
                    `);
            }
        }
    });





    $('#btn_guardar_activos').on('click', function() {
        const activos = [];

        $('#body_activos tr').each(function() {
            const $fila = $(this);
            if ($fila.attr('id') !== 'fila_vacia') {
                const id = $fila.find('.cantidad-activo').data('id-detalle'); // ID del detalle
                const id_activo = $fila.find('.cantidad-activo').data('id-activo'); // ID del activo
                const cantidad = parseInt($fila.find('.cantidad-activo').val()) || 0;
                const comentario = $fila.find('.comentario-activo').val().trim();

                // para depuración
                // alert(comentario);
                activos.push({
                    id,
                    id_activo,
                    cantidad,
                    comentario
                });
            }
        });

        if (!activos.length) {
            mensaje('No hay activos para guardar.', 'warning');
            return;
        }

        $.ajax({
            url: baseUrl + '/entregas/guardar-activos',
            type: 'POST',
            contentType: 'application/json', // enviamos JSON
            data: JSON.stringify({
                entrega_id: id_entrega,
                activos: activos

            }),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // token CSRF
            },
            dataType: 'json',
            success: function(res) {
                mensaje(res.message || 'Cambios guardados correctamente', 'success');
                cargarActivos(id_entrega); // recargar lista
            },
            error: function(xhr) {
                let textoError = 'Error inesperado en el servidor.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    textoError = xhr.responseJSON.message;
                }
                mensaje(textoError, 'danger');
            }
        });
    });





    function cargarActivos(entregaId) {
        $.ajax({
            url: baseUrl + `/entregas/${entregaId}/activos`,
            type: 'GET',
            dataType: 'json',
            success: function(detalles) {
                const $tbody = $('#body_activos');
                $tbody.empty();

                if (!detalles.length) {
                    $tbody.append(`
                    <tr id="fila_vacia">
                        <td colspan="7" class="text-center text-muted">No hay activos agregados</td>
                    </tr>
                `);
                    return;
                }

                detalles.forEach(det => {
                    $tbody.append(`
                    <tr id="fila_${det.id_detalle}" data-id-detalle="${det.id_detalle}" data-id-activo="${det.id_activo}">
                        <td>${det.codigo}</td>
                        <td>
                            <input type="number" class="form-control form-control-sm cantidad-activo"
                                data-id-detalle="${det.id_detalle}" data-id-activo="${det.id_activo}"
                                value="${det.cantidad}" min="1">
                        </td>
                        <td>${det.unidad}</td>
                        <td>${det.nombre}</td>
                        <td>${det.detalle || ''}</td>
                        <td>${det.estado}</td>
                        <td>
                            <button type="button"   class="btn btn-danger btn-sm btn-eliminar-activo"
                                data-id-detalle="${det.id_detalle}" data-id-activo="${det.id_activo}">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary btn-comentar">💬</button>
                            <input type="hidden"  class="comentario-activo" value="${det.comentario}">
                        </td>


                    </tr>
                `);
                });
            },
            error: function(xhr) {
                console.error('Error al cargar activos:', xhr);
            }
        });
    }



    var filaActual = null; // fila que está editando comentario

    // Abrir textarea flotante
    $(document).on('click', '.btn-comentar', function() {
        filaActual = $(this).closest('tr');
        const comentario = filaActual.find('.comentario-activo').val();
        $('#textareaComentario').val(comentario);
        $('#overlayComentario').show();
        $('#textareaComentario').focus();
    });

    // Guardar comentario
    $('#guardarComentario').on('click', function() {
        const texto = $('#textareaComentario').val().trim();
        if (filaActual) {
            filaActual.find('.comentario-activo').val(texto);
        }
        $('#overlayComentario').hide();
    });

    // Cerrar sin guardar
    $('.cerrarComentario').on('click', function() {
        $('#overlayComentario').hide();
    });
    // $('#textareaComentario').blur(function() {
    //     // alert("fdsfdsfdsfdsak")
    //     $('#overlayComentario').hide();
    // });








    $('#recargar_inventario').on('click', function() {
        // const id_servicio = $('#numero_acta_buscar').val();
        botonOff($(this));
        // alert(id_entrega)
        // console.log(id_entrega)
        // setTimeout(() => {

        //     console.log(id_entrega)

        // }, 4000);
        $.ajax({
            url: baseUrl + '/inventario/ultimo',
            type: 'GET',
            dataType: 'json',
            data: {
                servicio_id: id_servicio
            },
            success: function(data) {
                if (data) {
                    id_inventario= data.id_inventario
                    $('#numero_inventario').text(data.numero_documento ?? '...');
                    $('#gestion_inventario').text(data.gestion ?? '...');
                    $('#responsable_inventario').text(data.nombre_responsable ?? 'No se encontró');
                    $('#fecha_inventario').text(data.fecha ?? '...');
                    $('#cantidad_activos').text(data.cantidad_activos ?? 0);
                    $('#observaciones_inventario').text(data.observaciones ?? 'No se encontró');

                    // Puedes acceder a otros campos completos del inventario
                    // console.log(data); // Para ver todos los datos que devuelve el JSON
                } else {
                    $('#numero_inventario').text('...');
                    $('#responsable_inventario').text('No se encontró');
                    $('#fecha_inventario').text('...');
                    $('#cantidad_activos').text(0);
                    $('#observaciones_inventario').text('No se encontró');
                }
            },
            error: function(xhr, status, error) {
                mensaje('Error al obtener inventario:' + error, 'danger');
            }
        });


    });
    $('#btn_buscar_acta').on('click', function() {
        const numero = $('#numero_acta_buscar').val();
        const gestion = $('#gestion_acta_buscar').val();

        if (!numero || !gestion) {
            mensaje("Debe ingresar número, gestión y tipo de acta", "danger");
            return;
        }
        botonOff($(this));
        $.ajax({
            // url: `${baseUrl}/actas/buscar/${tipo}/${numero}/${gestion}`,
            url: baseUrl + '/actas/get-datos',
            method: 'GET',
            dataType: 'json',
            data: {
                numero_documento: numero,
                gestion: gestion,
                // _token: '{{ csrf_token() }}' // si usas Laravel
            },
            success: function(response) {

                if (response.datosEntrega) {
                    const acta = response.datosEntrega;
                    id_servicio = acta.id_servicio;
                    id_entrega = acta.id_entrega;
                    // alert(acta.id_servicio)
                    // alert(id_servicio)
                    const estado = acta.estado || 'N/A';
                    if (acta.estado && acta.estado.toLowerCase().replace(/\s/g, '').includes(
                            "finalizado")) {

                        $('#acta_estado')
                            .text(acta.estado)
                            .css('color', 'red');
                    } else {
                        $('#acta_estado')
                            .text('')
                            .css('color', '');
                    }

                    $('#acta_estado').text(acta.estado);
                    $('#acta_numero').text(acta.numero_documento);
                    $('#acta_gestion').text(acta.gestion);
                    $('#acta_fecha').text(acta.fecha);
                    $('#acta_servicio').text(acta.nombre_servicio);
                    $('#acta_responsable').text(acta.nombre_responsable);
                    $('#acta_detalle').text(acta.observaciones);
                    $('#numero_entrega').text('N° ' + (acta.numero_documento || 'N/A'));
                    $('.resultado_busqueda_acta').show();
                    mensaje("Acta encontrada correctamente", "success");
                    // $('#confirmar_agregar_activo').prop('checked', false);
                    // Aquí habilitas el checkbox:
                    $('#acta_id').val(acta.id_entrega);

                    cargarActivos(acta.id_entrega)
                    $('#recargar_inventario').trigger('click');
                    setTimeout(() => {

                        desactivarEntregaFinalizada($('#acta_estado').text())
                    }, 1000);

                    // $('#chk_agregar_activo').prop('disabled', false);
                } else {
                    mensaje(response.message || "Acta no encontrada", "warning");
                    $('.resultado_busqueda_acta').hide();
                    // $('#chk_agregar_activo').prop('checked', false).prop('disabled',
                    // true);
                    // $('#tipo_acta_oculto').val('');
                    $('#acta_id').val('');
                }
            },
            error: function() {
                mensaje("Error al buscar el acta", "danger");
                $('.resultado_busqueda_acta').hide();
                // $('#chk_agregar_activo').prop('checked', false).prop('disabled', true);
                $('#acta_id').val('');
                // $('#tipo_acta_oculto').val('');
            }
        });
    });

    function botonOff(btn) {
        const $boton = $(btn);
        const textoOriginal = $boton.text();

        // Guardar ancho actual
        const anchoOriginal = $boton.width();

        // Desactivar botón
        $boton.prop('disabled', true);

        let puntos = 0;
        const interval = setInterval(() => {
            puntos = (puntos % 4) + 1; // 1,2,3,4,1...
            $boton.text('.'.repeat(puntos));
            $boton.width(anchoOriginal); // mantener ancho fijo
        }, 500);

        // Después de 4 segundos, restaurar
        setTimeout(() => {
            clearInterval(interval);
            $boton.prop('disabled', false);
            $boton.text(textoOriginal);
            $boton.width(''); // limpiar ancho forzado
            desactivarEntregaFinalizada($('#acta_estado').text())
        }, 3000);
    }




    //////////////////////
    // $('#form_buscar_acta_modal').submit(function(e) {
    //     e.preventDefault();

    //     // Obtener valores del modal
    //     // let numero_acta = $('#modal_numero_acta').val().trim();
    //     // let gestion_acta = $('#modal_gestion_acta').val().trim();

    //     // alert(numero_acta + " fdsaf "+ gestion_acta)
    //     // if (!numero_acta || !gestion_acta) {
    //     //     alert('Por favor ingrese número de acta y gestión.');
    //     //     return;
    //     // }

    //     $.ajax({
    //         url: baseUrl + '/actas/get-datos',
    //         method: 'get',
    //         dataType: 'json',
    //         data: {
    //             numero_documento: numero_acta,
    //             gestion: gestion_acta,
    //             // _token: '{{ csrf_token() }}' // si usas Laravel
    //         },
    //         success: function(response) {
    //             if (response.datosEntrega) {
    //                 const datos = response.datosEntrega;

    //                 // Estado
    //                 const estado = datos.estado || 'N/A';
    //                 // $('#estado_entrega')
    //                 //     .text('Estado: ' + estado)
    //                 //     .attr('data-estado', estado);

    //                 // if (estado.toLowerCase().includes("finalizado")) {
    //                 //     $('.info').html("No se puede modificar esta acta");
    //                 // } else {
    //                 //     $('.info').html("");
    //                 // }

    //                 // Datos generales
    //                 $('#numero_entrega').text('N° ' + (datos.numero_documento || 'N/A'));
    //                 $('[data-label="fecha"]').text(datos.fecha || 'N/A');
    //                 $('[data-label="responsable"]')
    //                     .text(datos.nombre_responsable || 'N/A')
    //                     .attr('data-id', datos.id_responsable || '');
    //                 $('[data-label="gestion"]').val(datos.gestion || 'N/A');
    //                 $('#gestion').val(datos.gestion || 'N/A');
    //                 $('#id_entrega').val(datos.id_entrega || 'N/A');
    //                 $('[data-label="servicio"]')
    //                     .text(datos.nombre_servicio || 'N/A')
    //                     // ✅ LLAMADA RECOMENDADA: aquí llamas a buscarUltimoInventario()
    //                     .attr('data-id', datos.id_servicio || '');
    //                 buscarUltimoInventario();
    //                 setTimeout(() => {
    //                     actualizarEstadoFormulario()
    //                 }, 500);
    //                 $('[data-label="observaciones"]').text(datos.observaciones || 'N/A');


    //                 // Activos
    //                 const tbody = $('#tabla_activos tbody');
    //                 tbody.empty();

    //                 if (response.detallesActivos && response.detallesActivos.length > 0) {
    //                     response.detallesActivos.forEach(function(detalle) {
    //                         const fila = `
    //                     <tr>
    //                         <td>${escapeHtml(detalle.activo?.codigo) || 'N/D'}</td>
    //                         <td>
    //                             <input type="number"
    //                                    name="cantidades[${detalle.id_activo}]"
    //                                    value="${detalle.cantidad ?? 1}"
    //                                    min="1"
    //                                    class="form-control form-control-sm">
    //                         </td>
    //                         <td>${escapeHtml(detalle.activo?.unidad) || 'N/D'}</td>
    //                         <td>${escapeHtml(detalle.activo?.nombre) || 'N/D'}</td>
    //                         <td>${escapeHtml(detalle.activo?.detalle) || 'N/D'}</td>
    //                         <td>${escapeHtml(detalle.activo?.estado) || 'N/D'}</td>
    //                         <td>
    //                             <button type="button"
    //                                     class="btn btn-danger btn-sm btn-eliminar-activo"
    //                                     data-id="${detalle.id_activo}">
    //                                 Eliminar
    //                             </button>
    //                         </td>
    //                     </tr>
    //                 `;
    //                         tbody.append(fila);
    //                     });



    //                 } else {
    //                     tbody.append(`
    //                 <tr id="fila_vacia">
    //                     <td colspan="6" class="text-center text-muted">
    //                         No hay activos agregados
    //                     </td>
    //                 </tr>
    //             `);
    //                 }

    //                 // Cerrar modal
    //                 bootstrap.Modal.getOrCreateInstance(document.getElementById('modalBuscarActa'))
    //                     .hide();

    //                 mensaje("Contenido cargado", "success");

    //                 // ✅ LLAMADA RECOMENDADA: al final de todo, actualizas estado del formulario
    //                 actualizarEstadoFormulario(estado);

    //             } else if (response.error) {
    //                 alert(response.error);
    //             } else {
    //                 alert('No se encontraron datos para esa acta.');
    //             }
    //         },
    //         error: function() {
    //             alert('Error al buscar acta. Intente nuevamente.');
    //         }
    //     });


    //     // buscarUltimoInventario();
    // });




    function verEstado() {
        const estado = $('#estado_entrega').data('estado');
        if (estado === 'finalizado') {
            mensaje('No puedes modificar una entrega finalizada.', 'warning');
            e.preventDefault(); // Previene acción por si es submit
            return false; // Evita que siga la ejecución
        }
        return true;

    }

    // $('#btnImprimir').on('click', function(e) {
    //     e.preventDefault();
    //     // Obtener el año de la fecha
    //     var rutaPlantilla = 'prints/' + anio + '/entrega/plantilla.php';

    //     // 1️⃣ Datos individuales del formulario
    //     var numeroDocto = $('#numero_entrega').text().trim();
    //     var fecha = $('[data-label="fecha"]').text().trim();
    //     var responsable = $('[data-label="responsable"]').text().trim();
    //     var servicio = $('[data-label="servicio"]').text().trim();
    //     var observaciones = $('[data-label="observaciones"]').text().trim();

    //     // 2️⃣ Clonar la tabla y quitar encabezado
    //     var $tablaClon = $('#tabla_activos').clone();
    //     $tablaClon.find('thead').remove(); // quitar header
    //     $tablaClon.find('tr').each(function() {
    //         $(this).find('td').slice(6).remove(); // dejar solo las primeras 6 columnas
    //         $(this).find('td input').each(function() {
    //             var valor = $(this).val(); // obtener valor del input
    //             $(this).parent().text(valor); // reemplazar el td por texto
    //         });
    //     });

    //     var tablaHTML = $tablaClon[0].outerHTML;
    //     var anio = new Date(fecha).getFullYear() + 1;
    //     // 3️⃣ Crear iframe oculto con plantilla.php como src



    //     fetch(rutaPlantilla, {
    //             method: 'HEAD'
    //         })
    //         .then(res => {
    //             if (!res.ok) {

    //                 mensaje("Error critico contacta al desarrollador", "danger")
    //                 return; // salir si no existe
    //             }

    //             var $iframe = $('<iframe>', {
    //                 src: rutaPlantilla,
    //                 css: {
    //                     position: 'absolute',
    //                     width: '0px',
    //                     height: '0px',
    //                     border: '0'
    //                 }
    //             }).appendTo('body');

    //             // 4️⃣ Una vez cargado el iframe, inyectar datos
    //             $iframe.on('load', function() {
    //                 var doc = this.contentDocument || this.contentWindow.document;

    //                 // Insertar datos en los elementos del iframe
    //                 $(doc).find('#numeroDocto').text(numeroDocto);
    //                 $(doc).find('#fecha').text(fecha);
    //                 $(doc).find('#responsable').text(responsable);
    //                 $(doc).find('#servicio').text(servicio);
    //                 $(doc).find('#observaciones').text(observaciones);

    //                 // Insertar tabla modificada
    //                 $(doc).find('#tablaActivos').html(tablaHTML);

    //                 // 5️⃣ Imprimir
    //                 this.contentWindow.focus();
    //                 this.contentWindow.print();

    //                 // 6️⃣ Eliminar iframe después
    //                 setTimeout(function() {
    //                     $iframe.remove();
    //                 }, 1000);
    //             });





    //         })
    //         .catch(err => {
    //             console.error('Error al verificar plantilla:', err);
    //             alert('No se pudo verificar la plantilla. Intente nuevamente.');
    //         });
    // });




    function desactivarEntregaFinalizada(estadoParametro = null) {
    // 1️⃣ Obtener el estado de la entrega
    // alert(estadoParametro)
    let estado = estadoParametro
        ? String(estadoParametro).trim().toLowerCase()
        : String($('#acta_ëstado').text()).trim().toLowerCase();

    const esFinalizado = estado.includes('finalizado');

    // 2️⃣ Selector general de todos los campos dentro del formulario
    const $form = $('#form_detalle_entrega');

    // 3️⃣ Desactivar si es finalizado
    if (esFinalizado) {
        // Desactivar TODOS los campos relevantes
        $form.find('input, select, textarea, button').each(function () {
            const $elemento = $(this);
            const id = $elemento.attr('id');

            // Lista blanca: botones o elementos que sí pueden quedar habilitados
            const excepciones = ['btnImprimir', 'buscarActa'];

            // Si NO está en la lista blanca, desactivar
            if (!excepciones.includes(id)) {
                $elemento.prop('disabled', true);
            }
        });

        // 4️⃣ También desactivar manualmente elementos fuera del <form> si los hay
        // Por ejemplo, botones sueltos fuera del formulario que interactúan con los activos
        $('#btn_guardar_activos, #btn_agregar_activo, #btn_eliminar_activo').prop('disabled', true);
        $('#alerta_estado_finalizado').removeClass('d-none').addClass('show');
        // // 5️⃣ (Opcional) Mostrar mensaje visual
        // if ($('#estado_entrega_alerta').length) {
        //     $('#estado_entrega_alerta').html(`
        //         <div class="alert alert-warning text-center">
        //             Esta entrega ya fue finalizada. No se puede modificar.
        //         </div>
        //     `);
        // }
    } else {
        // ✅ Si no está finalizado, asegurarse de que todo esté habilitado
        $('#alerta_estado_finalizado').addClass('d-none').removeClass('show');
        $form.find('input, select, textarea, button').prop('disabled', false);
        $('#btn_guardar_activos, #btn_agregar_activo, #btn_eliminar_activo').prop('disabled', false);
    }
}


    // Llama a la función al cargar la página o al actualizar datos








    // 🔹 2. Botón Imprimir con PrintThis
    // $('#btnImprimir').on('click', function() {
    //     $("#documentoImprimir").load("prints/2025/entrega/plantilla.html", function(e) {
    //         console.log("✅ Plantilla cargada en el div");
    //         alert(e)
    //     });
    //     $('#documentoImprimir').printThis({
    //         importCSS: true,
    //         importStyle: true,
    //         loadCSS: "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css",

    //         pageTitle: "Acta de Entrega"
    //     });
    // });

    // 🔹 3. Botón Descargar Word
    // $('#btnDescargarWord').on('click', function() {
    //     let content = $('#documentoImprimir').html();

    //     let html = `
    //         <!DOCTYPE html>
    //         <html>
    //         <head>
    //             <meta charset="utf-8">
    //             <title>Documento</title>
    //         </head>
    //         <body>${content}</body>
    //         </html>
    //     `;

    //     let converted = window.htmlDocx.asBlob(html);

    //     let a = document.createElement("a");
    //     a.href = URL.createObjectURL(converted);
    //     a.download = "Acta_Entrega.docx";
    //     a.click();
    // });













    // buscarUltimoInventario();

    //     $("#servicio").on('input', function(){
    //     buscarUltimoInventario();

    // });


















    // const csrfToken = $('meta[name="csrf-token"]').attr('content');
    // $('#form_detalle_entrega').on('submit', function(e) {
    //     e.preventDefault();
    //     if (!verEstado()) {
    //         mensaje("No puedes hacer cambios en esta entrega", 'warning')
    //     }
    //     const idEntrega = $('#id_entrega').val();
    //     const idInventario = $('#id_inventario').val();
    //     // alert(idEntrega + "    "+ idInventario)
    //     if (!idEntrega || !idInventario) {
    //         mensaje('ID de entrega o inventario no definido.', 'danger');
    //         return;
    //     }

    //     const activos = [];

    //     $('#tabla_activos tbody tr').each(function() {
    //         const idActivo = $(this).find('.btn-eliminar-activo').data('id');
    //         const cantidad = $(this).find('input[type="number"]').val();

    //         if (idActivo && cantidad > 0) {
    //             activos.push({
    //                 id: idActivo,
    //                 cantidad: cantidad
    //             });
    //         }
    //     });

    //     if (activos.length === 0) {
    //         alert('Debes agregar al menos un activo.');
    //         return;
    //     }
    //     // console.log($('meta[name="csrf-token"]').attr('content'));

    //     $.ajax({
    //         url: baseUrl + '/entregas/detalles/store',
    //         method: 'POST',
    //         dataType: 'json',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         data: {
    //             id_entrega: idEntrega,
    //             id_inventario: idInventario,
    //             activos: activos
    //         },

    //         success: function(response) {
    //             mensaje("response.message", 'success');
    //             $('#form_buscar_acta_modal').submit();

    //             // opcional: actualizar vista, redirigir, etc.
    //         },
    //         error: function(xhr) {
    //             const res = xhr.responseJSON;
    //             if (res && res.message) {
    //                 mensaje('res.message', 'danger');
    //             } else {
    //                 mensaje('Ocurrió un error inesperado.', 'danger');
    //             }
    //         }
    //     });
    // });

    /////////////////////
    function buscarUltimoInventario() {
        // let id_servicio = $('#servicio').attr('data-id'); // tu div de servicio

        let gestion = $('#gestion').val(); // input hidden de gestión
        // alert(id_servicio + gestion)
        // console.log(id_servicio + gestion)

        $.ajax({
            url: baseUrl + '/inventarios/ultimo',
            method: 'GET',
            data: {
                id_servicio: id_servicio,
                gestion
            },
            dataType: 'json',
            success: function(response) {
                let html = '';

                if (response.inventario) {
                    html += `
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Gestión</th>
                                <th>Fecha</th>
                                <th>Observaciones</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <input type='hidden' name='id_inventario' id='id_inventario' value=${response.inventario.id_inventario}>
                                <td>${response.inventario.numero_documento}</td>
                                <td>${response.inventario.gestion}</td>
                                <td>${response.inventario.fecha}</td>
                                <td>${response.inventario.observaciones}</td>
                                <td>
                                    <button id='btn-generar-inventario' type='button' class="btn btn-sm btn-primary btn-generar-inventario">Generar Nuevo</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                `;
                    // var estado = $('#estado_entrega').data('estado');
                    // alert(estado)
                    //             actualizarEstadoFormulario(estado);
                } else {
                    html += `
                    <div class="mb-2">No se encontró inventario para este servicio y gestión.</div>

                    <button type='button' id='btn-generar-inventario' class="btn btn-sm btn-success ">Generar Inventario</button>
                `;
                }

                $('#inventario_contenido').html(html);
            },
            error: function(xhr) {
                $('#inventario_contenido').html(
                    '<div class="text-danger">Error al buscar inventario.</div>');
            }
        });
    }
    //////////////////
    // const csrfToken = $('meta[name="csrf-token"]').attr('content');
    // $(document).on('click', '#btn-generar-inventario', function() {
    //     let id_servicio = $('#servicio').attr('data-id');
    //     let id_responsable = $('#responsable').attr('data-id');
    //     let gestion = $('#gestion').val();
    //     let fecha = new Date().toISOString().slice(0, 10);
    //     let numero_documento = $('#nuevo_numero').val() || null;
    //     if (!verEstado()) {
    //         mensaje("No puedes hacer cambios en esta entrega", 'warning')
    //         return;
    //     }
    //     // alert(id_responsable)
    //     $.ajax({
    //         url: baseUrl + '/inventarios/generar',
    //         method: 'get',

    //         data: {
    //             id_servicio,
    //             id_responsable,
    //             gestion,
    //             fecha,
    //             numero_documento,
    //             // _token: csrfToken // tu token CSRF
    //         },
    //         dataType: 'json',
    //         success: function(response) {
    //             if (response.success) {
    //                 mensaje('Inventario generado correctamente.', 'success');
    //                 buscarUltimoInventario(); // recargar con nuevo inventario
    //             } else {
    //                 mensaje(response.error || 'No se pudo generar inventario.', 'danger');
    //             }
    //         },
    //         error: function(xhr) {
    //             mensaje(xhr.responseJSON?.error || 'Error al generar inventario.', 'danger');
    //         }
    //     });
    // });


    ///////////////////////////


    $('#btn_agregar_activo').click(function() {
        let codigo = $('#input_activo_codigo').val().trim();
        if (!codigo) {
            mensaje('Ingrese código o nombre del activo.', 'danger');
            return;
        }
        if (!verEstado()) {
            mensaje("No puedes hacer cambios en esta entrega", 'warning');
            return;
        }

        $.ajax({
            url: baseUrl + '/activos/buscarXcod',
            method: 'GET',
            dataType: 'json',
            data: {
                codigo: codigo
            },
            success: function(response) {
                if (!response.activo) {
                    mensaje(response.error || 'Activo no encontrado.', 'danger');
                    return;
                }

                const activo = response.activo;

                // Verifica si ya existe en la tabla
                if ($('#tabla_activos tbody tr[data-id-activo="' + activo.id_activo + '"]')
                    .length) {
                    mensaje('El activo ya está agregado.', 'warning');
                    return;
                }

                // Eliminar fila vacía si existe
                $('#fila_vacia').remove();

                // Crear fila

                const fila = `
                <tr data-id-activo="${activo.id_activo}">
                    <td>${activo.codigo || 'N/D'}</td>
                    <td><input type="number" class="form-control form-control-sm cantidad-activo" data-id-activo="${activo.id_activo}" value="1" min="1"></td>
                    <td>${activo.unidad || 'N/D'}</td>
                    <td>${escapeHtml(activo.nombre) || 'N/D'}</td>
                    <td>${escapeHtml(activo.detalle) || 'N/D'}</td>
                    <td>${activo.estado || 'N/D'}</td>
                     <td>
                            <button type="button" class="btn btn-danger btn-sm btn-eliminar-activo"
                                 data-id-activo="${activo.id_activo}">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-secondary btn-comentar">💬</button>
                            <input type="hidden" class="comentario-activo" value="">
                        </td>
                </tr>
            `;

                $('#tabla_activos tbody').append(fila);
                mensaje('Activo agregado correctamente.', 'success');
                $('#input_activo_codigo').val('');
            },
            error: function(xhr) {
                let textoError = 'Error inesperado en el servidor.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    textoError = xhr.responseJSON.error;
                }
                mensaje(textoError, 'danger');
            }
        });
    });


    // Función para mostrar mensaje dentro de la página


    function escapeHtml(text) {
        if (!text) return '';
        return text.toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }





    // Prevenir Enter y submit
    $('#form_detalle_entrega').on('keydown', function(e) {
        if (e.key === "Enter") {
            e.preventDefault();

            if (verEstado()) {
                $('#btn_agregar_activo').click();
            }
        }
    });

    $('#form_detalle_entrega').on('submit', function(e) {
        e.preventDefault();
    });

    // $(document).on('click', '.btn-eliminar-activo', function() {
    //     // Opción 1: eliminar solo visualmente del DOM
    //     if (verEstado()) {
    //         $(this).closest('tr').remove();
    //     }

    // });


    // $('#modalBuscarActa').on('hide.bs.modal', function() {
    //     if (document.activeElement) {
    //         document.activeElement.blur();
    //     }
    // });


    // $('#btn_entregar').on('click', function(e) {
    //     e.preventDefault();
    //     guardarEntrega(true); // Guardar acta + activos
    // });

    // function cargarActivos(numeroDocumento, gestion) {
    //     $.ajax({
    //         url: baseUrl +'{{ route('entregas.activos') }}',
    //         method: 'GET',
    //         data: {
    //             numero_documento: numeroDocumento,
    //             gestion: gestion
    //         },
    //         dataType: 'json',
    //         success: function(response) {
    //             if (response.success) {
    //                 let tbody = $('#tabla_activos tbody');
    //                 tbody.empty();

    //                 if (response.activos.length === 0) {
    //                     tbody.append(`
    //                     <tr id="fila_vacia">
    //                         <td colspan="4" class="text-center text-muted">No hay activos agregados</td>
    //                     </tr>
    //                 `);
    //                     return;
    //                 }

    //                 response.activos.forEach(function(activo) {
    //                     tbody.append(`
    //                     <tr data-id_activo="${activo.id_activo}">
    //                         <td>${activo.codigo_nombre}</td>
    //                         <td><input type="number" class="form-control input_cantidad" value="${activo.cantidad}" min="1"></td>
    //                         <td><input type="text" class="form-control input_observaciones" value="${activo.observaciones || ''}"></td>
    //                         <td><button type="button" class="btn btn-danger btn-sm btn-eliminar-activo">Eliminar</button></td>
    //                     </tr>
    //                 `);
    //                 });
    //             } else {
    //                 alert(response.message || 'Error al cargar activos');
    //             }
    //         },
    //         error: function() {
    //             alert('Error en la petición AJAX');
    //         }
    //     });
    // }

    // function guardarEntrega(incluirActivos) {
    //     const form = $('#form_entrega');
    //     const formData = form.serializeArray();

    //     // Si vas a incluir los activos agregados dinámicamente, debes armar esa parte manualmente
    //     if (incluirActivos) {
    //         $('#tabla_activos tbody tr').each(function() {
    //             const activoId = $(this).data('id_activo');
    //             const cantidad = $(this).find('.input_cantidad').val();
    //             const observaciones = $(this).find('.input_observaciones').val();

    //             if (activoId) {
    //                 formData.push({
    //                     name: 'activos[]',
    //                     value: JSON.stringify({
    //                         id_activo: activoId,
    //                         cantidad: cantidad,
    //                         observaciones: observaciones
    //                     })
    //                 });
    //             }
    //         });
    //     }

    //     $.ajax({
    //         url: baseUrl + "/entregas/detalles/store",
    //         method: 'POST',
    //         data: formData,
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // token CSRF
    //         },
    //         success: function(response) {
    //             if (response.success) {
    //                 mensaje('Acta guardada correctamente', 'success');
    //                 $('#form_entrega')[0].reset();
    //                 $('#numero_documento').val(response.numeroSiguiente);

    //                 // Si quieres redirigir o hacer algo con el ID de entrega
    //                 console.log('ID entrega creada:', response.entrega_id);

    //                 // Opcional: limpiar la tabla de activos
    //                 $('#tabla_activos tbody').html(`
    //                 <tr id="fila_vacia">
    //                     <td colspan="4" class="text-center text-muted">No hay activos agregados</td>
    //                 </tr>
    //             `);
    //             } else {
    //                 let mensajes = [];
    //                 if (response.errors) {
    //                     $.each(response.errors, function(key, errors) {
    //                         mensajes = mensajes.concat(errors);
    //                     });
    //                 } else {
    //                     mensajes.push(response.message || 'Error desconocido');
    //                 }
    //                 mensaje(mensajes.join('<br>'), 'danger');
    //             }
    //         },
    //         error: function(xhr) {
    //             if (xhr.status === 422 && xhr.responseJSON?.errors) {
    //                 let mensajes = [];
    //                 $.each(xhr.responseJSON.errors, function(key, errors) {
    //                     mensajes = mensajes.concat(errors);
    //                 });
    //                 mensaje(mensajes.join('<br>'), 'danger');
    //             } else {
    //                 mensaje('Error inesperado en el servidor', 'danger');
    //             }
    //         }
    //     });
    // }
    // $('#id_servicio').on('change', function() {
    //     var responsableId = $(this).find('option:selected').data('responsable');

    //     if (!responsableId) {
    //         $('#nombre_responsable').val('');
    //         $('#id_responsable').val('');
    //         return;
    //     }

    //     $.ajax({
    //         url: baseUrl + '/responsables/' + responsableId,
    //         method: 'GET',
    //         dataType: 'json',
    //         success: function(data) {
    //             $('#nombre_responsable').val(data.nombre);
    //             $('#id_responsable').val(data.id_responsable);
    //         },
    //         error: function() {
    //             $('#nombre_responsable').val('No encontrado');
    //             $('#id_responsable').val('');
    //         }
    //     });
    // });
    // $('#gestion').on('change', function() {
    //     var gestion = $(this).val();

    //     if (!gestion) {
    //         $('#numero_documento').val('Error');
    //         return;
    //     }

    //     $.ajax({
    //         url: baseUrl + '/getDocto',
    //         method: 'GET',
    //         data: {
    //             gestion: gestion
    //         },
    //         dataType: 'json',
    //         success: function(data) {
    //             if (data.numero) {
    //                 $('#numero_documento').val(data.numero);
    //             } else {
    //                 $('#numero_documento').val('Error');
    //                 console.error(data.error || 'Error desconocido');
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             $('#numero_documento').val('Error');
    //             console.error('Error al obtener número de documento:', error);
    //         }
    //     });
    // });
</script>
