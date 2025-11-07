


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historial de Activos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
  body { background-color: #f4f6f8; }
  .card-filtro { background-color: #f8f9fa; border-left: 5px solid #0d6efd; padding: 1.5rem; }
  .table thead { background-color: #0d6efd; color: white; }
  .table tbody tr:hover { background-color: #e9f2ff; }
  .btn-azul { background-color: #0d6efd; color: white; }
  .btn-azul:hover { background-color: #0b5ed7; color: white; }
  .btn-rojo { background-color: #dc3545; color: white; }
  .btn-rojo:hover { background-color: #b02a37; color: white; }
  .modal-header { background-color: #343a40; color: white; }
  .modal-body { background-color: #f8f9fa; }
  .form-label { font-size: 0.9rem; }
  .btn-filtro {  margin-top: 1rem; }
</style>
</head>
<body>

<div class="container py-4">
  <div class="main-col col-md-12 col-lg-12 mb-4 p-1">
    <div class="card p-4 rounded shadow" style="min-height: 100vh;">

      <!-- Título -->
      <h2 class="mb-4 text-center text-primary">
        <i class="bi bi-journal-text me-2"></i>Historial de Activos
      </h2>

      <!-- Botón imprimir historial general -->
      <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-azul btn-sm" id="btnImprimirHistorial" title="Imprimir todo el historial">
          <i class="bi bi-printer-fill me-1"></i> Imprimir Historial
        </button>
      </div>

      <!-- Filtros -->
      <div class="card card-filtro mb-4 shadow-sm">
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold"><i class="bi bi-search me-1"></i>Buscar activo</label>
            <input type="text" id="filtroActivo" class="form-control form-control-sm" placeholder="Nombre o código">
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">Tipo de movimiento</label>
            <select id="filtroTipo" class="form-select form-select-sm">
              <option value="">Todos</option>
              <option value="entrega">Entrega</option>
              <option value="traslado">Traslado</option>
              <option value="devolucion">Devolución</option>
              <option value="baja">Baja</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">Servicio origen</label>
            <select id="filtroServicioOrigen" class="form-select form-select-sm">
              <option value="">Todos</option>
              <option value="ti">TI</option>
              <option value="auditorio">Auditorio</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">Servicio destino</label>
            <select id="filtroServicioDestino" class="form-select form-select-sm">
              <option value="">Todos</option>
              <option value="ti">TI</option>
              <option value="auditorio">Auditorio</option>
            </select>
          </div>
          <div class="col-md-3 d-flex gap-2">
            <div class="flex-fill">
              <label class="form-label fw-semibold">Desde</label>
              <input type="date" id="fechaInicio" class="form-control form-control-sm">
            </div>
            <div class="flex-fill">
              <label class="form-label fw-semibold">Hasta</label>
              <input type="date" id="fechaFin" class="form-control form-control-sm">
            </div>
          </div>
          <div class="col-12">
            <button class="btn btn-azul btn-sm btn-filtro" id="btnFiltrar"><i class="bi bi-funnel-fill me-1"></i> Aplicar filtros</button>
          </div>
        </div>
      </div>

      <!-- Tabla historial -->
      <div class="table-responsive shadow-sm">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Código</th>
              <th>Activo</th>
              <th>Tipo</th>
              <th>Origen</th>
              <th>Destino</th>
              <th>Responsable</th>
              <th>Observaciones</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tablaHistorialParcial">
            <tr>
              <td colspan="9" class="text-center">No hay registros</td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<!-- Modal dinámico -->
<div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle Movimiento</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body d-flex justify-content-between align-items-center">
        <div id="modalDetalleInfo">
          <!-- Aquí se cargará el detalle dinámicamente -->
        </div>
        <div>
          <button class="btn btn-success" id="btnVerActa"><i class="bi bi-journal-text me-1"></i> Ver Acta</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function(){

  // Cargar historial inicial
  cargarHistorial();

  // Botón aplicar filtros
  $('#btnFiltrar').click(function(){
    cargarHistorial();
  });

  // Función AJAX para cargar historial filtrado
  function cargarHistorial(){
    let activo = $('#filtroActivo').val();
    let tipo = $('#filtroTipo').val();
    let servicioOrigen = $('#filtroServicioOrigen').val();
    let servicioDestino = $('#filtroServicioDestino').val();
    let fechaInicio = $('#fechaInicio').val();
    let fechaFin = $('#fechaFin').val();

    $.ajax({
      url: "{{ route('activos.filtrarHistorial') }}",
      type: "GET",
      data: {
        activo: activo,
        tipo: tipo,
        servicio_origen: servicioOrigen,
        servicio_destino: servicioDestino,
        fecha_inicio: fechaInicio,
        fecha_fin: fechaFin
      },
      beforeSend: function(){
        $('#tablaHistorialParcial').html('<tr><td colspan="9" class="text-center">Cargando...</td></tr>');
      },
      success: function(data){
        $('#tablaHistorialParcial').html(data);
      },
      error: function(xhr){
        console.error(xhr.responseText);
        $('#tablaHistorialParcial').html('<tr><td colspan="9" class="text-center text-danger">Error al cargar datos</td></tr>');
      }
    });
  }

  // Botón imprimir historial general
  $('#btnImprimirHistorial').click(function(){
    window.print();
  });

  // Modal dinámico
  $(document).on('click', '.btnVerDetalle', function(){
    let item = $(this).data('item');
    let html = `
      <p><strong>Código:</strong> ${item.codigo}</p>
      <p><strong>Tipo de movimiento:</strong> ${item.tipo}</p>
      <p><strong>Origen:</strong> ${item.origen || '-'}</p>
      <p><strong>Destino:</strong> ${item.destino || '-'}</p>
      <p><strong>Responsable:</strong> ${item.responsable || '-'}</p>
      <p><strong>Observaciones:</strong> ${item.observaciones || '-'}</p>
    `;
    $('#modalDetalleInfo').html(html);
    $('#btnVerActa').off('click').on('click', function(){
      window.open(item.url_acta, '_blank');
    });
    $('#modalDetalle').modal('show');
  });

});
</script>
</body>
</html>





























{{-- <!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historial de Activos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
  body { background-color: #f4f6f8; }
  .card-filtro { background-color: #f8f9fa; border-left: 5px solid #0d6efd; padding: 1.5rem; }
  .table thead { background-color: #0d6efd; color: white; }
  .table tbody tr:hover { background-color: #e9f2ff; }
  .btn-azul { background-color: #0d6efd; color: white; }
  .btn-azul:hover { background-color: #0b5ed7; color: white; }
  .btn-rojo { background-color: #dc3545; color: white; }
  .btn-rojo:hover { background-color: #b02a37; color: white; }
  .modal-header { background-color: #343a40; color: white; }
  .modal-body { background-color: #f8f9fa; }
  .form-label { font-size: 0.9rem; }
  .btn-filtro { width: 100%; margin-top: 1rem; }
</style>
</head>
<body>

<div class="container py-4">
  <div class="main-col col-md-12 col-lg-12 mb-4 p-1">
    <div class="card p-4 rounded shadow" style="min-height: 100vh;">

      <!-- Título -->
      <h2 class="mb-4 text-center text-primary"><i class="bi bi-journal-text me-2"></i>Historial de Activos</h2>

      <!-- Botón imprimir historial general -->
      <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-azul btn-sm" id="btnImprimirHistorial" title="Imprimir todo el historial">
          <i class="bi bi-printer-fill me-1"></i> Imprimir Historial
        </button>
      </div>

      <!-- Filtros -->
      <div class="card card-filtro mb-4 shadow-sm">
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold"><i class="bi bi-search me-1"></i>Buscar activo</label>
            <input type="text" id="filtroActivo" class="form-control form-control-sm" placeholder="Nombre o código">
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">Tipo de movimiento</label>
            <select id="filtroTipo" class="form-select form-select-sm">
              <option value="">Todos</option>
              <option value="entrega">Entrega</option>
              <option value="traslado">Traslado</option>
              <option value="devolucion">Devolución</option>
              <option value="baja">Baja</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">Servicio origen</label>
            <select id="filtroServicioOrigen" class="form-select form-select-sm">
              <option value="">Todos</option>
              <option value="ti">TI</option>
              <option value="auditorio">Auditorio</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label fw-semibold">Servicio destino</label>
            <select id="filtroServicioDestino" class="form-select form-select-sm">
              <option value="">Todos</option>
              <option value="ti">TI</option>
              <option value="auditorio">Auditorio</option>
            </select>
          </div>
          <div class="col-md-3 d-flex gap-2">
            <div class="flex-fill">
              <label class="form-label fw-semibold">Desde</label>
              <input type="date" id="fechaInicio" class="form-control form-control-sm">
            </div>
            <div class="flex-fill">
              <label class="form-label fw-semibold">Hasta</label>
              <input type="date" id="fechaFin" class="form-control form-control-sm">
            </div>
          </div>
          <div class="col-12">
            <button class="btn btn-azul btn-sm btn-filtro" id="btnFiltrar"><i class="bi bi-funnel-fill me-1"></i> Aplicar filtros</button>
          </div>
        </div>
      </div>

      <!-- Tabla historial -->
      <div class="table-responsive shadow-sm">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Código</th>
              <th>Activo</th>
              <th>Tipo</th>
              <th>Origen</th>
              <th>Destino</th>
              <th>Responsable</th>
              <th>Observaciones</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <!-- Fila ejemplo -->
            <tr>
              <td>
                2025-11-01
                <span class="badge bg-secondary ms-2">Entrega</span>
              </td>
              <td>A001</td>
              <td>Laptop HP</td>
              <td>Entrega</td>
              <td>Almacén</td>
              <td>TI</td>
              <td>Juan Pérez</td>
              <td>Asignación inicial</td>
              <td>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalDetalle1" title="Ver detalle"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-outline-success" title="Imprimir"><i class="bi bi-printer-fill"></i></button>
                <button class="btn btn-sm btn-rojo" title="Descargar PDF"><i class="bi bi-file-earmark-pdf"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<!-- Modal de detalle limpio -->
<div class="modal fade" id="modalDetalle1" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle Movimiento</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body d-flex justify-content-between align-items-center">
        <div>
          <p><strong>Código:</strong> A001</p>
          <p><strong>Tipo de movimiento:</strong> Entrega</p>
        </div>
        <div>
          <button class="btn btn-success" onclick="alert('Abrir acta completa')"><i class="bi bi-journal-text me-1"></i> Ver Acta</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('btnFiltrar').addEventListener('click', () => {
    alert('Aquí se aplicaría el filtrado con AJAX o Laravel');
  });

  document.getElementById('btnImprimirHistorial').addEventListener('click', () => {
    window.print();
  });
</script>

</body>
</html> --}}


