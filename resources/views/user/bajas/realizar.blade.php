<!-- Sección Dar de Baja Activos -->
<div class="container my-4">

  <div class="card shadow-sm">
    <div class="card-header bg-warning text-white">
      <h5 class="mb-0">Registrar Baja de Activos</h5>
    </div>

    <div class="card-body">
      <!-- Formulario principal de la baja -->
      <form id="formBajaActivos">
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="numero_documento" class="form-label">Número de Documento</label>
            <input type="text" class="form-control" id="numero_documento" placeholder="Ej: BAJ-001">
          </div>
          <div class="col-md-2">
            <label for="gestion" class="form-label">Gestión</label>
            <input type="number" class="form-control" id="gestion" placeholder="2025">
          </div>
          <div class="col-md-3">
            <label for="fecha" class="form-label">Fecha de Baja</label>
            <input type="date" class="form-control" id="fecha">
          </div>
          <div class="col-md-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado">
              <option selected disabled>Seleccione...</option>
              <option>Pendiente</option>
              <option>Aprobada</option>
              <option>Rechazada</option>
            </select>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label for="responsable" class="form-label">Responsable</label>
            <select class="form-select" id="responsable">
              <option selected disabled>Seleccione...</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="servicio" class="form-label">Servicio</label>
            <select class="form-select" id="servicio">
              <option selected disabled>Seleccione...</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="documento" class="form-label">Documento (opcional)</label>
            <input type="file" class="form-control" id="documento">
          </div>
        </div>

        <div class="mb-3">
          <label for="observaciones" class="form-label">Observaciones</label>
          <textarea class="form-control" id="observaciones" rows="2" placeholder="Ingrese observaciones..."></textarea>
        </div>

        <!-- Tabla de detalle de activos -->
        <div class="mb-3">
          <h6>Activos a dar de baja</h6>
          <div style="max-height: 50vh; overflow-y: auto;">
            <table class="table table-striped table-bordered mb-0">
              <thead class="table-light">
                <tr>
                  <th>Activo</th>
                  <th>Cantidad</th>
                  <th>Observaciones</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <select class="form-select">
                      <option selected disabled>Seleccione un activo</option>
                    </select>
                  </td>
                  <td><input type="number" class="form-control" min="1"></td>
                  <td><input type="text" class="form-control"></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger">Eliminar</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn btn-sm btn-outline-primary mt-2">+ Agregar Activo</button>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="reset" class="btn btn-warning">Restablecer</button>
          <button type="submit" class="btn btn-primary">Registrar Baja</button>
        </div>
      </form>
    </div>
  </div>

</div>

