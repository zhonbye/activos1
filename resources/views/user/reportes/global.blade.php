<style>
    /* TITULOS */
    .title-main { font-size: 1.9rem; font-weight: 800; }
    .subtext { color:#6c757d; }

    /* CARD */
    .box {
        background:#fff;
        border-radius:14px;
        padding:20px;
        box-shadow:0 2px 8px rgba(0,0,0,.07);
    }

    /* KPIs */
    .kpi-card {
        padding:20px;
        background:#fff;
        border-radius:14px;
        box-shadow:0 2px 8px rgba(0,0,0,.06);
    }
    .kpi-number { font-size:2.2rem; font-weight:700; }

    .section-title { font-weight:700; margin-bottom:10px; }
</style>

<!-- ======================================================= -->
<!--  🔥 TITULO                                              -->
<!-- ======================================================= -->
<div class="mb-4">
    <div class="title-main">📊 Panel Global de Activos</div>
    <div class="subtext">Visualización general, estadísticas y reportes oficiales.</div>
</div>


<!-- ======================================================= -->
<!--  🔥 KPIs                                                -->
<!-- ======================================================= -->
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="kpi-card"><div class="subtext">Total</div><div class="kpi-number" id="kpi_total">0</div></div></div>
    <div class="col-md-3"><div class="kpi-card"><div class="subtext">Disponibles</div><div class="kpi-number text-primary" id="kpi_disp">0</div></div></div>
    <div class="col-md-3"><div class="kpi-card"><div class="subtext">Asignados</div><div class="kpi-number text-info" id="kpi_asig">0</div></div></div>
    <div class="col-md-3"><div class="kpi-card"><div class="subtext">De baja</div><div class="kpi-number text-danger" id="kpi_baja">0</div></div></div>
</div>



<!-- ======================================================= -->
<!--  🎛️ FILTROS (Solo afectan vista/tabla/gráficos)         -->
<!-- ======================================================= -->
<div class="box mb-4">
    <div class="section-title">🎛️ Filtros visibles</div>
    <div class="row g-3">

        <!-- SERVICIO -->
        <div class="col-md-4">
<select id="flt_serv" class="form-select">
    <option value="">Servicio (todos)</option>

    @foreach ($servicios as $s)
        <option value="{{ $s->id_servicio }}">
            {{ $s->nombre }}
        </option>
    @endforeach
</select>

        </div>

        <!-- CATEGORIA -->
        <div class="col-md-4">
           <select id="flt_cat" class="form-select">
    <option value="">Categoría (todas)</option>

    @foreach ($categorias as $cat)
        <option value="{{ $cat->id_categoria }}">
            {{ $cat->nombre }}
        </option>
    @endforeach
</select>

        </div>

        <!-- ESTADO -->
        <div class="col-md-4">
            <select id="flt_estado" class="form-select">
    <option value="">Estado (todos)</option>

    @foreach ($estados as $est)
        <option value="{{ $est->id_estado }}">
            {{ $est->nombre }}
        </option>
    @endforeach
</select>

        </div>

    </div>

    <button id="btn_filtrar" class="btn btn-dark mt-3 w-100">
        Aplicar filtros en pantalla
    </button>
</div>



<!-- ======================================================= -->
<!--  📈 NUEVOS GRAFICOS                                     -->
<!-- ======================================================= -->
<div class="row g-4 mb-4">

    <div class="col-md-6"><div class="box"><div class="section-title text-center">Activos por servicio</div><canvas id="g1"></canvas></div></div>
    <div class="col-md-6"><div class="box"><div class="section-title text-center">Activos por categoría</div><canvas id="g2"></canvas></div></div>

    <div class="col-md-6"><div class="box"><div class="section-title text-center">Estado físico</div><canvas id="g3"></canvas></div></div>
    <div class="col-md-6"><div class="box"><div class="section-title text-center">Disponibles vs asignados</div><canvas id="g4"></canvas></div></div>

    <div class="col-md-12 mt-4"><div class="box"><div class="section-title text-center">Tendencia histórica mensual</div><canvas id="g5"></canvas></div></div>

</div>



<!-- ======================================================= -->
<!--  📃 REPORTES                                            -->
<!-- ======================================================= -->
<div class="box mb-4" style="border-left:6px solid #0d6efd;">
    <div class="section-title">📃 Generador de reportes</div>

    <small class="text-muted">Cada reporte puede ser general o basado en los filtros actuales.</small>

    <div class="row g-3 mt-2">

        <!-- Tipo reporte -->
        <div class="col-md-4">
            <label class="small">Tipo de reporte</label>
            <select id="rep_tipo" class="form-select">
                <option value="resumen">Resumen general </option>
                <option value="servicio">Reporte por servicio</option>
                <option value="categoria">Detalle inventarios</option>
                {{-- <option value="estado">Historico por estado</option> --}}
                {{-- <option value="inventario">Inventario completo</option> --}}
                <option value="asignados">Activos asignados</option>
                <option value="disponibles">Activos disponibles</option>
                <option value="baja">Activos de baja</option>
                <option value="compra">Adquisición compra</option>
                <option value="donacion">Adquisición donación</option>
                <option value="otros">Adquisición otros</option>
            </select>
        </div>

        <!-- Fechas opcionales -->
       <div class="col-md-3">
    <label class="small">Desde</label>
    <input type="date" id="rep_desde" class="form-control"
           value="{{ date('Y-m-d', strtotime('-1 year')) }}">
</div>

<div class="col-md-3">
    <label class="small">Hasta</label>
    <input type="date" id="rep_hasta" class="form-control"
    value="{{ date('Y-m-d') }}">
</div>

<!-- Formato -->
<div class="col-md-2">
            <label class="small">Formato</label>
            <select id="rep_fmt" class="form-select">
                <option value="pdf">PDF</option>
                <option value="xlsx">Excel</option>
                <option value="csv">CSV</option>
            </select>
        </div>

        <!-- Tipo de fuente -->
        {{-- <div class="col-md-12 mt-2">
            <div class="form-check">
                <input type="radio" class="form-check-input" name="r_fuente" value="all" checked>
                <label class="form-check-label small">Usar toda la base</label>
            </div>

            <div class="form-check">
                <input type="radio" class="form-check-input" name="r_fuente" value="filtros">
                <label class="form-check-label small">Usar filtros actuales (excepto “Resumen general”)</label>
            </div>
        </div> --}}

        <div class="col-md-12">
            <button id="btn_reporte" class="btn btn-success w-100 mt-2">
                Generar reporte
            </button>
        </div>

    </div>
</div>



<!-- ======================================================= -->
<!--  📑 RESULTADOS                                          -->
<!-- ======================================================= -->
<div class="box mb-4" id="result_box" style="display:none;">
    <div class="section-title" id="result_titulo"></div>

    <div class="table-responsive">
        <table class="table table-bordered" id="result_table">
            <thead></thead>
            <tbody></tbody>
        </table>
    </div>

    <button onclick="window.print()" class="btn btn-primary mt-2">Imprimir</button>
</div>

<div class="box mt-4" id="box_resultados">
    <div class="section-title">📋 Resultados</div>

    <div class="table-responsive">
    <table class="table table-striped table-bordered" id="tabla_activos">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Detalle</th>
            <th>Categoría</th>
            <th>Estado</th>
            <th>Unidad</th>
            {{-- <th>Situación</th> --}}
            <th>Ubicación actual</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>


    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let activosFiltrados = []; // variable global


$("#btn_reporte").on("click", function () {
    let tipo = $("#rep_tipo").val();
    let desde = $("#rep_desde").val();
    let hasta = $("#rep_hasta").val();
    let formato = $("#rep_fmt").val();

    $.ajax({
        url: "{{ route('reporte.generar') }}",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            // ❌ QUITADO: activos: JSON.stringify(activosFiltrados),
            tipo: tipo,
            desde: desde,
            hasta: hasta,
            formato: formato
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            let blob = new Blob([data], { type: "application/pdf" });
            let url = URL.createObjectURL(blob);
            window.open(url, "_blank");
        },
        error: function(e){
            console.log("Error:", e);
        }
    });
});



















function renderTabla(activos) {
    let tbody = $("#tabla_activos tbody");
    tbody.empty();

    if (activos.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="9" class="text-center text-danger">No se encontraron activos</td>
            </tr>
        `);
        return;
    }

    activos.forEach((a, index) => {
        tbody.append(`
            <tr>
                <td>${index + 1}</td>
                <td>${a.codigo ?? ''}</td>
                <td>${a.nombre ?? ''}</td>
                <td>${a.detalle ?? ''}</td>
                <td>${a.categoria?.nombre ?? ''}</td>
                <td>${a.estado?.nombre ?? ''}</td>
                <td>${a.unidad?.abreviatura ?? ''}</td>

                <td>
                    ${(() => {
                        let est = a.estado_situacional ?? '';

                        if (est === 'activo')
                            return `<span class="badge bg-primary-subtle text-primary">${a.ubicacion_actual ?? 'SIN UBICACIÓN'}</span>`;

                        if (est === 'inactivo')
                            return `<span class="badge bg-warning-subtle text-warning">SIN ASIGNACIÓN</span>`;

                        if (est === 'baja')
                            return `<span class="badge bg-danger-subtle text-danger">DADO DE BAJA</span>`;

                        return '';
                    })()}
                </td>
            </tr>
        `);
    });
}



function scrollHaciaTabla() {
    const tabla = document.getElementById("box_resultados");

    if (!tabla) return;

    tabla.scrollIntoView({
        behavior: "smooth",  // animación suave
        block: "start"      // la tabla queda centrada
    });
}

$("#btn_filtrar").on("click", function () {

    let serv = $("#flt_serv").val();
    let cat  = $("#flt_cat").val();
    let est  = $("#flt_estado").val();
    $.ajax({
        url: "{{ route('reporte.filtrar') }}",
        method: "POST",
        data: {
            servicio: serv,
            categoria: cat,
            estado: est,
            _token: $("meta[name='csrf-token']").attr("content")
        },

        beforeSend: function () {
            Swal.fire({
                title: "Filtrando...",
                text: "Espere un momento",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },

        success: function (res) {

    // Esperar a que realmente cierre el Swal
    Swal.close();

    setTimeout(() => {
        if (!res.success) {
            Swal.fire("Error", "No se pudieron obtener los datos", "error");
            return;
        }

        let activos = res.activos;

        renderTabla(activos);
        activosFiltrados = activos;

        // FORZAR EL SCROLL DESPUÉS DE QUE SWEETALERT RESTAURE EL BODY
        setTimeout(() => {
            scrollHaciaTabla();
        }, 150); // ← este delay es clave
    }, 150);
},


        error: function (xhr) {
            Swal.close();

            Swal.fire({
                icon: "error",
                title: "Error en la consulta",
                text: "Ocurrió un error al filtrar los datos"
            });
        }
    });
});














    /* Graficos DEMO */
    new Chart(g1, { type:'bar', data:{ labels:["Sis","Admin","Conta"], datasets:[{data:[20,15,10],backgroundColor:"#0d6efd"}] }});
    new Chart(g2, { type:'bar', data:{ labels:["Comp","Mob","Off"], datasets:[{data:[12,18,9],backgroundColor:"#6f42c1"}] }});
    new Chart(g3, { type:'pie', data:{ labels:["Nuevo","Bueno","Reg","Malo"], datasets:[{data:[10,20,15,5]}] }});
    new Chart(g4, { type:'doughnut', data:{ labels:["Disponibles","Asignados"], datasets:[{data:[25,30]}] }});
    new Chart(g5, { type:'line', data:{ labels:["Ene","Feb","Mar","Abr","May"], datasets:[{data:[10,20,18,25,30],borderColor:"#0d6efd"}] }});

    /* Botón reporte (DEMO) */
    // document.getElementById("btn_reporte").onclick = () => {
    //     document.getElementById("result_box").style.display="block";
    //     document.getElementById("result_titulo").innerText =
    //         "Reporte: " + document.querySelector("#rep_tipo option:checked").text;

    //     document.querySelector("#result_table thead").innerHTML = `
    //         <tr><th>Código</th><th>Nombre</th><th>Servicio</th><th>Estado</th></tr>
    //     `;

    //     document.querySelector("#result_table tbody").innerHTML = `
    //         <tr><td>AC-01</td><td>PC</td><td>Sistemas</td><td>Bueno</td></tr>
    //         <tr><td>AC-02</td><td>Silla</td><td>Admin</td><td>Regular</td></tr>
    //     `;
    // };
</script>
