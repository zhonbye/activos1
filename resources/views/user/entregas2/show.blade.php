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

        <!-- Buscar Traslado -->
        <div class="sidebar-col card p-3">
            <div class="sidebar-header d-flex justify-content-between align-items-start">
                <button class="toggleSidebar btn btn-primary">⮞</button>
                <h2 class="sidebar-title fs-5 text-fw mb-0 ms-2">Traslado</h2>
            </div>

            <div class="acciones-traslado d-grid gap-3">
                <h3 class="fs-6 my-3">Acciones rápidas</h3>

                <div id="nuevo_traslado"
                    class="card action-card border-0 shadow-sm p-3 text-center hover-card primary"data-bs-toggle="modal"
                    data-bs-target="#modalTraslado">
                    <i class="bi bi-plus-circle text-primary fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Nuevo Traslado</h5>
                    <p class="text-muted small mb-3">Registra un nuevo acta de traslado.</p>
                    <button class="btn btn-outline-primary w-100">
                        <i class="bi bi-file-earmark-plus"></i> Crear Acta
                    </button>
                </div>

                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card success">
                    <i class="bi bi-search text-success fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Buscar Acta</h5>
                    <p class="text-muted small mb-3">Consulta un acta registrada.</p>

                    <button class="btn btn-outline-success w-100" id="buscar_traslado"data-bs-toggle="modal"
                        data-bs-target="#buscarTraslado">
                        <i class="bi bi-search"></i> Buscar Traslado
                    </button>
                </div>
                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card warning">
                    <i class="bi bi-clock-history text-warning fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Traslados Recientes</h5>
                    <p class="text-muted small mb-3">Consulta tus traslados más recientes fácilmente.</p>
                    <button class="btn btn-outline-warning w-100" id="btn_recientes_traslados">
                        <i class="bi bi-clock-history"></i> Ver Traslados
                    </button>
                </div>

                {{-- <div class="card action-card border-0 shadow-sm p-3 text-center hover-card warning">
                    <i class="bi bi-folder2-open text-warning fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Mis Actas</h5>
                    <p class="text-muted small mb-3">Visualiza tus actas de traslado recientes.</p>
                    <button class="btn btn-outline-warning w-100" id="btn_mis_traslados">
                        <i class="bi bi-folder2-open"></i> Ver Actas
                    </button>
                </div> --}}
                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card info">
                    <i class="bi  bi-hourglass-split text-info fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Pendientes</h5>
                    <p class="text-muted small mb-3">Revisa traslados aún no finalizados.</p>
                    <button class="btn btn-outline-info w-100" id="btn_pendientes">
                        <i class="bi bi-clock-history"></i> Ver Pendientes
                    </button>
                </div>

            </div>
        </div>

    </div>

    <!-- Columna principal: registrar traslado -->
    <div class="main-col col-md-12 col-lg-10 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;">
        <div class="card p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 100vh;">

            <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Traslado de Activos</h2>

            <input type="hidden" id="traslado_id" value="{{ $traslado->id_traslado ?? '' }}">


            <div class="card rounded p-3 mb-3 bg-light" id="contenedor_detalle_traslado">
                @include('user.traslados.parcial_traslado', ['traslado' => $traslado])
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
                    <button type="submit" id="btnRegistrarTraslado" class="btn btn-success">Registrar Traslado</button>
                </div>
            </div>




            <div id="contenedor_tabla_activos">
                @include('user.traslados.parcial_activos', ['detalles' => []])
            </div>

            <!-- Contenedor de tabla parcial de activos (se actualizará dinámicamente) -->


            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                {{-- <button type="reset" class="btn btn-danger">Limpiar</button> --}}

                {{-- <button class="btn btn-sm btn-primary editar-traslado-btn" data-id="{{ $traslado->id_traslado }}">
                    Editar Acta
                </button> --}}
            </div>

        </div>
    </div>

</div>


{{-- modal donde se muestra informacion del activo en actas --}}
<div id="modalDetalleActivos" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header d-flex justify-content-between align-items-start">
                <div>
                    <h5 id="modalActivoNombre" class="fw-bold mb-1">Nombre del Activo</h5>
                    <div class="text-primary fw-semibold" id="modalActivoCantidad">Cantidad: 0</div>
                </div>
                <button data-id="{{ $traslado->id_traslado }}" id="seleccionar_traslado" type="button"
                    class="btn btn-lg btn-primary mt-1 btn-seleccionar-traslado">Revisar</button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <p class="text-muted mb-2">Actas encontradas en este activo:</p>
                <div class="wheel-container" style="max-height: 200px; overflow-y: auto;">
                    <ul id="actasWheel" class="list-unstyled m-0 p-0">
                        <!-- Aquí se llenan los li de actas dinámicamente -->
                    </ul>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                <!-- Aquí puedes poner el contenido dinámico de inventario -->
                <p>Cargando detalles del inventario...</p>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>

<div class="modal fade" id="modalTraslado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Traslado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal_body_traslado">
                <!-- Aquí se cargará la vista parcial -->
                Cargando contenido...
            </div>
        </div>
    </div>
</div>


<div class="modal fade w-100" id="buscarTraslado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar Traslado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="body_buscarTraslado">
                <!-- Aquí se cargará la vista parcial -->
            </div>
        </div>
    </div>
</div>




<script>
    // Ejecutar al cargar la página
    if (inventarioCargado) {
        var inventarioCargado = false;
    }
    if (trasladoCargado) {
        var trasladoCargado = false;
    }


    function cargarTablaActivos(traslado_id = null) {

        if (!traslado_id) traslado_id = $('#traslado_id').val();
        if (!traslado_id) {
            mensaje('No se encontró el ID del traslado', 'danger');
            return;
        }

        var $contenedor = $('#contenedor_tabla_activos');
        var $loader = $('#loader');
        // alert($loader.length)
        // Mostrar loader
        $contenedor.empty().append($loader);
        $loader.show();

        // Simular carga de 10s

        $contenedor.load(`${baseUrl}/traslados/${traslado_id}/activos`, function(response, status, xhr) {
            // Ocultar loader al terminar
            $loader.hide();

            if (status === "error") {
                $contenedor.html('<p>Error al cargar los activos.</p>');
            }
            controlarBotones($('#estado_traslado').data('estado-traslado'));
        });


        $('#traslado_id').val(traslado_id);
}


    function cargarDetalleTraslado(traslado_id = null) {
        // Toma el ID del input si no se pasa
        if (!traslado_id) traslado_id = $('#traslado_id').val()
        // if (!traslado_id) traslado_id = $('#btn_editar_traslado').data('id');

        if (!traslado_id) {
            mensaje('No se encontró el ID del traslado', 'danger');
            return;
        }
        // alert($('#btn_editar_traslado').data('id'));

        // AJAX GET para traer la vista parcial
        $.ajax({
            url: `${baseUrl}/traslados/${traslado_id}/detalle`,
            type: 'GET',
            success: function(data) {
                $('#contenedor_detalle_traslado').html(data);
                // $('#traslado_id').val(data.id_traslado);
                // alert(data.id_traslado)
                $('#traslado_id').val(traslado_id);
                $('#servicio_nombre').text(($('#servicio_responsable_origen').data('nombre')))


                inventarioCargado = false;
                if (inventarioCargado) {
                    $("#modalInventario").removeClass('constante')
                }
                // controlarBotones($('#estado_traslado').data('estado-traslado'));

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
        let idTraslado = {{ $traslado->id_traslado }};
        cargarDetalleTraslado();
        cargarTablaActivos();

        $(document).on('click', '#seleccionar_traslado', function() {
            var idTraslado = $(this).data('id');

            // console.log("Traslado seleccionado:", idTraslado);
            // alert(idTraslado    )
            cargarDetalleTraslado(idTraslado);
            cargarTablaActivos(idTraslado);
            var $modal = $('.modal.show');
            // var $botonAbrirModal = $('.btn-ver-detalle-principal[data-id-activo="' + 3 + '"]');
            setTimeout(() => {

            }, 10000);
            $modal.find('button[data-bs-dismiss="modal"]').trigger('click');
            $(this).blur();

            // Cuando el modal termine de cerrarse, devolvemos el foco al botón que lo abrió
        //     $modal.on('hidden.bs.modal', function() {

        //             $(this).blur();
        // $modal.off('hidden.bs.modal');
    // });
        });

        // Cuando se hace clic en el botón de cierre del modal
$('#modalDetalleActivos').on('click', 'button[data-bs-dismiss="modal"]', function() {
    $(this).blur(); // quitar el foco del botón
});

//         $('#modalDetalleActivos').on('hidden.bs.modal', function() {
//     // Buscamos cualquier botón dentro del modal que pueda tener foco
//     // alert("fdf")
//     $(this).find('button:focus').blur();
//     $('#modalDetalleActivos')
//     .css('display', 'none')       // oculta visualmente
//     .attr('aria-hidden', 'true')   // indica a tecnologías asistivas que está oculto
//     .removeClass('show');          // quita la clase Bootstrap

//     $('#seleccionar_traslado').blur();
//     var $btnCerrar = $(this).find('button[data-bs-dismiss="modal"]');
//     $btnCerrar.blur();
//     alert($btnCerrar.html())
// });



$('#btnRegistrarTraslado').on('click', function(e) {
    e.preventDefault();

    const $btn = $(this);
    const idTraslado = $('#div_traslado').find('input[name="id_traslado"]').val();

    if (!idTraslado) {
        mensaje('No se pudo identificar el traslado.', 'warning');
        return;
    }

    if (!confirm('¿Está seguro que desea finalizar y registrar este traslado?')) return;

    $.ajax({
        url: `${baseUrl}/traslados/${idTraslado}/finalizar`,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
        },
        dataType: 'json',

        beforeSend: function() {
            // Deshabilitar botón y mostrar spinner
            $btn.prop('disabled', true)
                .html('<i class="bi bi-arrow-repeat spin"></i> Guardando...');
        },

        success: function(response) {
            if (response.success) {
                mensaje(response.message, 'success');
                cargarDetalleTraslado(idTraslado);
                cargarTablaActivos(idTraslado);
            } else {
                mensaje(response.message || 'No se pudo finalizar el traslado.', 'danger');
            }
        },

        error: function(xhr) {
            let msg = 'Ocurrió un error inesperado al finalizar el traslado.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            mensaje(msg, 'danger');
        },

        complete: function() {
            // Reactivar botón
            $btn.prop('disabled', false)
                .html('<i class="bi bi-check-circle"></i> Finalizar Traslado');
        }
    });
});











        $('#btn_consultar_inventario').click(function() {
            // alert("fsdaf")
            // alert(inventarioCargado)
            if (inventarioCargado) return;
            $.ajax({
                url: "{{ route('traslados.mostrarInventario') }}", // ruta que devuelve la vista parcial
                method: "GET",
                success: function(view) {
                    $('#modal_body_inventario').html(view);
                    inventarioCargado = true;
                    if (inventarioCargado) {
                        $("#modalInventario").addClass('constante')
                    }
                    // $('#buscarTraslado').modal('show'); // abre el modal
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    mensaje('Error al cargar el formulario', 'danger');
                }
            });
        });
        $('#buscar_traslado').click(function() {
            //    alert(trasladoCargado)
            if (trasladoCargado) {
                console.log("retornando")

                return;
            }
            // ALERT("FDSA")
            $.ajax({
                url: "{{ route('traslados.mostrarBuscar') }}", // ruta que devuelve la vista parcial
                method: "GET",
                success: function(view) {
                    $('#body_buscarTraslado').html(view);

                    trasladoCargado = true;
                    if (trasladoCargado) {
                        $("#buscarTraslado").addClass('constante')
                    }
                    // $('#buscarTraslado').modal('show'); // abre el modal
                },
                error: function(xhr) {
                    // console.error(xhr.responseText);
                    mensaje('Error al cargar el formulario', 'danger');
                }
            });
        });

        $('#nuevo_traslado').click(function() {
            $.ajax({
                url: "{{ route('traslados.create') }}", // ruta que devuelve la vista parcial
                method: "GET",
                success: function(view) {
                    $('#modal_body_traslado').html(view);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    mensaje('Error al cargar el formulario', 'danger');
                }
            });
        });




    });
</script>
