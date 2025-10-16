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

                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card primary" >
                    <i class="bi bi-plus-circle text-primary fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Nuevo Traslado</h5>
                    <p class="text-muted small mb-3">Registra un nuevo acta de traslado.</p>
                    <button class="btn btn-outline-primary w-100" id="nuevo_traslado" data-bs-toggle="modal"
                        data-bs-target="#modalTraslado">
                        <i class="bi bi-file-earmark-plus"></i> Crear Acta
                    </button>
                </div>

                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card success">
                    <i class="bi bi-search text-success fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Buscar Acta</h5>
                    <p class="text-muted small mb-3">Consulta un acta registrada.</p>
                    <button class="btn btn-outline-success w-100" id="buscar_traslado">
                        <i class="bi bi-search"></i> Buscar Traslado
                    </button>
                </div>

                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card warning">
                    <i class="bi bi-folder2-open text-warning fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Mis Actas</h5>
                    <p class="text-muted small mb-3">Visualiza tus actas de traslado recientes.</p>
                    <button class="btn btn-outline-warning w-100" id="btn_mis_traslados">
                        <i class="bi bi-folder2-open"></i> Ver Actas
                    </button>
                </div>
                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card info">
                    <i class="bi bi-clock-history text-info fs-2 mb-2"></i>
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

            <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Registrar Traslado de Activos</h2>

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
                <div class="col-lg-6">
                    <button type="button" id="btn_consultar_inventario" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalInventario">
                        Consultar Inventario
                    </button>
                </div>
            </div>



            <div id="contenedor_tabla_activos">
                @include('user.traslados.parcial_activos', ['detalles' => []])
            </div>

            <!-- Contenedor de tabla parcial de activos (se actualizará dinámicamente) -->


            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="reset" class="btn btn-danger">Limpiar</button>
                <button type="submit" class="btn btn-success">Registrar Traslado</button>
                <button class="btn btn-sm btn-primary editar-traslado-btn" data-id="{{ $traslado->id_traslado }}">
                    Editar Acta
                </button>
            </div>

        </div>
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="modalInventario" tabindex="-1" aria-labelledby="modalInventarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalInventarioLabel">Inventario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body"id="modal_body_inventario">
          <!-- Aquí puedes poner el contenido dinámico de inventario -->
          <p>Aquí va el contenido del inventario...</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
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
                <h5 class="modal-title">Nuevo Traslado</h5>
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

    function cargarTablaActivos(traslado_id = null) {
        if (!traslado_id) traslado_id = $('#traslado_id').val()
        if (!traslado_id) {
            mensaje('No se encontró el ID del traslado', 'danger');
            return;
        }
        // let traslado_id = $('#traslado_id').val();
        $('#contenedor_tabla_activos').load(`${baseUrl}/traslados/${traslado_id}/activos`);
        $('#traslado_id').val($('#btn_editar_traslado').data('id'));
    }

    function cargarDetalleTraslado(traslado_id = null) {
        // Toma el ID del input si no se pasa
        if (!traslado_id) traslado_id = $('#btn_editar_traslado').data('id');

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






    $(document).ready(function() {
        let idTraslado = {{ $traslado->id_traslado }};
        cargarDetalleTraslado();
        cargarTablaActivos();


        $('#buscar_traslado').click(function() {
            $.ajax({
                url: "{{ route('traslados.mostrarBuscar') }}", // ruta que devuelve la vista parcial
                method: "GET",
                success: function(view) {
                    $('#body_buscarTraslado').html(view);
                    $('#buscarTraslado').modal('show'); // abre el modal
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error al cargar el formulario');
                }
            });
        });

        $('#nuevo_traslado').click(function() {
            $.ajax({
                url: "{{ route('traslados.create') }}", // ruta que devuelve la vista parcial
                method: "GET",
                success: function(view) {
                    $('#modal_body_traslado').html(view);
                    // $('#modalTraslado').modal('show'); // abre el modal
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error al cargar el formulario');
                }
            });
        });










        // Botón de recargar


        // Agregar activo (tu código)
        $('#btn_agregar_activo').click(function() {
            let codigo = $('#input_activo_codigo').val().trim();
            if (!codigo) {
                mensaje('Ingrese código o nombre del activo.', 'danger');
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
                    const traslado_id = $('#btn_editar_traslado').data('id');
                    // alert(traslado_id)
                    $.ajax({
                        url: `${baseUrl}/traslados/${traslado_id}/activos/agregar`,
                        type: 'POST',
                        data: {
                            id_activo: activo.id_activo,
                            cantidad: 1,
                            observaciones: '',
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Registro exitoso
                                cargarTablaActivos
                            (); // recarga tabla automáticamente
                                $('#input_activo_codigo').val('');
                                mensaje(response.message ||
                                    'Activo agregado correctamente.',
                                    'success');
                            } else {
                                // Caso que devuelvas success = false desde el controlador
                                mensaje(response.error || 'Ocurrió un error.',
                                    'danger');
                            }
                        },
                        error: function(xhr) {
                            // Errores de validación 422
                            if (xhr.status === 422 && xhr.responseJSON.errors) {
                                let msg = '';
                                $.each(xhr.responseJSON.errors, function(key,
                                    val) {
                                    msg += val[0] + '<br>';
                                });
                                mensaje(msg, 'danger');
                            } else if (xhr.responseJSON && xhr.responseJSON
                                .error) {
                                // Otros errores devueltos con response()->json(['error' => '...'])
                                mensaje(xhr.responseJSON.error, 'danger');
                            } else {
                                // Cualquier otro error inesperado
                                mensaje('Ocurrió un error inesperado.',
                                    'danger');
                            }
                        }
                    });


                }
            });
        });

    });
</script>
