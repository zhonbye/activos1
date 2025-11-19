<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Actas</title>
    <style>
@font-face {
    font-family: 'alger2';
    src: url("/fonts/alger/alger.ttf") format("truetype");
    font-weight: normal;
    font-style: normal;
}

        
        body {
            /* background-color: red; */
            font-family: Arial, sans-serif;
            font-size: 11px;
         margin-top: 100px;
            /* z-index: 9999; */
        }
        
        /* Encabezado con imagen que se repite */
        .header-fijo {
            /* z-index: 1; */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            text-align: center;
            /* background-color: blue; */
            /* height:     100px; */
        }

        .header-fijo img {
            width: 100%;
            height: auto;
            margin-bottom: 0px;
        }
        
        .contenido {
            /* margin-top: 120px;  */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 10px;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 4px 5px;
            text-align: center;
        }
        
        th {
            background-color: #f0f0f0;
        }
        
        thead {
            display: table-header-group; /* repite encabezado en cada página */
        }
        
        tfoot {
            display: table-footer-group; /* repite footer si lo deseas */
        }
        
        .totales {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Encabezado fijo con imagen -->
<div class="header-fijo">
    <img  src="{{ public_path('plantillaPrint/headerPrint1.png') }}" alt="Hospital Walter Khon">
</div>

<div class="contenido">
   <div style="text-align:center; margin-bottom:15px;">
    <div style="font-family:'alger2'; font-size:26px; text-decoration: underline;">
        REPORTE DE ACTAS
    </div>
    {{-- <div style="font-size:12px; font-weight:bold; margin-top:5px;">
        Hospital de II Nivel Walter Khon
    </div> --}}
    <div style="font-size:10px; margin-top:3px;">
        Documento interno - Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>
</div>


    <!-- Tabla de resultados -->
    <table>
        <thead>
            <tr>
                <th>N°</th>

                <th>N° Documento</th>
                <th>Gestión</th>
                <th>Fecha</th>
                <th>Tipo Acta</th>
                <th>Responsable</th>
                <th>Servicio</th>
                <th>Estado</th>
                <th>Registrado por</th>
            </tr>
        </thead>
     <tbody>
    @foreach($resultados as $r)
        <tr>
            <!-- Columna de numeración -->
            <td>{{ $loop->iteration }}</td>

            <td>{{ $r->numero_documento }}</td>
            <td>{{ $r->gestion }}</td>
            <td>{{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
            <td>{{ ucfirst($r->tipo_acta) }}</td>
            <td>
                @if($r->tipo_acta === 'traslado')
                    {{ $r->responsable_origen }} / {{ $r->responsable_destino }}
                @else
                    {{ $r->responsable }}
                @endif
            </td>
            <td>
                @if($r->tipo_acta === 'traslado')
                    {{ $r->servicio_origen }} / {{ $r->servicio_destino }}
                @else
                    {{ $r->servicio }}
                @endif
            </td>
            <td>{{ ucfirst($r->estado) }}</td>
            <td>{{ $r->usuario }}</td>
        </tr>
    @endforeach
</tbody>

    </table>
{{-- @for($i = 1; $i <= 90; $i++)
    <p>{{ $i }} - Elemento {{ $i }}</p>
@endfor --}}


    <!-- Totales resumidos -->
    {{-- <div class="totales" style="margin-left:20px;"> --}}
    @php
        $total_entregas = $resultados->where('tipo_acta','entrega')->count();
        $total_traslados = $resultados->where('tipo_acta','traslado')->count();
        $total_devoluciones = $resultados->where('tipo_acta','devolucion')->count();

        $total_finalizado = $resultados->where('estado','finalizado')->count();
        $total_pendiente  = $resultados->where('estado','pendiente')->count();
    @endphp

   <div class="totales" style="display: flex; gap: 40px; margin-left: 20px; margin-top: 10px;">
    <div>
        <p><strong>Totales por Tipo de Acta:</strong></p>
        <p>Entregas: {{ $total_entregas }}</p>
        <p>Traslados: {{ $total_traslados }}</p>
        <p>Devoluciones: {{ $total_devoluciones }}</p>
    </div>

    <div>
        <p><strong>Totales por Estado:</strong></p>
        <p>Finalizados: {{ $total_finalizado }}</p>
        <p>Pendientes: {{ $total_pendiente }}</p>
    </div>
</div>

</div>

</div>

</body>
</html>
