{{-- <div class="container mt-5">
  <h2 class="mb-4 text-center">Gestión de Parámetros del Hospital</h2>
  <div class="row g-4">

    <!-- HU9: Traslado de Activos -->
    <div class="col-md-4">
      <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" id="traslado_activos">
        <i class="bi bi-box-arrow-right text-primary fs-2 mb-2"></i>
        <h5 class="fw-semibold">Traslado de Activos</h5>
        <p class="text-muted small mb-3">Gestiona los movimientos de activos dentro del hospital.</p>
        <button class="btn btn-outline-primary w-100">
          <i class="bi bi-pencil-square"></i> Gestionar Traslados
        </button>
      </div>
    </div>

    <!-- HU13: Servicios del Hospital -->
    <div class="col-md-4">
      <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" id="servicios_hospital">
        <i class="bi bi-hospital text-success fs-2 mb-2"></i>
        <h5 class="fw-semibold">Servicios del Hospital</h5>
        <p class="text-muted small mb-3">Administra los servicios médicos y administrativos.</p>
        <button class="btn btn-outline-success w-100">
          <i class="bi bi-gear"></i> Gestionar Servicios
        </button>
      </div>
    </div>

    <!-- HU14: Cargos del Personal -->
    <div class="col-md-4">
      <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" id="cargos_personal">
        <i class="bi bi-person-badge text-warning fs-2 mb-2"></i>
        <h5 class="fw-semibold">Cargos del Personal</h5>
        <p class="text-muted small mb-3">Define y edita los cargos del personal hospitalario.</p>
        <button class="btn btn-outline-warning w-100">
          <i class="bi bi-person-lines-fill"></i> Gestionar Cargos
        </button>
      </div>
    </div>

    <!-- HU15: Categorías de Activos -->
    <div class="col-md-4">
      <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" id="categorias_activos">
        <i class="bi bi-tags text-info fs-2 mb-2"></i>
        <h5 class="fw-semibold">Categorías de Activos</h5>
        <p class="text-muted small mb-3">Organiza los activos por categoría funcional.</p>
        <button class="btn btn-outline-info w-100">
          <i class="bi bi-list-ul"></i> Gestionar Categorías
        </button>
      </div>
    </div>

    <!-- HU16: Estados de los Activos -->
    <div class="col-md-4">
      <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" id="estados_activos">
        <i class="bi bi-check2-circle text-secondary fs-2 mb-2"></i>
        <h5 class="fw-semibold">Estados de los Activos</h5>
        <p class="text-muted small mb-3">Controla el estado actual de cada activo.</p>
        <button class="btn btn-outline-secondary w-100">
          <i class="bi bi-sliders"></i> Gestionar Estados
        </button>
      </div>
    </div>

    <!-- HU17: Proveedores y Donantes -->
    <div class="col-md-4">
      <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" id="proveedores_donantes">
        <i class="bi bi-people-fill text-danger fs-2 mb-2"></i>
        <h5 class="fw-semibold">Proveedores y Donantes</h5>
        <p class="text-muted small mb-3">Administra las entidades que proveen o donan activos.</p>
        <button class="btn btn-outline-danger w-100">
          <i class="bi bi-person-plus"></i> Gestionar Entidades
        </button>
      </div>
    </div>

  </div>
</div> --}}
















<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold">Gestión de Parámetros del Hospital</h2>
    <div class="row g-4">

        <!-- CARD Servicios -->
        <div class="col-md-4">
            <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" data-bs-toggle="modal"
                data-bs-target="#modalServicios">
                <i class="bi bi-hospital text-primary fs-2 mb-2"></i>
                <h5 class="fw-semibold">Servicios</h5>
                <p class="text-muted small mb-3">Gestiona los servicios hospitalarios.</p>
                <button class="btn btn-outline-primary w-100">Gestionar Servicios</button>
            </div>
        </div>

        <!-- CARD Unidades -->
        <div class="col-md-4">
            <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" data-bs-toggle="modal"
                data-bs-target="#modalUnidades">
                <i class="bi bi-diagram-3 text-success fs-2 mb-2"></i>
                <h5 class="fw-semibold">Unidades</h5>
                <p class="text-muted small mb-3">Gestiona las unidades del hospital.</p>
                <button class="btn btn-outline-success w-100">Gestionar Unidades</button>
            </div>
        </div>

        <!-- CARD Proveedores -->
        <div class="col-md-4">
            <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" data-bs-toggle="modal"
                data-bs-target="#modalProveedores">
                <i class="bi bi-people-fill text-danger fs-2 mb-2"></i>
                <h5 class="fw-semibold">Proveedores</h5>
                <p class="text-muted small mb-3">Gestiona proveedores y donantes.</p>
                <button class="btn btn-outline-danger w-100">Gestionar Proveedores</button>
            </div>
        </div>

        <!-- CARD Estados -->
        <div class="col-md-4">
            <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" data-bs-toggle="modal"
                data-bs-target="#modalEstados">
                <i class="bi bi-check2-circle text-secondary fs-2 mb-2"></i>
                <h5 class="fw-semibold">Estados</h5>
                <p class="text-muted small mb-3">Gestiona los estados de los activos.</p>
                <button class="btn btn-outline-secondary w-100">Gestionar Estados</button>
            </div>
        </div>

        <!-- CARD Donantes -->
        <div class="col-md-4">
            <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" data-bs-toggle="modal"
                data-bs-target="#modalDonantes">
                <i class="bi bi-gift text-warning fs-2 mb-2"></i>
                <h5 class="fw-semibold">Donantes</h5>
                <p class="text-muted small mb-3">Gestiona los donantes de activos.</p>
                <button class="btn btn-outline-warning w-100">Gestionar Donantes</button>
            </div>
        </div>

        <!-- CARD Categorías -->
        <div class="col-md-4">
            <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" data-bs-toggle="modal"
                data-bs-target="#modalCategorias">
                <i class="bi bi-tags text-info fs-2 mb-2"></i>
                <h5 class="fw-semibold">Categorías</h5>
                <p class="text-muted small mb-3">Gestiona las categorías de activos.</p>
                <button class="btn btn-outline-info w-100">Gestionar Categorías</button>
            </div>
        </div>

        <!-- CARD Cargos -->
        <div class="col-md-4">
            <div class="card action-card border-0 shadow-sm p-3 text-center hover-card" data-bs-toggle="modal"
                data-bs-target="#modalCargos">
                <i class="bi bi-person-badge text-dark fs-2 mb-2"></i>
                <h5 class="fw-semibold">Cargos</h5>
                <p class="text-muted small mb-3">Gestiona los cargos del personal.</p>
                <button class="btn btn-outline-dark w-100">Gestionar Cargos</button>
            </div>
        </div>

    </div>
</div>

<!-- Aquí luego agregaremos los modales correspondientes a cada card -->
<!-- ================= MODAL SERVICIOS ================= -->
<!-- ================= MODAL SERVICIOS ================= -->
<!-- ================= MODAL SERVICIOS (TABLA ANCHO COMPLETO, COLORES SUAVES) ================= -->
<!-- ================= MODAL SERVICIOS (BOTONES EN FILA, SOLO 3) ================= -->

<div class="modal fade" id="modalServicios" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <!-- Encabezado -->
            <div class="modal-header border-bottom rounded-2" style="background: rgba(13,110,253,0.15);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-hospital fs-3 text-primary me-2"></i>
                    <h5 class="modal-title fw-bold">Gestión de Servicios Hospitalarios</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body px-4 py-3">

                <!-- Información general -->
                <div class="mb-4">
                    <div class="card border-0 shadow-sm p-3 rounded-2" style="background: rgba(248,249,250,0.2);">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-1"></i> Información General</h6>
                        <p class="mb-0">Administra los servicios hospitalarios registrados: agregar, editar, eliminar
                            y visualizar los servicios.</p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="mb-3">
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Filtrar por Responsable</option>
                            <option value="Dr. Pérez">Dr. Pérez</option>
                            <option value="Lic. Gómez">Lic. Gómez</option>
                        </select>
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Ordenar por</option>
                            <option value="nombre">Nombre</option>
                            <option value="responsable">Responsable</option>
                        </select>
                        <button class="btn btn-outline-secondary btn-sm rounded-2"><i class="bi bi-funnel me-1"></i>
                            Aplicar</button>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="row g-4">

                    <!-- Tabla -->
                    <div class="col-12">
                        <div class="card p-3 border shadow-sm rounded-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle mb-2 w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Responsable</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Emergencias</td>
                                            <td>Atención 24h</td>
                                            <td>Dr. Pérez</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i
                                                            class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i
                                                            class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Laboratorio</td>
                                            <td>Pruebas clínicas</td>
                                            <td>Lic. Gómez</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i
                                                            class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i
                                                            class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Paginación -->
                            <nav>
                                <ul class="pagination pagination-sm justify-content-end mb-0">
                                    <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                                    <li class="page-item active"><a class="page-link">1</a></li>
                                    <li class="page-item"><a class="page-link">2</a></li>
                                    <li class="page-item"><a class="page-link">3</a></li>
                                    <li class="page-item"><a class="page-link">Siguiente</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <div class="col-12 mt-3">
                        <div class="card p-3 border shadow-sm rounded-2" style="background: rgba(248,249,250,0.2);">
                            <h6 class="fw-semibold mb-3"><i class="bi bi-pencil-square me-1"></i> Nuevo / Editar
                                Servicio</h6>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nombre del Servicio</label>
                                        <input type="text" class="form-control form-control-sm rounded-2"
                                            placeholder="Ej: Emergencias">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Descripción</label>
                                        <input type="text" class="form-control form-control-sm rounded-2"
                                            placeholder="Ej: Atención 24h">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Responsable</label>
                                        <select class="form-select form-select-sm rounded-2">
                                            <option value="">Seleccione Responsable</option>
                                            <option value="Dr. Pérez">Dr. Pérez</option>
                                            <option value="Lic. Gómez">Lic. Gómez</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Botones 3 en fila -->
                                <div class="d-flex gap-2 mt-3 justify-content-start">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-2"><i
                                            class="bi bi-save me-1"></i> Guardar</button>
                                    <button type="button" class="btn btn-warning btn-sm rounded-2"><i
                                            class="bi bi-pencil-square me-1"></i> Editar</button>
                                    {{-- <button type="button" class="btn btn-warning btn-sm rounded-2"><i
                                            class="bi bi-pencil-square me-1"></i> Editar</button> --}}
                                    <button type="reset" class="btn btn-secondary    btn-sm rounded-2"><i
                                            class="bi bi-x-circle me-1"></i> Limpiar</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>













<!-- ================= MODAL UNIDADES ================= -->
<div class="modal fade" id="modalUnidades" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <!-- Encabezado -->
            <div class="modal-header border-bottom rounded-2" style="background: rgba(13,110,253,0.15);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-building fs-3 text-primary me-2"></i>
                    <h5 class="modal-title fw-bold">Gestión de Unidades</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body px-4 py-3">

                <!-- Información general -->
                <div class="mb-4">
                    <div class="card border-0 shadow-sm p-3 rounded-2" style="background: rgba(248,249,250,0.2);">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-1"></i> Información General</h6>
                        <p class="mb-0">Administra las unidades del hospital: agregar, editar, eliminar y visualizar los registros.</p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="mb-3">
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Filtrar por Nombre</option>
                            <option value="Unidad A">Unidad A</option>
                            <option value="Unidad B">Unidad B</option>
                        </select>
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Ordenar por</option>
                            <option value="nombre">Nombre</option>
                            <option value="abreviatura">Abreviatura</option>
                        </select>
                        <button class="btn btn-outline-secondary btn-sm rounded-2"><i class="bi bi-funnel me-1"></i> Aplicar</button>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="row g-4">

                    <!-- Tabla -->
                    <div class="col-12">
                        <div class="card p-3 border shadow-sm rounded-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle mb-2 w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Abreviatura</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Unidad A</td>
                                            <td>UA</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Unidad B</td>
                                            <td>UB</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Paginación -->
                            <nav>
                                <ul class="pagination pagination-sm justify-content-end mb-0">
                                    <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                                    <li class="page-item active"><a class="page-link">1</a></li>
                                    <li class="page-item"><a class="page-link">2</a></li>
                                    <li class="page-item"><a class="page-link">3</a></li>
                                    <li class="page-item"><a class="page-link">Siguiente</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <div class="col-12 mt-3">
                        <div class="card p-3 border shadow-sm rounded-2" style="background: rgba(248,249,250,0.2);">
                            <h6 class="fw-semibold mb-3"><i class="bi bi-pencil-square me-1"></i> Nuevo / Editar Unidad</h6>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nombre</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: Unidad A">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Abreviatura</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: UA">
                                    </div>
                                </div>

                                <!-- Botones 3 en fila -->
                                <div class="d-flex gap-2 mt-3 justify-content-start">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-2"><i class="bi bi-save me-1"></i> Guardar</button>
                                    <button type="button" class="btn btn-warning btn-sm rounded-2"><i class="bi bi-pencil-square me-1"></i> Editar</button>
                                    <button type="reset" class="btn btn-secondary btn-sm rounded-2"><i class="bi bi-x-circle me-1"></i> Limpiar</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


























<div class="modal fade" id="modalProveedores" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <!-- Encabezado -->
            <div class="modal-header border-bottom rounded-2" style="background: rgba(13,110,253,0.15);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-building fs-3 text-primary me-2"></i>
                    <h5 class="modal-title fw-bold">Gestión de Proveedores</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body px-4 py-3">

                <!-- Información general -->
                <div class="mb-4">
                    <div class="card border-0 shadow-sm p-3 rounded-2" style="background: rgba(248,249,250,0.2);">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-1"></i> Información General</h6>
                        <p class="mb-0">Administra los proveedores registrados en el sistema: agregar, editar, eliminar y visualizar los datos de contacto y ubicación.</p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="mb-3">
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Filtrar por Nombre</option>
                        </select>
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Ordenar por</option>
                            <option value="nombre">Nombre</option>
                            <option value="lugar">Lugar</option>
                        </select>
                        <button class="btn btn-outline-secondary btn-sm rounded-2"><i class="bi bi-funnel me-1"></i> Aplicar</button>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="row g-4">

                    <!-- Tabla -->
                    <div class="col-12">
                        <div class="card p-3 border shadow-sm rounded-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle mb-2 w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Lugar</th>
                                            <th>Contacto</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Proveedora Alfa</td>
                                            <td>La Paz</td>
                                            <td>+591 70123456</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Proveedora Beta</td>
                                            <td>Cochabamba</td>
                                            <td>+591 71234567</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Paginación -->
                            <nav>
                                <ul class="pagination pagination-sm justify-content-end mb-0">
                                    <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                                    <li class="page-item active"><a class="page-link">1</a></li>
                                    <li class="page-item"><a class="page-link">2</a></li>
                                    <li class="page-item"><a class="page-link">3</a></li>
                                    <li class="page-item"><a class="page-link">Siguiente</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <div class="col-12 mt-3">
                        <div class="card p-3 border shadow-sm rounded-2" style="background: rgba(248,249,250,0.2);">
                            <h6 class="fw-semibold mb-3"><i class="bi bi-pencil-square me-1"></i> Nuevo / Editar Proveedor</h6>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nombre del Proveedor</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: Proveedora Alfa">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Lugar</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: La Paz">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Contacto</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: +591 70123456">
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="d-flex gap-2 mt-3 justify-content-start">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-2"><i class="bi bi-save me-1"></i> Guardar</button>
                                    <button type="button" class="btn btn-warning btn-sm rounded-2"><i class="bi bi-pencil-square me-1"></i> Editar</button>
                                    <button type="reset" class="btn btn-secondary btn-sm rounded-2"><i class="bi bi-x-circle me-1"></i> Limpiar</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

































<div class="modal fade" id="modalEstados" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <!-- Encabezado -->
            <div class="modal-header border-bottom rounded-2" style="background: rgba(13,110,253,0.15);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-clipboard-check fs-3 text-primary me-2"></i>
                    <h5 class="modal-title fw-bold">Gestión de Estados</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body px-4 py-3">

                <!-- Información general -->
                <div class="mb-4">
                    <div class="card border-0 shadow-sm p-3 rounded-2" style="background: rgba(248,249,250,0.2);">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-1"></i> Información General</h6>
                        <p class="mb-0">Administra los estados posibles para los activos o procesos del hospital: agregar, editar, eliminar y visualizar la lista completa.</p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="mb-3">
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Filtrar por Nombre</option>
                        </select>
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Ordenar por</option>
                            <option value="nombre">Nombre</option>
                        </select>
                        <button class="btn btn-outline-secondary btn-sm rounded-2"><i class="bi bi-funnel me-1"></i> Aplicar</button>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="row g-4">

                    <!-- Tabla -->
                    <div class="col-12">
                        <div class="card p-3 border shadow-sm rounded-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle mb-2 w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Activo</td>
                                            <td>Disponible para uso</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Mantenimiento</td>
                                            <td>En reparación o revisión</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Paginación -->
                            <nav>
                                <ul class="pagination pagination-sm justify-content-end mb-0">
                                    <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                                    <li class="page-item active"><a class="page-link">1</a></li>
                                    <li class="page-item"><a class="page-link">2</a></li>
                                    <li class="page-item"><a class="page-link">3</a></li>
                                    <li class="page-item"><a class="page-link">Siguiente</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <div class="col-12 mt-3">
                        <div class="card p-3 border shadow-sm rounded-2" style="background: rgba(248,249,250,0.2);">
                            <h6 class="fw-semibold mb-3"><i class="bi bi-pencil-square me-1"></i> Nuevo / Editar Estado</h6>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nombre del Estado</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: Activo">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Descripción</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: Disponible para uso">
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="d-flex gap-2 mt-3 justify-content-start">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-2"><i class="bi bi-save me-1"></i> Guardar</button>
                                    <button type="button" class="btn btn-warning btn-sm rounded-2"><i class="bi bi-pencil-square me-1"></i> Editar</button>
                                    <button type="reset" class="btn btn-secondary btn-sm rounded-2"><i class="bi bi-x-circle me-1"></i> Limpiar</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>





















<div class="modal fade" id="modalDonantes" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <!-- Encabezado -->
            <div class="modal-header border-bottom rounded-2" style="background: rgba(13,110,253,0.15);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-badge fs-3 text-primary me-2"></i>
                    <h5 class="modal-title fw-bold">Gestión de Donantes</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body px-4 py-3">

                <!-- Información general -->
                <div class="mb-4">
                    <div class="card border-0 shadow-sm p-3 rounded-2" style="background: rgba(248,249,250,0.2);">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-1"></i> Información General</h6>
                        <p class="mb-0">Administra los donantes registrados en el hospital: agregar, editar, eliminar y visualizar los detalles completos.</p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="mb-3">
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Filtrar por Tipo</option>
                            <option value="Interno">Interno</option>
                            <option value="Externo">Externo</option>
                        </select>
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Ordenar por</option>
                            <option value="nombre">Nombre</option>
                            <option value="tipo">Tipo</option>
                        </select>
                        <button class="btn btn-outline-secondary btn-sm rounded-2"><i class="bi bi-funnel me-1"></i> Aplicar</button>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="row g-4">

                    <!-- Tabla -->
                    <div class="col-12">
                        <div class="card p-3 border shadow-sm rounded-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle mb-2 w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Contacto</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Clínica Central</td>
                                            <td>Interno</td>
                                            <td>correo@clinica.com</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Fundación Salud</td>
                                            <td>Externo</td>
                                            <td>contacto@fundsalud.org</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Paginación -->
                            <nav>
                                <ul class="pagination pagination-sm justify-content-end mb-0">
                                    <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                                    <li class="page-item active"><a class="page-link">1</a></li>
                                    <li class="page-item"><a class="page-link">2</a></li>
                                    <li class="page-item"><a class="page-link">3</a></li>
                                    <li class="page-item"><a class="page-link">Siguiente</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <div class="col-12 mt-3">
                        <div class="card p-3 border shadow-sm rounded-2" style="background: rgba(248,249,250,0.2);">
                            <h6 class="fw-semibold mb-3"><i class="bi bi-pencil-square me-1"></i> Nuevo / Editar Donante</h6>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nombre</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: Clínica Central">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tipo</label>
                                        <select class="form-select form-select-sm rounded-2">
                                            <option value="">Seleccione Tipo</option>
                                            <option value="Interno">Interno</option>
                                            <option value="Externo">Externo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Contacto</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: correo@donante.com">
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="d-flex gap-2 mt-3 justify-content-start">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-2"><i class="bi bi-save me-1"></i> Guardar</button>
                                    <button type="button" class="btn btn-warning btn-sm rounded-2"><i class="bi bi-pencil-square me-1"></i> Editar</button>
                                    <button type="reset" class="btn btn-secondary btn-sm rounded-2"><i class="bi bi-x-circle me-1"></i> Limpiar</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
































<div class="modal fade" id="modalCategorias" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <!-- Encabezado -->
            <div class="modal-header border-bottom rounded-2" style="background: rgba(13,110,253,0.15);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-tags fs-3 text-primary me-2"></i>
                    <h5 class="modal-title fw-bold">Gestión de Categorías</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body px-4 py-3">

                <!-- Información general -->
                <div class="mb-4">
                    <div class="card border-0 shadow-sm p-3 rounded-2" style="background: rgba(248,249,250,0.2);">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-1"></i> Información General</h6>
                        <p class="mb-0">Administra las categorías de activos o mobiliario del hospital: agregar, editar, eliminar y visualizar la lista completa.</p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="mb-3">
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Filtrar por Nombre</option>
                        </select>
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Ordenar por</option>
                            <option value="nombre">Nombre</option>
                        </select>
                        <button class="btn btn-outline-secondary btn-sm rounded-2"><i class="bi bi-funnel me-1"></i> Aplicar</button>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="row g-4">

                    <!-- Tabla -->
                    <div class="col-12">
                        <div class="card p-3 border shadow-sm rounded-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle mb-2 w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Mobiliario</td>
                                            <td>Muebles y equipos</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Equipos Médicos</td>
                                            <td>Instrumentos y aparatos</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Paginación -->
                            <nav>
                                <ul class="pagination pagination-sm justify-content-end mb-0">
                                    <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                                    <li class="page-item active"><a class="page-link">1</a></li>
                                    <li class="page-item"><a class="page-link">2</a></li>
                                    <li class="page-item"><a class="page-link">3</a></li>
                                    <li class="page-item"><a class="page-link">Siguiente</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <div class="col-12 mt-3">
                        <div class="card p-3 border shadow-sm rounded-2" style="background: rgba(248,249,250,0.2);">
                            <h6 class="fw-semibold mb-3"><i class="bi bi-pencil-square me-1"></i> Nueva / Editar Categoría</h6>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nombre</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: Mobiliario">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Descripción</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: Muebles y equipos">
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="d-flex gap-2 mt-3 justify-content-start">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-2"><i class="bi bi-save me-1"></i> Guardar</button>
                                    <button type="button" class="btn btn-warning btn-sm rounded-2"><i class="bi bi-pencil-square me-1"></i> Editar</button>
                                    <button type="reset" class="btn btn-secondary btn-sm rounded-2"><i class="bi bi-x-circle me-1"></i> Limpiar</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

























<div class="modal fade" id="modalCargos" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <!-- Encabezado -->
            <div class="modal-header border-bottom rounded-2" style="background: rgba(13,110,253,0.15);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-badge fs-3 text-primary me-2"></i>
                    <h5 class="modal-title fw-bold">Gestión de Cargos</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Cuerpo -->
            <div class="modal-body px-4 py-3">

                <!-- Información general -->
                <div class="mb-4">
                    <div class="card border-0 shadow-sm p-3 rounded-2" style="background: rgba(248,249,250,0.2);">
                        <h6 class="fw-semibold mb-2"><i class="bi bi-info-circle me-1"></i> Información General</h6>
                        <p class="mb-0">Administra los cargos o puestos del personal del hospital: agregar, editar, eliminar y visualizar los detalles.</p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="mb-3">
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Filtrar por Nombre</option>
                        </select>
                        <select class="form-select form-select-sm w-auto rounded-2">
                            <option value="">Ordenar por</option>
                            <option value="nombre">Nombre</option>
                        </select>
                        <button class="btn btn-outline-secondary btn-sm rounded-2"><i class="bi bi-funnel me-1"></i> Aplicar</button>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="row g-4">

                    <!-- Tabla -->
                    <div class="col-12">
                        <div class="card p-3 border shadow-sm rounded-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle mb-2 w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Abreviatura</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Doctor</td>
                                            <td>Dr.</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Enfermero</td>
                                            <td>Enf.</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning rounded-2"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-outline-danger rounded-2"><i class="bi bi-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Paginación -->
                            <nav>
                                <ul class="pagination pagination-sm justify-content-end mb-0">
                                    <li class="page-item disabled"><a class="page-link">Anterior</a></li>
                                    <li class="page-item active"><a class="page-link">1</a></li>
                                    <li class="page-item"><a class="page-link">2</a></li>
                                    <li class="page-item"><a class="page-link">3</a></li>
                                    <li class="page-item"><a class="page-link">Siguiente</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Formulario -->
                    <div class="col-12 mt-3">
                        <div class="card p-3 border shadow-sm rounded-2" style="background: rgba(248,249,250,0.2);">
                            <h6 class="fw-semibold mb-3"><i class="bi bi-pencil-square me-1"></i> Nuevo / Editar Cargo</h6>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nombre</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: Doctor">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Abreviatura</label>
                                        <input type="text" class="form-control form-control-sm rounded-2" placeholder="Ej: Dr.">
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="d-flex gap-2 mt-3 justify-content-start">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-2"><i class="bi bi-save me-1"></i> Guardar</button>
                                    <button type="button" class="btn btn-warning btn-sm rounded-2"><i class="bi bi-pencil-square me-1"></i> Editar</button>
                                    <button type="reset" class="btn btn-secondary btn-sm rounded-2"><i class="bi bi-x-circle me-1"></i> Limpiar</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
