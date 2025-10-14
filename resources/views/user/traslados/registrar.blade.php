<div class="row p-0 mb-4 pb-4" style="height: 90vh;">

  <!-- Sidebar de búsqueda de acta -->
  <div class="sidebar-wrapper col-md-12 col-lg-2 order-lg-2 order-2 d-flex flex-column pb-2 gap-3 transition" style="max-height: 95vh;">
    
    <!-- Buscar Traslado -->
    <div class="sidebar-col card p-3">
      <div class="sidebar-header d-flex justify-content-between align-items-start">
        <button class="toggleSidebar btn btn-primary">⮞</button>
        <h2 class="sidebar-title fs-5 text-fw mb-0 ms-2">Traslado</h2>
      </div>

      <h3>Buscar Acta de Traslado</h3>
      <div class="row g-2 align-items-center my-1">
        <div class="col-md-6">
          <input type="number" id="numero_traslado_buscar" class="form-control input-form con-ceros" placeholder="Número de Acta" value="001">
        </div>
        <div class="col-md-6">
          <input type="number" id="gestion_traslado_buscar" class="form-control input-form" value="{{ date('Y') }}" placeholder="Gestión (Ej. 2025)">
        </div>
      </div>
      <div class="row g-2 align-items-center my-1">
        <div class="col-12">
          <button class="btn btn-outline-primary w-100" id="btn_buscar_traslado" type="button">Buscar Acta</button>
        </div>
      </div>

      <!-- Resultado búsqueda -->
      <div class="resultado_busqueda_traslado resultado overflow-auto mt-4" style="display: none; max-height: 300px; width: 100%;">
        <div class="alert alert-success text-break" role="alert">
          <strong>Acta encontrada:</strong>
          <div class="mt-3">
            <p class="mb-1"><strong>Estado:</strong> <span id="traslado_estado"></span></p>
            <p class="mb-1"><strong>Número:</strong> <span id="traslado_numero"></span></p>
            <p class="mb-1"><strong>Gestión:</strong> <span id="traslado_gestion"></span></p>
            <p class="mb-1"><strong>Fecha:</strong> <span id="traslado_fecha"></span></p>
            <p class="mb-1"><strong>Servicio Origen:</strong> <span id="traslado_servicio_origen"></span></p>
            <p class="mb-1"><strong>Responsable Origen:</strong> <span id="traslado_responsable_origen"></span></p>
            <p class="mb-1"><strong>Servicio Destino:</strong> <span id="traslado_servicio_destino"></span></p>
            <p class="mb-1"><strong>Responsable Destino:</strong> <span id="traslado_responsable_destino"></span></p>
            <p class="mb-1"><strong>Observaciones:</strong> <span id="traslado_observaciones"></span></p>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Columna principal: registrar traslado -->
  <div class="main-col col-md-12 col-lg-10 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;">
    <div class="card p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 100vh;">
      
      <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Registrar Traslado de Activos</h2>

      <form id="form_detalle_traslado" method="POST">
        @csrf
        <input type="hidden" id="traslado_id" name="traslado_id" value="">
        
        <!-- Información general del traslado -->
        <div class="row g-3 mb-3">
          <div class="col-lg-3">
            <label for="numero_traslado" class="form-label">Número de Traslado</label>
            <input type="text" id="numero_traslado" name="numero_traslado" class="form-control" value="{{ $ultimoNumero ?? '001' }}">
          </div>
          <div class="col-lg-3">
            <label for="gestion_traslado" class="form-label">Gestión</label>
            <input type="number" id="gestion_traslado" name="gestion_traslado" class="form-control" value="{{ date('Y') }}">
          </div>
          <div class="col-lg-3">
            <label for="fecha_traslado" class="form-label">Fecha</label>
            <input type="date" id="fecha_traslado" name="fecha_traslado" class="form-control" value="{{ date('Y-m-d') }}">
          </div>
          <div class="col-lg-3">
            <label for="observaciones_traslado" class="form-label">Observaciones</label>
            <input type="text" id="observaciones_traslado" name="observaciones_traslado" class="form-control">
          </div>
        </div>

        <!-- Responsable y servicios -->
        <div class="row g-3 mb-3">
          <div class="col-lg-3">
            <label for="resp_origen" class="form-label">Responsable Origen</label>
            <select id="resp_origen" name="resp_origen" class="form-select">
              <option selected disabled>Seleccione...</option>
            </select>
          </div>
          <div class="col-lg-3">
            <label for="servicio_origen" class="form-label">Servicio Origen</label>
            <select id="servicio_origen" name="servicio_origen" class="form-select">
              <option selected disabled>Seleccione...</option>
            </select>
          </div>
          <div class="col-lg-3">
            <label for="resp_destino" class="form-label">Responsable Destino</label>
            <select id="resp_destino" name="resp_destino" class="form-select">
              <option selected disabled>Seleccione...</option>
            </select>
          </div>
          <div class="col-lg-3">
            <label for="servicio_destino" class="form-label">Servicio Destino</label>
            <select id="servicio_destino" name="servicio_destino" class="form-select">
              <option selected disabled>Seleccione...</option>
            </select>
          </div>
        </div>

        <!-- Agregar activos al traslado -->
        <div class="row g-3 mb-3">
          <div class="col-lg-6">
            <label class="form-label">Agregar Activo</label>
            <div class="input-group mb-3">
              <input type="text" id="input_activo_codigo" class="form-control" placeholder="Código o nombre del activo">
              <button type="button" id="btn_agregar_activo" class="btn btn-primary">Agregar</button>
            </div>
          </div>
        </div>

        <!-- Tabla de activos a trasladar -->
        <div class="row g-3 mb-3">
          <div class="col-12">
            <h5>Activos del Traslado</h5>
            <table class="table table-striped" id="tabla_activos_traslado">
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Cantidad</th>
                  <th>Unidad</th>
                  <th>Detalle</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody id="body_activos_traslado">
                <tr id="fila_vacia">
                  <td colspan="7" class="text-center text-muted">No hay activos agregados</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end gap-2">
          <button type="reset" class="btn btn-danger">Limpiar</button>
          <button type="submit" class="btn btn-success">Registrar Traslado</button>
        </div>

      </form>

    </div>
  </div>

</div>
