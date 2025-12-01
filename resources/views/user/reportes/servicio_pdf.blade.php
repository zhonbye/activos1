<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Reporte por Servicios</title>

    <style>
        body { font-family: Arial, sans-serif; font-size:11px; color:#222; }
        h1 { text-align:center; margin-bottom:10px; }
        h2 { font-size:14px; margin-bottom:6px; }
        .servicio-block {
            margin-bottom: 25px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            page-break-inside: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
        }
        th { background: #f2f2f2; }
        .subtitulo {
            font-weight: bold;
            margin-top: 6px;
            margin-bottom: 4px;
            font-size:12px;
        }

        /* HEADER FIJO */
        @page {
            margin: 120px 30px 40px 30px;
        }
        .header-print {
            position: fixed;
            top: -100px;
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

<h1>REPORTE GENERAL POR SERVICIOS</h1>
<p style="text-align:center; font-size:11px;">
    Desde: <strong>{{ $desde }}</strong> — Hasta: <strong>{{ $hasta }}</strong>
</p>

@foreach ($servicios as $s)

<div class="servicio-block">

    <h2>{{ $s->servicio }}</h2>

    <table>
        <tr>
            <th style="width:30%">Responsable</th>
            <td>{{ $s->responsable ?? '—' }}</td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td>{{ $s->descripcion ?? '—' }}</td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>{{ $s->telefono ?? '—' }}</td>
        </tr>
    </table>

    <div class="subtitulo">Estadísticas del Servicio</div>
    <table>
        <thead>
            <tr>
                <th>Total Activos</th>
                <th>Total Categorías</th>
                <th>Total Bajas</th>
                <th>Total Traslados Origen</th>
                <th>Total Traslados Destino</th>
                <th>Total Inventarios</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center">{{ $s->totalActivos }}</td>
                <td style="text-align:center">{{ count($s->categorias) }}</td>
                <td style="text-align:center">{{ count($s->bajas) }}</td>
                <td style="text-align:center">{{ count($s->traslados_origen) }}</td>
                <td style="text-align:center">{{ count($s->traslados_destino) }}</td>
                <td style="text-align:center">{{ count($s->inventarios) }}</td>
            </tr>
        </tbody>
    </table>

    @php
        $total = max($s->totalActivos, 1);
    @endphp

    <div class="subtitulo">Activos por Categoría</div>
    <table>
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Total</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($s->categorias as $c)
            <tr>
                {{-- <td>{{ $c->categoria }} ttt</td> --}}
                <td>{{ $c->categoria }}</td>

                <td style="text-align:center">{{ $c->total }}</td>
                <td style="text-align:center">
                    {{ number_format(($c->total * 100) / $total, 2) }}%
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

@endforeach

</body>
</html>
