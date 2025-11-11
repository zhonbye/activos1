<!-- Contenedor principal de inventario -->
<div class="container py-3">

    <!-- Título -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold"><i class="bi bi-box-seam me-2"></i>Inventario</h4>
        <div>
            <button class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-filter"></i> Filtros</button>
            <button class="btn btn-sm btn-success"><i class="bi bi-plus-circle"></i> Nuevo Inventario</button>
        </div>
    </div>

    <!-- Panel de servicios (tabs) -->
    <ul class="nav nav-tabs mb-3" id="inventarioTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-todos" data-bs-toggle="tab" data-bs-target="#todos" type="button">Todos <span class="badge bg-secondary">45</span></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-ti" data-bs-toggle="tab" data-bs-target="#ti" type="button">TI <span class="badge bg-info">12</span></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-auditorio" data-bs-toggle="tab" data-bs-target="#auditorio" type="button">Auditorio <span class="badge bg-warning">8</span></button>
        </li>
    </ul>

    <!-- Contenido de los tabs -->
    <div class="tab-content">

        <!-- Todos -->
        <div class="tab-pane fade show active" id="todos">
            <div class="row g-4">

                <!-- Inventario actual -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white fw-bold d-flex justify-content-between">
                            Inventario Actual
                            <div>
                                <button class="btn btn-sm btn-light"><i class="bi bi-info-circle"></i></button>
                                <button class="btn btn-sm btn-light"><i class="bi bi-gear"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-wrapper">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Código</th>
                                        <th>Cantidad</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Monitor Dell</td>
                                        <td>MD-001</td>
                                        <td><span class="badge bg-primary">10</span></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <i class="bi bi-arrow-right-square-fill text-success btn-move" title="Actualizar"></i>
                                                <i class="bi bi-pencil-square text-warning btn-edit" title="Editar"></i>
                                                <i class="bi bi-trash text-danger btn-delete" title="Eliminar"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Teclado Logitech</td>
                                        <td>TL-022</td>
                                        <td><span class="badge bg-primary">15</span></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <i class="bi bi-arrow-right-square-fill text-success btn-move"></i>
                                                <i class="bi bi-pencil-square text-warning btn-edit"></i>
                                                <i class="bi bi-trash text-danger btn-delete"></i>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Inventario nuevo -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between">
                            Inventario Nuevo
                            <div>
                                <button class="btn btn-sm btn-light"><i class="bi bi-plus-circle"></i></button>
                                <button class="btn btn-sm btn-light"><i class="bi bi-gear"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-wrapper">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Código</th>
                                        <th>Cantidad</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Arrastra aquí o usa el botón de actualizar</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-success btn-sm"><i class="bi bi-check2-circle me-1"></i>Actualizar Inventario</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- TI -->
        <div class="tab-pane fade" id="ti">
            <p class="text-muted">Lista de inventario filtrada por TI</p>
        </div>

        <!-- Auditorio -->
        <div class="tab-pane fade" id="auditorio">
            <p class="text-muted">Lista de inventario filtrada por Auditorio</p>
        </div>

    </div>

</div>
