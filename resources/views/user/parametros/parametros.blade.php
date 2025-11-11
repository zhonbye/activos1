<div class="row bg-info0 pb-4 justify-content-center" style="height: 90vh; min-height: 30vh; max-height:94vh;">
    <div class="main-col col-md-12 col-lg-11 bg-danger0 order-lg-1 order-1 mb-4 p-1 transition"
        style="position: relative; height: 80vh; min-height: 40vh; max-height: 80vh; display: flex; flex-direction: column; overflow: visible;">

        <div class="card p-4 rounded shadow"
            style="position: relative; background-color: var(--color-fondo); display: flex; flex-direction: column; flex: 1 1 auto;">

            <!-- Título -->
            <h2 class="mb-4 text-center text-primary">
                <i class="bi bi-gear me-2"></i>Gestión de Parámetros
            </h2>

            <!-- Cuadrícula de tarjetas -->
            <div class="row g-4" style="flex: 1 1 auto; overflow-y: auto; padding: 15px;">

                <!-- CARD Servicios -->
                <div class="col-md-4">
                    <div class="card action-card border-0 shadow-lg p-4 text-center hover-card rounded-4"
                        data-bs-toggle="modal" data-bs-target="#modalServicios" style="height: 300px;">
                        <i class="bi bi-hospital text-primary fs-1 mb-3"></i>
                        <h5 class="fw-bold">Servicios</h5>
                        <p class="text-muted small mb-3">Gestiona los servicios hospitalarios.</p>
                        <button class="btn btn-outline-primary w-100 py-3 rounded-pill">Gestionar Servicios</button>
                    </div>
                </div>

                <!-- CARD Unidades -->
                <div class="col-md-4">
                    <div class="card action-card border-0 shadow-lg p-4 text-center hover-card rounded-4"
                        data-bs-toggle="modal" data-bs-target="#modalUnidad" style="height: 300px;">
                        <i class="bi bi-diagram-3 text-success fs-1 mb-3"></i>
                        <h5 class="fw-bold">Unidades</h5>
                        <p class="text-muted small mb-3">Gestiona las unidades del hospital.</p>
                        <button class="btn btn-outline-success w-100 py-3 rounded-pill">Gestionar Unidades</button>
                    </div>
                </div>

                <!-- CARD Proveedores -->
                <div class="col-md-4">
                    <div class="card action-card border-0 shadow-lg p-4 text-center hover-card rounded-4"
                        data-bs-toggle="modal" data-bs-target="#modalProveedores" style="height: 300px;">
                        <i class="bi bi-people-fill text-danger fs-1 mb-3"></i>
                        <h5 class="fw-bold">Proveedores</h5>
                        <p class="text-muted small mb-3">Gestiona proveedores y donantes.</p>
                        <button class="btn btn-outline-danger w-100 py-3 rounded-pill">Gestionar Proveedores</button>
                    </div>
                </div>

                <!-- CARD Estados -->
                <div class="col-md-4">
                    <div class="card action-card border-0 shadow-lg p-4 text-center hover-card rounded-4"
                       data-bs-toggle="modal" data-bs-target="#modalEstados" style="height: 300px;">
                        <i class="bi bi-check2-circle text-secondary fs-1 mb-3"></i>
                        <h5 class="fw-bold">Estados</h5>
                        <p class="text-muted small mb-3">Gestiona los estados de los activos.</p>
                        <button class="btn btn-outline-secondary w-100 py-3 rounded-pill">Gestionar Estados</button>
                    </div>
                </div>

                <!-- CARD Donantes -->
                <div class="col-md-4">
                    <div class="card action-card border-0 shadow-lg p-4 text-center hover-card rounded-4"
                        data-bs-toggle="modal" data-bs-target="#modalDonantes" style="height: 300px;">
                        <i class="bi bi-gift text-warning fs-1 mb-3"></i>
                        <h5 class="fw-bold">Donantes</h5>
                        <p class="text-muted small mb-3">Gestiona los donantes de activos.</p>
                        <button class="btn btn-outline-warning w-100 py-3 rounded-pill">Gestionar Donantes</button>
                    </div>
                </div>

                <!-- CARD Categorías -->
                <div class="col-md-4">
                    <div class="card action-card border-0 shadow-lg p-4 text-center hover-card rounded-4"
                        data-bs-toggle="modal" data-bs-target="#modalCategorias" style="height: 300px;">
                        <i class="bi bi-tags text-info fs-1 mb-3"></i>
                        <h5 class="fw-bold">Categorías</h5>
                        <p class="text-muted small mb-3">Gestiona las categorías de activos.</p>
                        <button class="btn btn-outline-info w-100 py-3 rounded-pill">Gestionar Categorías</button>
                    </div>
                </div>

                <!-- CARD Cargos -->
                <div class="col-md-4">
                    <div class="card action-card border-0 shadow-lg p-4 text-center hover-card rounded-4"
                       data-bs-toggle="modal" data-bs-target="#modalCargos" style="height: 300px;">
                        <i class="bi bi-person-badge text-dark fs-1 mb-3"></i>
                        <h5 class="fw-bold">Cargos</h5>
                        <p class="text-muted small mb-3">Gestiona los cargos del personal.</p>
                        <button class="btn btn-outline-dark w-100 py-3 rounded-pill">Gestionar Cargos</button>
                    </div>
                </div>

                <!-- TARJETA AGREGAR (siempre última) -->
                <div class="col-md-4">
                    <div class="card rounded-4 d-flex align-items-center justify-content-center shadow-sm"
                        style="height: 300px; background-color: #e0e0e0; cursor: pointer;" id="agregarTarjeta">
                        <button
                            class="btn btn-outline-primary w-100 h-100 d-flex align-items-center justify-content-center flex-column rounded-4">
                            <i class="bi bi-plus-lg" style="font-size: 2.5rem;"></i>
                            <span class="mt-2 fw-bold">Agregar</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<!-- Botón para abrir modal Categorías -->
<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCategorias">
    <i class="bi bi-tags me-1"></i> Gestionar Categorías
</button>

<!-- Modal Categorías -->
<div class="modal fade" id="modalCategorias" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--color-fondo); color: var(--color-texto-principal);">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-tags me-1"></i> Categorías</h5>
                <button type="button" class="btn-close btn-close-success" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                @include('user.parametros.categorias')

              

            <!-- Footer simple -->
            <div class="modal-footer">
                {{-- Footer opcional --}}
            </div>

        </div>
    </div>
</div>


<!-- Modal Cargos -->
<div class="modal fade" id="modalCargos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--color-fondo); color: var(--color-texto-principal);">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-badge me-1"></i> Cargos</h5>
                <button type="button" class="btn-close btn-close-success" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                {{-- Aquí incluirías tu vista parcial Blade para los cargos --}}
                @include('user.parametros.cargos')
            </div>

            <!-- Footer simple -->
            <div class="modal-footer">
                {{-- Footer opcional --}}
            </div>

        </div>
    </div>
</div>

<!-- Modal Estados -->
<div class="modal fade" id="modalEstados" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--color-fondo); color: var(--color-texto-principal);">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-check2-circle me-1"></i> Estados</h5>
                <button type="button" class="btn-close btn-close-success" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                {{-- Aquí incluirías tu vista parcial Blade para los estados --}}
                @include('user.parametros.estados')
            </div>

            <!-- Footer simple -->
            <div class="modal-footer">
                {{-- Footer opcional --}}
            </div>

        </div>
    </div>
</div>


<!-- Modal Compacto -->
<div class="modal fade" id="modalUnidad" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--color-fondo); color: var(--color-texto-principal);">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-list-ul me-1"></i> Unidades</h5>
                <button type="button" class="btn-close btn-close-success" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

              @include('user.parametros.unidades')

            </div>

            <!-- Footer simple -->
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Cerrar
                </button> --}}
            </div>

        </div>
    </div>
</div>















<!-- JS para selección de fila y acciones -->
<script>
    const tbody = document.getElementById('listaUnidades');
    let selectedRow = null;

    // Seleccionar fila y precargar formulario
    tbody.addEventListener('click', (e) => {
        const tr = e.target.closest('tr');
        if (!tr) return;

        // Quitar selección anterior
        if (selectedRow) selectedRow.classList.remove('table-primary');
        selectedRow = tr;
        selectedRow.classList.add('table-primary');

        // Activar botón de eliminar
        document.getElementById('btnEliminar').disabled = false;

        // Rellenar formulario
        document.getElementById('nombreUnidad').value = tr.cells[0].textContent;
        document.getElementById('abreviaturaUnidad').value = tr.cells[1].textContent;
    });

    // Limpiar selección al agregar nueva unidad
    document.getElementById('btnAgregar').addEventListener('click', () => {
        if (selectedRow) selectedRow.classList.remove('table-primary');
        selectedRow = null;
        document.getElementById('btnEliminar').disabled = true;
        document.getElementById('formUnidad').reset();
    });

    // Guardar cambios desde formulario
    document.getElementById('formUnidad').addEventListener('submit', (e) => {
        e.preventDefault();
        const nombre = document.getElementById('nombreUnidad').value;
        const abreviatura = document.getElementById('abreviaturaUnidad').value;

        if (selectedRow) {
            selectedRow.cells[0].textContent = nombre;
            selectedRow.cells[1].textContent = abreviatura;
        } else {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${nombre}</td><td>${abreviatura}</td>`;
            tbody.appendChild(tr);
        }

        // Limpiar selección y formulario
        if (selectedRow) selectedRow.classList.remove('table-primary');
        selectedRow = null;
        document.getElementById('btnEliminar').disabled = true;
        e.target.reset();
    });

    // Eliminar fila seleccionada
    document.getElementById('btnEliminar').addEventListener('click', () => {
        if (!selectedRow) return;
        if (confirm('¿Deseas eliminar esta unidad?')) {
            selectedRow.remove();
            selectedRow = null;
            document.getElementById('btnEliminar').disabled = true;
            document.getElementById('formUnidad').reset();
        }
    });
</script>
