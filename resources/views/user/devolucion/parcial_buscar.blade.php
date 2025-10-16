<div class="card border-0 shadow-sm p-4 pt-0 mx-0">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start mb-4">
        <!-- Formulario de búsqueda -->
        <div class="flex-grow-1">
          <form id="form_buscar_inventario" class="row g-3 text-start">
            @csrf

            <div class="col-md-4">
              <label for="codigo_activo" class="form-label fw-semibold">Código de Activo</label>
              <input type="text" name="codigo_activo" id="codigo_activo" class="form-control" placeholder="Ej. ACT123">
            </div>

            <div class="col-md-4">
              <label for="estado_actual" class="form-label fw-semibold">Estado Actual</label>
              <select name="estado_actual" id="estado_actual" class="form-select">
                <option value="">Todos...</option>
                <option value="Disponible">Disponible</option>
                <option value="En uso">En uso</option>
                <option value="Dañado">Dañado</option>
                <!-- Añade más opciones según tus estados -->
              </select>
            </div>

            <div class="col-md-4">
              <label for="nombre_activo" class="form-label fw-semibold">Nombre</label>
              <input type="text" name="nombre_activo" id="nombre_activo" class="form-control" placeholder="Nombre del activo">
            </div>

            <div class="col-md-4">
              <label for="detalle_activo" class="form-label fw-semibold">Detalle</label>
              <input type="text" name="detalle_activo" id="detalle_activo" class="form-control" placeholder="Detalle del activo">
            </div>

            <div class="col-md-4">
              <label for="categoria_activo" class="form-label fw-semibold">Categoría</label>
              <input type="text" name="categoria_activo" id="categoria_activo" class="form-control" placeholder="Categoría">
            </div>

            <div class="col-md-4">
              <label for="unidad_activo" class="form-label fw-semibold">Unidad</label>
              <input type="text" name="unidad_activo" id="unidad_activo" class="form-control" placeholder="Unidad">
            </div>

            <!-- Botones -->
            <div class="col-12 text-center mt-4 d-flex gap-3 justify-content-center">
              <button type="button" id="btn_buscar_inventario" class="btn btn-primary w-25">
                <i class="bi bi-search me-1"></i> Buscar
              </button>
              <button type="reset" class="btn btn-danger w-25">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
              </button>
            </div>
          </form>
        </div>

        <!-- Icono y título a la derecha -->
        <div class="ms-4 text-center">
          <i class="bi bi-search text-primary fs-1"></i>
          <h4 class="fw-bold mt-2">Buscar Inventario</h4>
          <p class="text-muted small">Ingrese los criterios para encontrar activos en el inventario</p>
        </div>
      </div>

      <!-- Resultados -->
      <div id="resultado_inventario" class="mt-4"></div>
    </div>
  </div>

  <script>
    $(document).on('click', '#btn_buscar_inventario', function() {
      $.ajax({
        url: "{{ route('inventario.buscar') }}", // Ajusta la ruta de tu backend
        type: 'POST',
        data: $('#form_buscar_inventario').serialize(),
        success: function(html) {
          // Renderiza la tabla o contenido recibido
          $('#resultado_inventario').html(html);
        },
        error: function(xhr) {
          if (xhr.responseJSON && xhr.responseJSON.message) {
            mensaje(xhr.responseJSON.message, 'danger');
          } else {
            mensaje('Ocurrió un error inesperado.', 'danger');
          }
        }
      });
    });
  </script>
