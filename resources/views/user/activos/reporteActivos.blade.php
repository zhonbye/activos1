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

        th,
        td {
            border: 1px solid #000;
            padding: 4px 5px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        thead {
            display: table-header-group;
            /* repite encabezado en cada página */
        }

        tfoot {
            display: table-footer-group;
            /* repite footer si lo deseas */
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
        <img src="{{ public_path('plantillaPrint/headerPrint1.png') }}" alt="Hospital Walter Khon">
    </div>

    <div class="contenido">
        <div style="text-align:center; margin-bottom:15px;">
            <div style="font-family:'alger2'; font-size:26px; text-decoration: underline;">
                REPORTE DE ACTIVOS
            </div>
            {{-- <div style="font-size:12px; font-weight:bold; margin-top:5px;">
        Hospital de II Nivel Walter Khon
    </div> --}}
            <div style="font-size:10px; margin-top:3px;">
                Documento interno - Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
            </div>
        </div>


        <!-- Tabla de resultados -->
        <!-- Tabla de resultados -->
        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Detalle</th>
                    <th>Categoría</th>
                    <th>Unidad</th>
                    <th>Estado</th>
                    <th>Situación</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($activos as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $a->codigo }}</td>
                        <td>{{ $a->nombre }}</td>
                        <td>{{ $a->detalle }}</td>
                        <td>{{ $a->categoria->nombre }}</td>
                        <td>{{ $a->unidad->nombre }}</td>
                        <td>{{ $a->estado->nombre }}</td>

                        <!-- Situación traducida -->
                        @php
                            switch ($a->estado_situacional) {
                                case 'inactivo':
                                    $situacion = 'Sin asignación';
                                    break;
                                case 'activo':
                                    $situacion = 'En uso';
                                    break;
                                case 'baja':
                                    $situacion = 'De baja';
                                    break;
                                default:
                                    $situacion = ucfirst($a->estado_situacional);
                            }
                        @endphp

                        <td>{{ $situacion }}</td>

                        <td>{{ $a->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>










@php
    // === GRUPOS POR ESTADO SITUACIONAL ===
    $situaciones = [
        'activo'   => 'En uso',
        'inactivo' => 'Sin asignación',
        'baja'     => 'De baja'
    ];

    $totalesSituacion = [];
    foreach ($situaciones as $clave => $label) {
        $totalesSituacion[$label] = $activos->where('estado_situacional', $clave)->count();
    }

    // === GRUPOS POR ESTADO (DINÁMICO) ===
    // Agrupar por nombre de la relación estado->nombre
    $estadosAgrupados = $activos->groupBy(function($a){
        return $a->estado->nombre;
    });

    // Crear array con conteos dinámicos
    $totalesEstados = [];
    foreach ($estadosAgrupados as $estado => $items) {
        $totalesEstados[$estado] = $items->count();
    }
@endphp


<div class="totales" style="display: flex; gap: 60px; margin-left: 20px; margin-top: 10px;">

    <!-- Totales por situación -->
    <div>
        <p><strong>Totales por Situación:</strong></p>

        @foreach ($totalesSituacion as $label => $cantidad)
            <p>{{ $label }}: {{ $cantidad }}</p>
        @endforeach
    </div>

    <!-- Totales por estado dinámicos -->
    <div>
        <p><strong>Totales por Estado:</strong></p>

        @foreach ($totalesEstados as $estado => $cantidad)
            <p>{{ ucfirst($estado) }}: {{ $cantidad }}</p>
        @endforeach
    </div>

</div>





    

    </div>

</body>

</html>
