<style>
    .hover-card {
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .hover-card.primary:hover {
        background-color: rgba(13, 110, 253, 0.08);
    }

    /* azul */
    .hover-card.secondary:hover {
        background-color: rgba(108, 117, 125, 0.08);
    }

    /* gris */
    .hover-card.success:hover {
        background-color: rgba(25, 135, 84, 0.08);
    }

    /* verde */
    .hover-card.danger:hover {
        background-color: rgba(220, 53, 69, 0.08);
    }

    /* rojo */
    .hover-card.warning:hover {
        background-color: rgba(255, 193, 7, 0.12);
    }

    /* amarillo */
    .hover-card.info:hover {
        background-color: rgba(13, 202, 240, 0.08);
    }

    /* celeste */
    .hover-card.light:hover {
        background-color: rgba(248, 249, 250, 0.4);
    }

    /* blanco grisáceo */
    .hover-card.dark:hover {
        background-color: rgba(33, 37, 41, 0.08);
    }

    /* negro */

    .action-card i {
        transition: transform 0.2s ease;
    }

    .action-card:hover i {
        transform: scale(1.4);
    }


    .wheel-container {
        height: 320px;
        /* altura visible */
        overflow-y: scroll;
        /* permite deslizar */
        scroll-snap-type: y mandatory;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        text-align: center;
    }

    .wheel-container ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .wheel-container li {
        height: 40px;
        line-height: 40px;
        scroll-snap-align: center;
        transition: background 0.3s, color 0.3s;
        cursor: pointer;
    }

    .wheel-container li.selected {
        background: #0d6efd;
        color: white;
        font-weight: bold;
    }
</style>

<div class="row p-0 mb-4 pb-4" style="height: 90vh;">

    <!-- Sidebar de búsqueda de acta -->
    <div class="sidebar-wrapper col-md-12 col-lg-2 order-lg-2 order-2 d-flex flex-column pb-2 gap-3 transition"
        style="max-height: 95vh;">

        <!-- Buscar devolucion -->
        <div class="sidebar-col card p-3">
            <div class="sidebar-header d-flex justify-content-between align-items-start">
                <button class="toggleSidebar btn btn-primary">⮞</button>
                <h2 class="sidebar-title fs-5 text-fw mb-0 ms-2">devolucion</h2>
            </div>

            <div class="acciones-devolucion d-grid gap-3">
                <h3 class="fs-6 my-3">Acciones rápidas</h3>

                <div id="nuevo_devolucion"
                    class="card action-card border-0 shadow-sm p-3 text-center hover-card primary"data-bs-toggle="modal"
                    data-bs-target="#modalNuevaDevolucion">
                    <i class="bi bi-plus-circle text-primary fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Nuevo devolucion</h5>
                    <p class="text-muted small mb-3">Registra un nuevo acta de devolucion.</p>
                    <button class="btn btn-outline-primary w-100">
                        <i class="bi bi-file-earmark-plus"></i> Crear Acta
                    </button>
                </div>

                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card success">
                    <i class="bi bi-search text-success fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Buscar Acta</h5>
                    <p class="text-muted small mb-3">Consulta un acta registrada.</p>

                    <button class="btn btn-outline-success w-100" id="buscar_devolucion"data-bs-toggle="modal"
                        data-bs-target="#buscardevolucion">
                        <i class="bi bi-search"></i> Buscar devolucion
                    </button>
                </div>
                <div class=" desactivado card action-card border-0 shadow-sm p-3 text-center hover-card warning">
                    <i class="bi bi-clock-history text-warning fs-2 mb-2"></i>
                    <h5 class="fw-semibold">devolucion Recientes</h5>
                    <p class="text-muted small mb-3">Consulta tus devolucion más recientes fácilmente.</p>
                    <button class="btn btn-outline-warning w-100" id="btn_recientes_devolucion">
                        <i class="bi bi-clock-history"></i> Ver devolucion
                    </button>
                </div>

                {{-- <div class="card action-card border-0 shadow-sm p-3 text-center hover-card warning">
                    <i class="bi bi-folder2-open text-warning fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Mis Actas</h5>
                    <p class="text-muted small mb-3">Visualiza tus actas de devolucion recientes.</p>
                    <button class="btn btn-outline-warning w-100" id="btn_mis_devolucion">
                        <i class="bi bi-folder2-open"></i> Ver Actas
                    </button>
                </div> --}}
                <div class="desactivado card action-card border-0 shadow-sm p-3 text-center hover-card info">
                    <i class="bi  bi-hourglass-split text-info fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Pendientes</h5>
                    <p class="text-muted small mb-3">Revisa devolucion aún no finalizados.</p>
                    <button class="btn btn-outline-info w-100" id="btn_pendientes">
                        <i class="bi bi-clock-history"></i> Ver Pendientes
                    </button>
                </div>

            </div>
        </div>

    </div>

    <!-- Columna principal: registrar devolucion -->
    <div class="main-col col-md-12 col-lg-10 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;">
        <div class="card p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 100vh;">

<h2 class="mb-4 text-center text-primary">
  <i class="bi bi-arrow-counterclockwise me-2"></i>Devolución de Activos
</h2>




            <input type="hidden" id="devolucion_id" value="{{ $devolucion->id_devolucion ?? '' }}">


            <div class="card rounded p-3 mb-3 bg-light" id="contenedor_detalle_devolucion">
                @include('user.devolucion.parcial_devolucion', ['devolucion' => $devolucion])
            </div>
            <!-- Buscar y agregar activos -->
            {{-- <div class="row g-3 mb-3">
                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <input type="text" id="input_activo_codigo" class="form-control"
                        placeholder="Código o nombre del activo">
                        <button type="button" id="btn_agregar_activo" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            </div> --}}

            <div class="row g-3 mb-3">
                <div class="col-lg-12 d-flex justify-content-between">
                    <button type="button" id="btn_consultar_inventario" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalInventario">
                        Agregar desde Inventario
                    </button>
                    <button type="submit" id="btnRegistrardevolucion" class="btn btn-success">Finalizar
                        devolucion</button>
                </div>
            </div>




            <div id="contenedor_tabla_activos">
                {{-- @include('user.entregas2.parcial_activos', ['detalles' => []]) --}}
            </div>

            <!-- Contenedor de tabla parcial de activos (se actualizará dinámicamente) -->


            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                {{-- <button type="reset" class="btn btn-danger">Limpiar</button> --}}

                {{-- <button class="btn btn-sm btn-primary editar-devolucion-btn" data-id="{{ $devolucion->id_devolucion }}">
                    Editar Acta
                </button> --}}
            </div>

        </div>
    </div>

</div>




<!-- Modal -->
<div class="modal fade" id="modalInventario" tabindex="-1" aria-labelledby="modalInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-muted fst-italic" id="modalInventarioLabel">Mostrando inventario de: <span
                        id="servicio_nombre" class="fw-bold"></span> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body"id="modal_body_inventario">
                @include('user.devolucion.parcial_inventario')
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevaDevolucion" tabindex="-1" aria-hidden="false" data-bs-backdrop="static"
    data-bs-keyboard="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo devolucion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal_body_devolucion">
                @include('user.devolucion.parcial_nuevo')

            </div>
        </div>
    </div>
</div>


<div class="modal fade w-100" id="buscardevolucion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar devolucion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="body_buscardevolucion">
                @include('user.devolucion.parcial_buscarActa')
            </div>
        </div>
    </div>
</div>




<script>
    // if (inventarioCargado) {
    //     var inventarioCargado = false;
    // }
    // if (devolucionCargado) {
    //     var devolucionCargado = false;
    // }

//     $.ajaxSetup({
//     haders: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });
    function cargarTablaActivos(devolucion_id = null) {

        if (!devolucion_id) devolucion_id = $('#devolucion_id').val();
        if (!devolucion_id) {
            mensaje('No se encontró el ID del devolucion', 'danger');
            return;
        }

        var $contenedor = $('#contenedor_tabla_activos');
        var $loader = $('#loader');
        // alert($loader.length)
        // Mostrar loader
        $contenedor.empty().append($loader);
        $loader.show();

        // Simular carga de 10s

        $contenedor.load(`${baseUrl}/devolucion/${devolucion_id}/activos`, function(response, status, xhr) {
            // Ocultar loader al terminar
            $loader.hide();

controlarBotones($('#estado_devolucion').text().trim())
            if (status === "error") {
                $contenedor.html('<p>Error al cargar los activos.</p>');
            }
            controlarBotones($('#estado_devolucion').data('estado-devolucion'));
        });


        $('#devolucion_id').val(devolucion_id);
    }


    function cargarDetalleDevolucion(devolucion_id = null) {
        // Toma el ID del input si no se pasa
        if (!devolucion_id) devolucion_id = $('#devolucion_id').val()
        // if (!devolucion_id) devolucion_id = $('#btn_editar_devolucion').data('id');

        if (!devolucion_id) {
            mensaje('No se encontró el ID del devolucion', 'danger');
            return;
        }
        // alert($('#servicio_responsable').data('nombre'))
        $.ajax({
            url: `${baseUrl}/devolucion/${devolucion_id}/detalleDevolucion`,
            type: 'GET',
            success: function(data) {
                $('#contenedor_detalle_devolucion').html(data);
                // $('#devolucion_id').val(data.id_devolucion);
                // alert(data.id_devolucion)
                $('#devolucion_id').val(devolucion_id);
                $('#servicio_nombre').text(($('#servicio_responsable').data('nombre')))


                // inventarioCargado = false;
                // if (inventarioCargado) {
                //     $("#modalInventario").removeClass('constante')
                // }
                controlarBotones($('#estado_devolucion').data('estado-devolucion'));

            },
            error: function(xhr) {
                // Si el controlador devuelve JSON con error
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje(xhr.responseJSON.message, 'danger');
                } else {
                    mensaje('Ocurrió un error inesperado.', 'danger');
                }
            }
        });
    }

    function controlarBotones(estado) {
        if (estado === 'finalizado') {
            // 🔒 Desactivar botones principales
            $('#btn_consultar_inventario').prop('disabled', true);
            $('.col-lg-12.d-flex.justify-content-between button[type="submit"]').prop('disabled', true);

            // 🔒 Desactivar todo dentro de la tabla de activos
            $('#contenedor_tabla_activos #tabla_activos')
                .find('button, input, select, textarea')
                .prop('disabled', true)
                .addClass('disabled-element')
        } else if (estado === 'pendiente') {
            // 🔓 Reactivar botones principales
            $('#btn_consultar_inventario').prop('disabled', false);
            $('.col-lg-12.d-flex.justify-content-between button[type="submit"]').prop('disabled', false);
            $('#contenedor_tabla_activos #tabla_activos')
                .find('button,  select, textarea')
                .prop('disabled', false)
                .removeClass('disabled-element');
        }
    }









    $(document).ready(function() {
        let iddevolucion = {{ $devolucion->id_devolucion }};
        cargarDetalleDevolucion()
        cargarTablaActivos();

        $(document).on('click', '#seleccionar_devolucion', function() {
            var iddevolucion = $(this).data('id');

            // console.log("devolucion seleccionado:", iddevolucion);
            // alert(iddevolucion    )
            cargarDetalleDevolucion(iddevolucion);
            cargarTablaActivos(iddevolucion);

            $('#resultado_inventario').html('');
            // $('#modal .btn-close').trigger('click');
            // $('.modal fade show').find('.btn-close').trigger('click');
            $('.modal').find('button[data-bs-dismiss="modal"]').trigger('click');
        });

        //         $('#modalDetalleActivos').on('hidden.bs.modal', function() {
        //     // Buscamos cualquier botón dentro del modal que pueda tener foco
        //     // alert("fdf")
        //     $(this).find('button:focus').blur();
        //     $('#modalDetalleActivos')
        //     .css('display', 'none')       // oculta visualmente
        //     .attr('aria-hidden', 'true')   // indica a tecnologías asistivas que está oculto
        //     .removeClass('show');          // quita la clase Bootstrap

        //     $('#seleccionar_devolucion').blur();
        //     var $btnCerrar = $(this).find('button[data-bs-dismiss="modal"]');
        //     $btnCerrar.blur();
        //     alert($btnCerrar.html())
        // });
        // $(document).on('hidden.bs.modal', '.modal', function() {



        $('#btnRegistrardevolucion').on('click', function(e) {
            e.preventDefault();

            const $btn = $(this);
            const iddevolucion = $('#div_devolucion').find('input[name="id_devolucion"]').val();
            const texto = $btn.html()

            if (!iddevolucion) {
                mensaje('No se pudo identificar el devolucion.', 'warning');
                return;
            }

            if (!confirm('¿Está seguro que desea finalizar y registrar este devolucion?')) return;

           let textoOriginal = $btn.html();

$.ajax({
    url: `${baseUrl}/devolucion/${iddevolucion}/finalizar`,
    method: 'POST',
    data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
    },
    dataType: 'json',

    beforeSend: function() {
        $btn.prop('disabled', true)
            .html('<i class="bi bi-arrow-repeat spin"></i> Guardando...');
    },

    success: function(response) {
        if (response.success) {
            mensaje(response.message, 'success');
            cargarDetalleDevolucion(iddevolucion);
            cargarTablaActivos(iddevolucion);
// alert("fdsafdsafd")
            $btn
                .prop('disabled', false)
                .html('<i class="bi bi-check-circle"></i> Devolución finalizada');
        } else {
            mensaje(response.message, 'danger');
            $btn.prop('disabled', false).html(textoOriginal);
        }
    },

    error: function(xhr) {
        let msg = xhr.responseJSON?.message || 'Error al finalizar la devolución.';
        mensaje(msg, 'danger');
        $btn.prop('disabled', false).html(textoOriginal);
    }
});
        });











        // $('#btn_consultar_inventario').click(function() {
        //     // alert("fsdaf")
        //     // alert(inventarioCargado)
        //     if (inventarioCargado) return;
        //     $.ajax({
        //         url: "{{ route('devolucion.mostrarInventario') }}", // ruta que devuelve la vista parcial
        //         method: "GET",
        //         success: function(view) {
        //             $('#modal_body_inventario').html(view);
        //             inventarioCargado = true;
        //             if (inventarioCargado) {
        //                 $("#modalInventario").addClass('constante')
        //             }
        //             // $('#buscardevolucion').modal('show'); // abre el modal
        //         },
        //         error: function(xhr) {
        //             console.error(xhr.responseText);
        //             mensaje('Error al cargar el formulario', 'danger');
        //         }
        //     });
        // });
        // $('#buscar_devolucion').click(function() {
        //     //    alert(devolucionCargado)
        //     if (devolucionCargado) {
        //         console.log("retornando")
        //         return;
        //     }
        //     // ALERT("FDSA")
        //     $.ajax({
        //         url: "{{ route('devolucion.mostrarBuscarActa') }}", // ruta que devuelve la vista parcial
        //         method: "GET",
        //         success: function(view) {
        //             $('#body_buscardevolucion').html(view);

        //             devolucionCargado = true;
        //             if (devolucionCargado) {
        //                 $("#buscardevolucion").addClass('constante')
        //             }
        //             // $('#buscardevolucion').modal('show'); // abre el modal
        //         },
        //         error: function(xhr) {
        //             // console.error(xhr.responseText);
        //             mensaje('Error al cargar el formulario', 'danger');
        //         }
        //     });
        // });

        // $('#nuevo_devolucion').click(function() {
        //     // document.activeElement.blur();
        //     // $(this).blur();
        //     $.ajax({
        //         url: "{{ route('devolucion.create') }}", // ruta que devuelve la vista parcial
        //         method: "GET",
        //         success: function(view) {
        //             $(this).blur();
        //             $('#modal_body_devolucion').html(view);
        //         },
        //         error: function(xhr) {
        //             console.error(xhr.responseText);
        //             mensaje('Error al cargar el formulario', 'danger');
        //         }
        //     });
        //     $('.modal').on('hide.bs.modal', function() {
        //         $(this).find('input, select, textarea, button').blur();
        //     });
        // });
        // Asumiendo que tu modal tiene la clase .modal
        $('.modal').on('click', function(e) {
            if ($(e.target).is('.modal')) {
                $(this).find('input, select, textarea, button').blur();
                console.log('Click fuera del modal, cerrándolo...');
                $(this).blur()
                $(this).find('button[data-bs-dismiss="modal"]').trigger('click');
            }
        });

        $('.modal fade show').on('hide.bs.modal', function() {
            $(this).find('input, select, textarea, button').blur();
            // $('#nuevo_devolucion').focus();
            // $(this).focus();
            // alert($(this).html())
            // $('body').attr('tabindex', '-1').focus();
        });


        // function mostrarElementoConFoco() {
        //     const elemento = document.activeElement;

        //     if (elemento) {
        //         console.log("Elemento enfocado:");
        //         console.log("Tag:", elemento.tagName);
        //         console.log("ID:", elemento.id || "N/A");
        //         console.log("Clases:", elemento.className || "N/A");
        //         console.log("Tipo:", elemento.type || "N/A");
        //         console.log("Nombre:", elemento.name || "N/A");
        //     } else {
        //         console.log("No hay elemento con foco actualmente.");
        //     }
        // }

    });
    // Función para mostrar el elemento con foco actual


    // Detectar foco cuando se cierre cualquier modal (Bootstrap)
</script>
