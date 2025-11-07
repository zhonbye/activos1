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

        <!-- Buscar Entrega -->
        <div class="sidebar-col card p-3">
            <div class="sidebar-header d-flex justify-content-between align-items-start">
                <button class="toggleSidebar btn btn-primary">⮞</button>
                <h2 class="sidebar-title fs-5 text-fw mb-0 ms-2">Entrega</h2>
            </div>

            <div class="acciones-entrega d-grid gap-3">
                <h3 class="fs-6 my-3">Acciones rápidas</h3>

                <div id="nueva_entrega"
                    class="card action-card border-0 shadow-sm p-3 text-center hover-card primary"data-bs-toggle="modal"
                    data-bs-target="#modalEntrega">
                    <i class="bi bi-plus-circle text-primary fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Nuevo Entrega</h5>
                    <p class="text-muted small mb-3">Registra un nueva acta de entrega.</p>
                    <button class="btn btn-outline-primary w-100">
                        <i class="bi bi-file-earmark-plus"></i> Crear Acta
                    </button>
                </div>

                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card success">
                    <i class="bi bi-search text-success fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Buscar Acta</h5>
                    <p class="text-muted small mb-3">Consulta un acta registrada.</p>

                    <button class="btn btn-outline-success w-100" id="buscar_entrega"data-bs-toggle="modal"
                        data-bs-target="#buscarEntrega">
                        <i class="bi bi-search"></i> Buscar Entrega
                    </button>
                </div>
                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card warning">
                    <i class="bi bi-clock-history text-warning fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Entregas Recientes</h5>
                    <p class="text-muted small mb-3">Consulta tus entregas más recientes fácilmente.</p>
                    <button class="btn btn-outline-warning w-100" id="btn_recientes_entregas">
                        <i class="bi bi-clock-history"></i> Ver Entregas
                    </button>
                </div>

                {{-- <div class="card action-card border-0 shadow-sm p-3 text-center hover-card warning">
                    <i class="bi bi-folder2-open text-warning fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Mis Actas</h5>
                    <p class="text-muted small mb-3">Visualiza tus actas de entrega recientes.</p>
                    <button class="btn btn-outline-warning w-100" id="btn_mis_entregas">
                        <i class="bi bi-folder2-open"></i> Ver Actas
                    </button>
                </div> --}}
                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card info">
                    <i class="bi  bi-hourglass-split text-info fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Pendientes</h5>
                    <p class="text-muted small mb-3">Revisa entregas aún no finalizados.</p>
                    <button class="btn btn-outline-info w-100" id="btn_pendientes">
                        <i class="bi bi-clock-history"></i> Ver Pendientes
                    </button>
                </div>

            </div>
        </div>

    </div>

    <!-- Columna principal: registrar entrega -->
    <div class="main-col col-md-12 col-lg-10 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;">
        <div class="card p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 100vh;">

          <h2 class="mb-4 text-center text-primary">
  <i class="bi bi-box-arrow-in-down me-2"></i>Entrega de Activos
</h2>

            <input type="hidden" id="entrega_id" value="{{ $entrega->id_entrega ?? '' }}">


            <div class="card rounded p-3 mb-3 bg-light" id="contenedor_detalle_entrega">
                @include('user.entregas2.parcial_entrega', ['entrega' => $entrega])
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
                    <button type="button" id="btnBuscarActivos" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalBuscarActivos">
                        agregar activos
                    </button>
                    <button type="submit" id="btnRegistrarEntrega" class="btn btn-success">Registrar Entrega</button>
                </div>
            </div>




            <div id="contenedor_tabla_activos">
                {{-- @include('user.entregas2.parcial_activos', ['detalles' => []]) --}}
            </div>

            <!-- Contenedor de tabla parcial de activos (se actualizará dinámicamente) -->


            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                {{-- <button type="reset" class="btn btn-danger">Limpiar</button> --}}

                {{-- <button class="btn btn-sm btn-primary editar-entrega-btn" data-id="{{ $entrega->id_entrega }}">
                    Editar Acta
                </button> --}}
            </div>

        </div>
    </div>

</div>

<!-- Modal para editar acta de entrega -->
<div class="modal fade" id="modalEditarEntrega" tabindex="-1" aria-labelledby="modalEditarEntregaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalEditarEntregaLabel">Editar Acta de Entrega</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
            </div>
            <div class="modal-footer">

              
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
                <button data-id="{{ $entrega->id_entrega }}" id="seleccionar_entrega" type="button"
                    class="btn btn-lg btn-primary mt-1 btn-seleccionar-entrega">Revisar</button>
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
<div class="modal fade" id="modalBuscarActivos" tabindex="-1" aria-labelledby="modalBuscarActivosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-muted fst-italic" id="modalBuscarActivosLabel">Buscar activos no asignados <span
                        id="servicio_nombre" class="fw-bold"></span> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body"id="modal_body_activos">
                   @include('user.entregas2.parcial_buscarActivos')
               
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>

<div class="modal fade" id="modalEntrega" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Entrega</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal_body_entrega">
                   @include('user.entregas2.parcial_nuevo')


            </div>
        </div>
    </div>
</div>


<div class="modal fade w-100" id="buscarEntrega" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar Entrega</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="body_buscarEntrega">
                <!-- Aquí se cargará la vista parcial -->
                @include('user.entregas2.parcial_buscarActa')
            </div>
        </div>
    </div>
</div>




<script>
    // Ejecutar al cargar la página
    // if (inventarioCargado) {
    //     var inventarioCargado = false;
    // }
    // if (entregaCargado) {
    //     var entregaCargado = false;
    // }

function cargarTablaActivos(entrega_id = null) {
    if (!entrega_id) entrega_id = $('#entrega_id').val();
    if (!entrega_id) {
        mensaje('No se encontró el ID del entrega', 'danger');
        return;
    }

    var $contenedor = $('#contenedor_tabla_activos');
   var $loader = $('#loader').clone(); // clonamos para no mover el original
$loader.show();
$contenedor.append($loader);
    $contenedor.find('table, .tabla-resultados').remove(); // eliminar tabla vieja
// alert($loader.html())
    $.get(`${baseUrl}/entregas/${entrega_id}/activos`, function(response) {
        $contenedor.html(response); // reemplaza solo tabla
    }).fail(function() {
        $contenedor.html('<p>Error al cargar los activos.</p>');
    }).always(function() {
        $loader.hide(); // ocultar loader
    });

    $('#entrega_id').val(entrega_id);
}



    function cargarDetalleEntrega(entrega_id = null) {
        // Toma el ID del input si no se pasa
        if (!entrega_id) entrega_id = $('#entrega_id').val()
        // if (!entrega_id) entrega_id = $('#btn_editar_entrega').data('id');

        if (!entrega_id) {
            mensaje('No se encontró el ID del entrega', 'danger');
            return;
        }
        // alert($('#btn_editar_entrega').data('id'));
function modaleditar(idEntrega){
    // alert(idEntrega) 
    $.ajax({
                url: baseUrl + '/entregas/' + idEntrega + '/editar',
                type: 'GET',
                success: function(data) {
                    $('#modalEditarEntrega .modal-body').html(data);

                    // // Crear instancia de modal y mostrarlo
                    // const modal = new bootstrap.Modal(document.getElementById('modalEditarEntrega'));
                    // modal.show();

                    // // Guardar la instancia en el modal para poder cerrarlo desde dentro del contenido
                    // $('#modalEditarEntrega').data('bs.modal', modal);
                },
                error: function() {
                    mensaje('No se pudo cargar la información del entrega.','danger');
                }
            });
}
        // AJAX GET para traer la vista parcial
        $.ajax({
            url: `${baseUrl}/entregas/${entrega_id}/detalleEntrega`,
            type: 'GET',
            success: function(data) {
                $('#contenedor_detalle_entrega').html(data);
                // $('#entrega_id').val(data.id_entrega);
                // alert(data.id_entrega)
                $('#entrega_id').val(entrega_id);
                $('#servicio_nombre').text(($('#servicio_responsable_destino').data('nombre')))

modaleditar(entrega_id)
$('#resultado_Busqueda').html('');
                // inventarioCargado = false;
                // if (inventarioCargado) {
                //     $("#modalBuscarActivos").removeClass('constante')
                // }
                controlarBotones($('#estado_entrega').data('estado-entrega'));

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
        $('#btnBuscarActivos').prop('disabled', true);
        $('.col-lg-12.d-flex.justify-content-between button[type="submit"]').prop('disabled', true);

        // 🔒 Desactivar todo dentro de la tabla de activos
        $('#contenedor_tabla_activos #tabla_activos')
            .find('button, input, select, textarea')
            .prop('disabled', true)
            .addClass('disabled-element')
    } else if (estado === 'pendiente') {
        // 🔓 Reactivar botones principales
        $('#btnBuscarActivos').prop('disabled', false);
        $('.col-lg-12.d-flex.justify-content-between button[type="submit"]').prop('disabled', false);
        $('#contenedor_tabla_activos #tabla_activos')
            .find('button,  select, textarea')
            .prop('disabled', false)
            .removeClass('disabled-element');
    }
}









    $(document).ready(function() {
        let idEntrega = {{ $entrega->id_entrega }};
        cargarDetalleEntrega();
        cargarTablaActivos();

        $(document).on('click', '#seleccionar_entrega', function() {
            var idEntrega = $(this).data('id');

            // console.log("Entrega seleccionado:", idEntrega);
            // alert(idEntrega    )
            cargarDetalleEntrega(idEntrega);
            cargarTablaActivos(idEntrega);
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

//     $('#seleccionar_entrega').blur();
//     var $btnCerrar = $(this).find('button[data-bs-dismiss="modal"]');
//     $btnCerrar.blur();
//     alert($btnCerrar.html())
// });



$('#btnRegistrarEntrega').on('click', function(e) {
    e.preventDefault();

    const $btn = $(this);
    const idEntrega = $('#div_entrega').find('input[name="id_entrega"]').val();

    if (!idEntrega) {
        mensaje('No se pudo identificar el entrega.', 'warning');
        return;
    }

    if (!confirm('¿Está seguro que desea finalizar y registrar esta entrega?')) return;

   let textoOriginal = $btn.html();

$.ajax({
    url: `${baseUrl}/entregas/${idEntrega}/finalizar`,
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
            cargarDetalleEntrega(idEntrega);
            cargarTablaActivos(idEntrega);

            $btn.prop('disabled', false)
                .html('<i class="bi bi-check-circle"></i> Entrega finalizada');
        } else {
            mensaje(response.message || 'No se pudo finalizar la entrega.', 'danger');
            $btn.prop('disabled', false).html(textoOriginal);
        }
    },

    error: function(xhr) {
        let msg = xhr.responseJSON?.message || 'Ocurrió un error inesperado al finalizar la entrega.';
        mensaje(msg, 'danger');
        $btn.prop('disabled', false).html(textoOriginal);
    }
});

});











        $('#btnBuscarActivos').click(function() {
            // alert("fsdaf")
            // alert(inventarioCargado)
            // if (inventarioCargado) return;
                // $.ajax({
                //     url: "", // ruta que devuelve la vista parcial
                //     method: "GET",
                //     success: function(view) {
                //         $('#modal_body_activos').html(view);
                //         inventarioCargado = true;
                //         if (inventarioCargado) {
                //             $("#modalBuscarActivos").addClass('constante')
                //         }
                //         // $('#buscarEntrega').modal('show'); // abre el modal
                //     },
                //     error: function(xhr) {
                //         console.error(xhr.responseText);
                //         mensaje('Error al cargar el formulario', 'danger');
                //     }
                // });
        });
        $('#buscar_entrega').click(function() {
            //    alert(entregaCargado)
            // if (entregaCargado) {
            //     console.log("retornando")

            //     return;
            // }
            // ALERT("FDSA")
            // $.ajax({
            //     url: "", // ruta que devuelve la vista parcial
            //     method: "GET",
            //     success: function(view) {
            //         $('#body_buscarEntrega').html(view);

            //         entregaCargado = true;
            //         if (entregaCargado) {
            //             $("#buscarEntrega").addClass('constante')
            //         }
            //         // $('#buscarEntrega').modal('show'); // abre el modal
            //     },
            //     error: function(xhr) {
            //         // console.error(xhr.responseText);
            //         mensaje('Error al cargar el formulario', 'danger');
            //     }
            // });
        });

        $('#nueva_entrega').click(function() {
            // $.ajax({
            //     url: "{{ route('entregas.create') }}", // ruta que devuelve la vista parcial
            //     method: "GET",
            //     success: function(view) {
            //         $('#modal_body_entrega').html(view);
            //     },
            //     error: function(xhr) {
            //         console.error(xhr.responseText);
            //         mensaje('Error al cargar el formulario', 'danger');
            //     }
            // });
        });




    });
</script>
