<style>
.hover-card {
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}

.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.hover-card.success:hover {
    background-color: rgba(40, 167, 69, 0.15); /* verde */
}

.hover-card.warning:hover {
    background-color: rgba(255, 193, 7, 0.2); /* amarillo */
}

.hover-card.danger:hover {
    background-color: rgba(220, 53, 69, 0.15); /* rojo */
}

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

        <!-- Buscar devolucion -->
        <div class="sidebar-col card p-3">
            <div class="sidebar-header d-flex justify-content-between align-items-start">
                <button class="toggleSidebar btn btn-primary">⮞</button>
                <h2 class="sidebar-title fs-5 text-fw mb-0 ms-2">devolucion</h2>
            </div>

            <div class="acciones-devolucion d-grid gap-3">
                <h3 class="fs-6 my-3">Acciones rápidas</h3>

                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" id="nuevo_devolucion">
                    <i class="bi bi-plus-circle text-primary fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Nuevo devolucion</h5>
                    <p class="text-muted small mb-3">Registra un nuevo acta de devolucion.</p>
                    <button class="btn btn-outline-primary w-100" id="btn_nuevo_devolucion" data-bs-toggle="modal"
                data-bs-target="#modaldevolucion">
                        <i class="bi bi-file-earmark-plus"></i> Crear Acta
                    </button>
                </div>

                <div id="buscar_devolucion" class="card action-card border-0 shadow-sm p-3 text-center hover-card success">
                    <i class="bi bi-search text-success fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Buscar Acta</h5>
                    <p class="text-muted small mb-3">Consulta un acta registrada.</p>
                    <button class="btn btn-outline-success w-100" id="buscar_devolucion">
                        <i class="bi bi-search"></i> Buscar devolucion
                    </button>
                </div>

                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card">
                    <i class="bi bi-folder2-open text-warning fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Mis Actas</h5>
                    <p class="text-muted small mb-3">Visualiza tus actas de devolucion recientes.</p>
                    <button class="btn btn-outline-warning w-100" id="btn_mis_devolucions">
                        <i class="bi bi-folder2-open"></i> Ver Actas
                    </button>
                </div>
                <div class="card action-card border-0 shadow-sm p-3 text-center hover-card">
                    <i class="bi bi-clock-history text-info fs-2 mb-2"></i>
                    <h5 class="fw-semibold">Pendientes</h5>
                    <p class="text-muted small mb-3">Revisa devolucions aún no finalizados.</p>
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

            <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Registrar devolucion de Activos</h2>

            <input type="hidden" id="devolucion_id" value="{{ $devolucion->id_devolucion ?? '' }}">


            <div class="card rounded p-3 mb-3 bg-light" id="contenedor_detalle_devolucion">
                @include('user.devolucion.parcial_devolucion', ['devolucion' => $devolucion])
            </div>
            <!-- Buscar y agregar activos -->
            <div class="row g-3 mb-3">
                <div class="col-lg-6">
                    <div class="input-group mb-3">
                        <input type="text" id="input_activo_codigo" class="form-control"
                            placeholder="Código o nombre del activo">
                        <button type="button" id="btn_agregar_activo" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            </div>
            <div id="contenedor_tabla_activos">
                {{-- @include('user.devolucion.parcial_activos', ['detalles' => []]) --}}
            </div>

            <!-- Contenedor de tabla parcial de activos (se actualizará dinámicamente) -->


            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="reset" class="btn btn-danger">Limpiar</button>
                <button type="submit" class="btn btn-success">Registrar devolucion</button>
                <button class="btn btn-sm btn-primary editar-devolucion-btn" data-id="{{ $devolucion->id_devolucion }}">
                    Editar Acta
                </button>
            </div>

        </div>
    </div>

</div>
<div class="modal fade" id="modaldevolucion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo devolucion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal_body_devolucion">
                <!-- Aquí se cargará la vista parcial -->
                Cargando contenido...
            </div>
        </div>
    </div>
</div>



<div class="modal fade w-100" id="buscardevolucion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo devolucion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="body_buscardevolucion">
                <!-- Aquí se cargará la vista parcial -->
            </div>
        </div>
    </div>
</div>

<script>
    $('#buscar_devulucion').click(function() {
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
</script>
