<!-- Formulario compacto para agregar/editar estado -->
<form id="formEstado" class="d-flex gap-2 mb-3">
    <input type="text" class="form-control form-control-sm" id="nombreEstado" placeholder="Nombre" required>
    <input type="text" class="form-control form-control-sm" id="descripcionEstado" placeholder="Descripción" required>
    <button type="submit" class="btn btn-sm btn-success rounded-circle" title="Guardar cambios">
        <i class="bi bi-check2"></i>
    </button>
</form>

<!-- Botones de acción encima de la tabla -->
<div class="mb-2 d-flex gap-2">
    <button class="btn btn-sm btn-primary rounded-circle" id="btnAgregarEstado" title="Agregar nuevo estado">
        <i class="bi bi-plus"></i>
    </button>
    <button class="btn btn-sm btn-danger rounded-circle" id="btnEliminarEstado" title="Eliminar estado seleccionado" disabled>
        <i class="bi bi-trash"></i>
    </button>
</div>

<!-- Tabla de estados -->
<div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
    <table class="table table-hover table-striped table-sm align-middle text-center">
        <thead class="table-light sticky-top">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody id="listaEstados">
            @foreach ($estados as $estado)
                <tr>
                    <td>{{ $estado->nombre }}</td>
                    <td>{{ $estado->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
