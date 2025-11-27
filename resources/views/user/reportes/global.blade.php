<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Panel y Reportes de Activos</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    body { background:#f6f7fb; font-family:Inter,Arial; }
    .tag { padding:4px 8px; border-radius:20px; font-size:12px; }
    .tag.available { background:#ecfdf5; color:#0f5132; }
    .tag.assigned { background:#eff6ff; color:#003a8c; }
  </style>
</head>
<body>
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="mb-0">Panel General de Activos</h2>
      <small class="text-muted">Panel sin React, usando solamente Bootstrap + jQuery</small>
    </div>
  </div>

  <!-- Controles -->
  <div class="card p-3 mb-4">
      <div class="row g-2">

          <!-- BUSCADOR -->
          <div class="col-md-3">
              <input id="search" class="form-control" type="text" placeholder="Buscar activo" />
          </div>

          <!-- SERVICIOS DESDE BD -->
          <div class="col-md-2">
              <select id="filterArea" class="form-select">
                  <option value="">Servicio</option>
                  @foreach ($servicios as $srv)
                      <option value="{{ $srv->nombre }}">{{ $srv->nombre }}</option>
                  @endforeach
              </select>
          </div>

          <!-- ESTADOS DESDE BD -->
          <div class="col-md-2">
              <select id="filterState" class="form-select">
                  <option value="">Estado</option>
                  @foreach ($estados as $est)
                      <option value="{{ $est->nombre }}">{{ $est->nombre }}</option>
                  @endforeach
              </select>
          </div>

          <!-- MOVIMIENTO (tu select original) -->
          <div class="col-md-2">
              <select id="filterType" class="form-select">
                  <option value="">Movimiento</option>
                  <option>Entrada</option>
                  <option>Traslado</option>
                  <option>Devolución</option>
              </select>
          </div>

          <div class="col-md-3">
              <button id="applyFilters" class="btn btn-primary w-100">Aplicar filtros</button>
          </div>

      </div>
  </div>

  <!-- Instrucciones -->
  <div class="card p-3 mb-4">
    <h5>¿Cómo usar este módulo?</h5>
    <ul class="small text-muted">
      <li>Buscar rápido, filtrar por servicio, estado y movimiento.</li>
      <li>Generar reportes en PDF, Excel o CSV.</li>
    </ul>
  </div>

  <!-- ============================= -->
  <!-- GRÁFICOS -->
  <!-- ============================= -->
  <div class="card p-3 mb-4">
      <h5 class="mb-3">Gráficos de análisis</h5>
      <p class="text-muted small">Se actualizan con los datos visibles.</p>

      <div class="row g-3">
          <div class="col-md-6">
              <div class="card p-3">
                  <h6 class="text-center">Activos por estado</h6>
                  <canvas id="chartEstados" height="200"></canvas>
              </div>
          </div>

          <div class="col-md-6">
              <div class="card p-3">
                  <h6 class="text-center">Activos por servicio</h6>
                  <canvas id="chartAreas" height="200"></canvas>
              </div>
          </div>
      </div>
  </div>

  <!-- KPIs -->
 <div class="row mb-4">
    <div class="col-md-3">
        <div class="card p-3">
            <div>Total activos</div>
            <h4 id="totalAssets">{{ $total_activos }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <div>Asignados</div>
            <h4 id="assigned">{{ $activos_asignados }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <div>Disponibles</div>
            <h4 id="available">{{ $activos_disponibles }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <div>Bajas</div> <!-- antes decía 'Pendientes' -->
            <h4 id="pending">{{ $activos_baja }}</h4>
        </div>
    </div>
</div>


  <!-- Reportes -->
  <div class="card p-3 mb-4">
      <h6>Generar reporte</h6>

      <div class="row g-2 mt-1">
          <div class="col-md-3">
             <select id="reportType" class="form-select">
    <option value="kpi_overview">Resumen rápido</option>
    <option value="inventory_detail">Inventario detallado</option>
    <option value="movements_summary">Movimientos</option>

    <!-- Activos por agrupaciones -->
    <option value="assets_by_service">Activos por servicio</option>
    <option value="assets_by_category">Activos por categoría</option>
    <option value="assets_by_name">Activos por nombre</option>
    <option value="assets_by_acquisition">Activos por adquisición (compra / donación / otros)</option>

    <!-- Nuevas opciones que pediste -->
    <option value="list_services">Lista completa de servicios</option>
    <option value="assigned_assets">Activos asignados</option>
    <option value="unassigned_assets">Activos no asignados</option>
    <option value="assets_low">Activos dados de baja</option>
    <option value="assets_by_condition">Activos por estado físico (nuevo / bueno / malo / etc.)</option>
</select>

          </div>

          <div class="col-md-2"><input type="date" id="fromDate" class="form-control"></div>
          <div class="col-md-2"><input type="date" id="toDate" class="form-control"></div>

          <div class="col-md-2">
              <select id="outputFormat" class="form-select">
                  <option value="pdf">PDF</option>
                  <option>xlsx</option>
                  <option>csv</option>
              </select>
          </div>

          <div class="col-md-3"><button class="btn btn-success w-100" id="generateReport">Generar</button></div>
      </div>
  </div>

  <!-- Movimientos -->
  <div class="card p-3 mb-4">
      <h5>Movimientos del último mes</h5>
      <div class="table-responsive">
          <table class="table table-sm table-bordered align-middle">
              <thead class="table-light">
                  <tr><th>Código</th><th>Nombre</th><th>Responsable</th><th>Fecha</th><th>Estado</th><th>Movimiento</th></tr>
              </thead>
             <tbody id="movementsTable">
    {{-- @foreach($movimiento as $m)
        <tr>
            <td>{{ $m->codigo }}</td>
            <td>{{ $m->nombre }}</td>
            <td>{{ $m->responsable }}</td>
            <td>{{ $m->fecha }}</td>
            <td>{{ $m->tipo }}</td>
            <td>{{ $m->observaciones }}</td>
        </tr>
    @endforeach --}}
</tbody>

          </table>
      </div>
  </div>

  <!-- Inventario -->
  <div class="card p-3 mb-4">
      <h5>Inventario de activos</h5>
      <div class="table-responsive">
          <table class="table table-sm table-bordered align-middle">
              <thead class="table-light">
                  <tr><th>Código</th><th>Nombre</th><th>Servicio</th><th>Medida</th><th>Estado</th><th>Asignado a</th></tr>
              </thead>
             <tbody id="inventoryTable">
    {{-- @foreach($inventario as $inv)
        <tr>
            <td>{{ $inv->codigo }}</td>
            <td>{{ $inv->nombre }}</td>
            <td>{{ $inv->servicio }}</td>
            <td>{{ $inv->unidad }}</td>
            <td><span class="tag">{{ $inv->estado }}</span></td>
            {{-- <td></td>
            <td>{{ $inv->asignado_a }}</td>
        </tr>
    @endforeach --}}
</tbody>

          </table>
      </div>
  </div>


<!-- RESULTADOS -->
<div id="reportResults" class="mt-4" style="display:none;">
    <h5 id="reportTitle"></h5>

    <table class="table table-bordered table-striped" id="resultsTable">
        <thead id="tableHead"></thead>
        <tbody id="tableBody"></tbody>
    </table>

    <button class="btn btn-primary mt-2" onclick="printTable()">Imprimir resultados</button>
</div>


  {{-- <!-- Vista impresión -->
  <div id="printSheet" class="card p-4" style="display:none;background:white;">
      <div class="d-flex justify-content-between mb-3">
          <div>
              <h4 class="mb-0">Reporte de Activos Fijos</h4>
              <small class="text-muted">Generado automáticamente</small>
          </div>
          <div class="text-end small text-muted">
              Fecha: <span id="printDate"></span>
          </div>
      </div>

      <div id="printedContent">Seleccione un reporte.</div>

      <button class="btn btn-primary mt-3" onclick="window.print()">Imprimir ahora</button>
  </div> --}}

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>


$("#generateReport").on("click", function () {

    let reportType = $("#reportType").val();
    let fromDate   = $("#fromDate").val();
    let toDate     = $("#toDate").val();
    let format     = $("#outputFormat").val();

    $.ajax({
        url: baseUrl+"/reportes/generar",
        method: "POST",
        data: {
            reportType,
            fromDate,
            toDate,
            format,
            _token: $('meta[name="csrf-token"]').attr("content")
        },

        success: function(res){
            console.log("REPORTE:", res);

            $("#reportTitle").text(res.title);
            $("#reportResults").show();

            let data = res.data;

            /* =========================================================
               1) SI ES RESUMEN RÁPIDO (FORMATO DE OBJETO)
            ========================================================== */
            if(typeof data === "object" && !Array.isArray(data)){

                $("#tableHead").html(`
                    <tr>
                        <th>Descripción</th>
                        <th>Valor</th>
                    </tr>
                `);

                let html = "";

                for (let key in data){

                    // Si la fila es array (por_estado, por_servicio, etc.)
                    if (Array.isArray(data[key])) {
                        html += `
                            <tr class="table-primary">
                                <td colspan="2"><b>${key.replaceAll("_"," ").toUpperCase()}</b></td>
                            </tr>
                        `;

                        data[key].forEach(row=>{
                            let cols = Object.values(row).join("</td><td>");
                            html += `<tr><td>${cols}</td></tr>`;
                        });
                    } else {
                        // Valor simple
                        html += `
                            <tr>
                                <td>${key.replaceAll("_"," ").toUpperCase()}</td>
                                <td>${data[key]}</td>
                            </tr>
                        `;
                    }
                }

                $("#tableBody").html(html);
                return;
            }


            /* =========================================================
               2) SI ES UN LISTADO NORMAL (ARRAY)
            ========================================================== */
            if(Array.isArray(data)){

                if(data.length === 0){
                    $("#tableHead").html("");
                    $("#tableBody").html(`<tr><td colspan="10">Sin resultados</td></tr>`);
                    return;
                }

                // Crear columnas automáticamente
                let cols = Object.keys(data[0]);

                let headHTML = "<tr>";
                cols.forEach(c=>{
                    headHTML += `<th>${c.replaceAll("_"," ").toUpperCase()}</th>`;
                });
                headHTML += "</tr>";
                $("#tableHead").html(headHTML);

                // Llenar filas
                let bodyHTML = "";
                data.forEach(row=>{
                    bodyHTML += "<tr>";
                    cols.forEach(col=>{
                        bodyHTML += `<td>${row[col]}</td>`;
                    });
                    bodyHTML += "</tr>";
                });

                $("#tableBody").html(bodyHTML);
            }

        },

        error: function(xhr){
            console.log(xhr.responseText);
            alert("Error generando reporte");
        }
    });

});










$("#applyFilters").on("click", function () {

    let data = {
        search: $("#search").val(),
        servicio: $("#filterArea").val(),
        estado: $("#filterState").val(),
        tipo: $("#filterType").val(),
        _token: "{{ csrf_token() }}"
    };

    $.ajax({
        url: baseUrl+"/reportes/filtrar",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function(res) {
 window.filteredInventario  = res.inventario;
    window.filteredMovimientos = res.movimientos;
            /* ======== ACTUALIZAR MOVIMIENTOS ======== */
            let movT = $("#movementsTable");
            movT.html("");

            res.movimientos.forEach(m => {
                movT.append(`
                    <tr>
                        <td>${m.codigo}</td>
                        <td>${m.nombre}</td>
                        <td>${m.responsable ?? '-'}</td>
                        <td>${m.fecha}</td>
                        <td>${m.estado}</td>
                        <td>${m.tipo}</td>
                    </tr>
                `);
            });

            /* ======== ACTUALIZAR INVENTARIO ======== */
            let invT = $("#inventoryTable");
            invT.html("");

            res.inventario.forEach(i => {
                invT.append(`
                    <tr>
                        <td>${i.codigo}</td>
                        <td>${i.nombre}</td>
                        <td>${i.servicio ?? '-'}</td>
                        <td>${i.unidad ?? '-'}</td>
                        <td>${i.estado}</td>
                        <td>${i.asignado_a}</td>
                        
                    </tr>
                `);
            });

        }
    });

});


function printTable() {
    let content = document.getElementById("reportResults").innerHTML;
    let win = window.open("", "", "width=900,height=700");
    win.document.write(`
        <html>
        <head>
            <title>Imprimir reporte</title>
            <style>
                table { width:100%; border-collapse: collapse; }
                th, td { border:1px solid #000; padding:6px; font-size:14px; }
                h5 { text-align:center; margin-bottom:10px; }
            </style>
        </head>
        <body>${content}</body>
        </html>
    `);
    win.document.close();
    win.print();
}

// $("#generateReport").on("click", function(){

//     let data = {
//         reportType: $("#reportType").val(),
//         fromDate: $("#fromDate").val(),
//         toDate: $("#toDate").val(),
//         outputFormat: $("#outputFormat").val(),
//         _token: "{{ csrf_token() }}"
//     };

//     $.post(baseUrl+"/reportes/generar", data, function(res){

//         // Título
//         $("#reportTitle").text(res.title);

//         // Limpiar tabla
//         $("#tableHead").empty();
//         $("#tableBody").empty();

//         // Si es un resumen de números, convertir a filas
//         if(!Array.isArray(res.data)) {
//             let head = "<tr><th>Descripción</th><th>Valor</th></tr>";
//             $("#tableHead").html(head);

//             $.each(res.data, function(k,v){
//                 $("#tableBody").append(
//                     `<tr><td>${k}</td><td>${v}</td></tr>`
//                 );
//             });
//         }
//         else {
//             // Crear encabezados dinámicos
//             let keys = Object.keys(res.data[0]);

//             let head = "<tr>";
//             keys.forEach(k => head += `<th>${k}</th>`);
//             head += "</tr>";
//             $("#tableHead").html(head);

//             // Crear filas
//             res.data.forEach(row => {
//                 let tr = "<tr>";
//                 keys.forEach(k => tr += `<td>${row[k]}</td>`);
//                 tr += "</tr>";
//                 $("#tableBody").append(tr);
//             });
//         }

//         // Mostrar sección
//         $("#reportResults").show();

//     });

// });





$("#applyFilters").on("click", function(){
  const search = $("#search").val().toLowerCase();
  const area   = $("#filterArea").val();
  const state  = $("#filterState").val();
  const move   = $("#filterType").val();

  // Movimientos
  $("#movementsTable tr").each(function(){
    const row = $(this);
    const txt = row.text().toLowerCase();
    const mov = row.find("td:eq(5)").text();

    let show = true;
    if(search && !txt.includes(search)) show = false;
    if(move && mov !== move) show = false;

    row.toggle(show);
  });

  // Inventario
  $("#inventoryTable tr").each(function(){
    const row = $(this);
    const txt = row.text().toLowerCase();
    const a = row.find("td:eq(2)").text();
    const e = row.find("td:eq(4)").text();

    let show = true;
    if(search && !txt.includes(search)) show = false;
    if(area && a !== area) show = false;
    if(state && !e.includes(state)) show = false;

    row.toggle(show);
  });
});

/* =====================
   GRAFICOS DEMO
===================== */
let chart1, chart2;

function renderCharts(){
    const ctx1 = document.getElementById("chartEstados");
    if(chart1) chart1.destroy();
    chart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Asignados','Disponibles','Pendientes'],
            datasets: [{ data: [85,35,6] }]
        }
    });

    const ctx2 = document.getElementById("chartAreas");
    if(chart2) chart2.destroy();
    chart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Central','Ventas','Soporte'],
            datasets: [{ data: [42,33,45] }]
        }
    });
}

renderCharts();
</script>

</body>
</html>
