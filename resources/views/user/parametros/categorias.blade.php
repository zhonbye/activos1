  <!-- Formulario compacto para agregar/editar categoría -->
                <form id="formCategoria" class="d-flex gap-2 mb-3">
                    <input type="text" class="form-control form-control-sm" id="nombreCategoria" placeholder="Nombre" required>
                    <input type="text" class="form-control form-control-sm" id="descripcionCategoria" placeholder="Descripción" required>
                    <button type="submit" class="btn btn-sm btn-success rounded-circle" title="Guardar cambios">
                        <i class="bi bi-check2"></i>
                    </button>
                </form>

                <!-- Botones de acción encima de la tabla -->
                <div class="mb-2 d-flex gap-2">
                    <button class="btn btn-sm btn-primary rounded-circle" id="btnAgregarCategoria" title="Agregar nueva categoría">
                        <i class="bi bi-plus"></i>
                    </button>
                    <button class="btn btn-sm btn-danger rounded-circle" id="btnEliminarCategoria" title="Eliminar categoría seleccionada" disabled>
                        <i class="bi bi-trash"></i>
                    </button>
                </div>

                <!-- Tabla de categorías -->
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover table-striped table-sm align-middle text-center">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody id="listaCategorias">
                            @foreach ($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->nombre }}</td>
                                    <td>{{ $categoria->descripcion }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>