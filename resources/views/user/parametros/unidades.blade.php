  <!-- Formulario compacto para agregar/editar unidad -->
  <form id="formUnidad" class="d-flex gap-2 mb-3">
      <input type="text" class="form-control form-control-sm" id="nombreUnidad" placeholder="Nombre" required>
      <input type="text" class="form-control form-control-sm" id="abreviaturaUnidad" placeholder="Abreviatura" required>
      <button type="submit" class="btn btn-sm btn-success rounded-circle" title="Guardar cambios">
          <i class="bi bi-check2"></i>
      </button>
  </form>

  <!-- Botones de acción encima de la tabla -->
  <div class="mb-2 d-flex gap-2">
      <button class="btn btn-sm btn-primary rounded-circle" id="btnAgregar" title="Agregar nueva unidad">
          <i class="bi bi-plus"></i>
      </button>
      <button class="btn btn-sm btn-danger rounded-circle" id="btnEliminar" title="Eliminar unidad seleccionada"
          disabled>
          <i class="bi bi-trash"></i>
      </button>
  </div>

  <!-- Tabla de unidades -->
  <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
      <table class="table table-hover table-striped table-sm align-middle text-center">
          <thead class="table-light sticky-top">
              <tr>
                  <th>Nombre</th>
                  <th>Abreviatura</th>
              </tr>
          </thead>
          <tbody id="listaUnidades">
              @foreach ($unidades as $unidad)
                  <tr>
                      <td>{{ $unidad->nombre }}</td>
                      <td>{{ $unidad->abreviatura }}</td>
                  </tr>
              @endforeach
          </tbody>

      </table>
  </div>
