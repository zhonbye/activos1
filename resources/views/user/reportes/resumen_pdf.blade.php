<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Resumen General de Activos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size:12px; color:#222; margin: 20px; }
        h1 { text-align:center; margin-bottom:6px; }
        .section { margin-top:12px; }
        table { width:100%; border-collapse:collapse; margin-top:6px; }
        th, td { border:1px solid #ddd; padding:6px; font-size:11px; }
        th { background:#f2f2f2; }
        .kpi { display:inline-block; width:24%; box-sizing:border-box; padding:8px; margin-right:1%; background:#fafafa; border:1px solid #eee; text-align:center; }
        .small { font-size:10px; color:#666; }
        @page {
    margin: 120px 30px 40px 30px; /* espacio para el header */
}

.header-print {
    position: fixed;
    top: -100px; /* igual al margin-top del @page */
    left: 0;
    right: 0;
    height: auto;
}
    </style>
</head>
<body>
<div class="header-print">
    <img src="{{ public_path('plantillaPrint/headerPrint1.png') }}"
         style="width:100%; height:auto;">
</div>


    <h1> Resumen General de Activos</h1>

    {{-- A: Indicadores principales --}}
    <div class="section">
        <h2>Indicadores Principales (KPI)</h2>

        <div class="kpi"><strong>Total activos</strong><div>{{ $totalActivos }}</div></div>
        <div class="kpi"><strong>Con ubicación</strong><div>{{ $activosConUbic }}</div></div>
        <div class="kpi"><strong>Sin ubicación</strong><div>{{ $activosSinUbic }}</div></div>
        <div class="kpi"><strong>Dados de baja</strong><div>{{ $activosBaja }}</div></div>

        <div style="height:8px"></div>

        <div class="kpi"><strong>Adq. Compra</strong><div>{{ $adqCompra }}</div></div>
        <div class="kpi"><strong>Adq. Donación</strong><div>{{ $adqDonacion }}</div></div>
        <div class="kpi"><strong>Adq. Otros</strong><div>{{ $adqOtros }}</div></div>
        <div class="kpi"><strong>Servicios</strong><div>{{ $totalServicios }}</div></div>

        <div style="height:8px"></div>

        <div class="kpi"><strong>Inventarios (año)</strong><div>{{ $inventariosThisYear }}</div></div>
        <div class="kpi"><strong>Activos este mes</strong><div>{{ $activosEsteMes }}</div></div>
        <div class="kpi"><strong>Movimientos</strong><div>{{ $total_movimientos_registrados }}</div></div>
        <div class="kpi"><strong>Bajas (rango)</strong><div>{{ $total_bajas }}</div></div>
    </div>

    {{-- B: Clasificación por estado físico --}}
    <div class="section">
        <h2>Clasificación por estado físico</h2>
        <table>
            <thead><tr><th>Estado</th><th>Cantidad</th><th>%</th></tr></thead>
            <tbody>
                @foreach($estadosFisicos as $e)
                    <tr>
                        <td>{{ $e->nombre }}</td>
                        <td>{{ $e->total }}</td>
                        <td>{{ $e->porcentaje }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- C: Clasificación por adquisición --}}
    <div class="section">
        <h2>Clasificación por adquisición</h2>
        <table>
            <thead><tr>
                <th>Tipo</th><th>Cantidad</th><th>%</th><th>Monto total (solo compra)</th><th>Precio promedio (compra)</th>
            </tr></thead>
            <tbody>
                <tr>
                    <td>COMPRA</td>
                    <td>{{ $adqCompra }}</td>
                    <td>{{ $adq_pct_compra }}%</td>
                    <td>{{ number_format($compra_total_monto,2,'.',',') }}</td>
                    <td>{{ number_format($compra_precio_prom,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td>DONACIÓN</td>
                    <td>{{ $adqDonacion }}</td>
                    <td>{{ $adq_pct_donacion }}%</td>
                    <td>{{ number_format($donacion_total_monto,2,'.',',') }}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>OTRO</td>
                    <td>{{ $adqOtros }}</td>
                    <td>{{ $adq_pct_otros }}%</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>
<br>
<br>
<br>
    {{-- D: Movimientos --}}
    <div class="section">
        <h2>Movimientos</h2>
        <table>
            <thead><tr><th>Tipo movimiento</th><th>Total (rango)</th></tr></thead>
            <tbody>
                <tr><td>Entregas (asignaciones)</td><td>{{ $total_entregas }}</td></tr>
                <tr><td>Devoluciones</td><td>{{ $total_devoluciones }}</td></tr>
                <tr><td>Traslados</td><td>{{ $total_traslados }}</td></tr>
                {{-- <tr><td>Inventarios</td><td>{{ $total_inventarios }}</td></tr> --}}
                <tr><td>Bajas</td><td>{{ $total_bajas }}</td></tr>
            </tbody>
        </table>
    </div>

    {{-- E: Bajas por año --}}
    <div class="section">
        <h2>Bajas (por año)</h2>
        <table>
            <thead><tr><th>Año</th><th>Cantidad</th></tr></thead>
            <tbody>
                @foreach($bajasPorAnio as $b)
                    <tr><td>{{ $b->anio }}</td><td>{{ $b->total }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- F: Servicios --}}
    <div class="section">
        <h2>Top 10 Servicios con más activos</h2>
        <table>
            <thead><tr><th>Servicio</th><th>Total activos</th></tr></thead>
            <tbody>
                @foreach($topServicios as $s)
                    <tr><td>{{ $s->nombre }}</td><td>{{ $s->total }}</td></tr>
                @endforeach
            </tbody>
        </table>

       <div style="height:8px"></div>

<h3>Top 10 Servicios con Más Bajas</h3>

<table>
    <thead>
        <tr>
            <th style="width: 60%">Servicio</th>
            <th style="width: 40%; text-align:center">Cantidad de Bajas</th>
        </tr>
    </thead>

    <tbody>
        @foreach($topServiciosConBajas as $s)
        <tr>
            <td>{{ $s->nombre }}</td>
            <td style="text-align:center">{{ $s->total_bajas }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p class="small">
    Total de servicios analizados: {{ $totalServicios }}
</p>

    </div>

    {{-- G: Antigüedad / adquisiciones por año --}}
    <div class="section">
        <h2>Antigüedad y adquisiciones por año</h2>

        <h4>Top 20 activos más antiguos</h4>
        <table>
            <thead><tr><th>Código</th><th>Nombre</th><th>Fecha registro</th></tr></thead>
            <tbody>
                @foreach($activosMasAntiguos as $a)
                    <tr>
                        <td>{{ $a->codigo }}</td>
                        <td>{{ $a->nombre }}</td>
                        <td>{{ $a->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Adquisiciones por año</h4>
        <table>
            <thead><tr><th>Año</th><th>Tipo</th><th>Cantidad</th></tr></thead>
            <tbody>
                @foreach($adqPorAnio as $r)
                    <tr><td>{{ $r->anio }}</td><td>{{ $r->tipo }}</td><td>{{ $r->total }}</td></tr>
                @endforeach
            </tbody>
        </table>

        <p class="small">Primer año registrado: {{ $primerAnio }}</p>
    </div>

    {{-- H: Inventarios --}}
    <div class="section">
        <h2>Inventarios</h2>
        <table>
            <thead><tr><th>Año / Gestión</th><th>Cantidad</th></tr></thead>
            <tbody>
                @foreach($inventariosPorAnio as $i)
                    <tr><td>{{ $i->gestion }}</td><td>{{ $i->total }}</td></tr>
                @endforeach
            </tbody>
        </table>

        <p class="small">Inventarios este año: {{ $inventariosThisYear }} — Pendientes: {{ $inventariosPendientes }}</p>
    </div>

    {{-- Categorías --}}
    <div class="section">
        <h2>Categorías</h2>
        <table>
            <thead><tr><th>Categoría</th><th>Total activos</th></tr></thead>
            <tbody>
                @foreach($categoriasResumen as $c)
                    <tr><td>{{ $c->nombre }}</td><td>{{ $c->total }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
