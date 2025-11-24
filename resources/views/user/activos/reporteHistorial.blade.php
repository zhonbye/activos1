<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Movimientos</title>

    <style>
        @font-face {
            font-family: 'alger2';
            src: url("/fonts/alger/alger.ttf") format("truetype");
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin-top: 110px;
        }

        .header-fijo {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            text-align: center;
        }

        .header-fijo img {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        /* OCULTAR COLUMNA 7 (Cambiar número si quieres otra) */
        table tr td:nth-child(10),
        table tr th:nth-child(10) {
            display: none;
        }

        .totales {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>

</head>
<body>

    <!-- HEADER FIJO -->
    <div class="header-fijo">
        <img src="{{ public_path('plantillaPrint/headerPrint1.png') }}" alt="">
    </div>

    <div style="text-align:center; margin-bottom:15px;">
        <div style="font-family:'alger2'; font-size:26px; text-decoration: underline;">
            REPORTE DE HISTORIAL DE MOVIMIENTOS
        </div>

        <div style="font-size:10px; margin-top:4px;">
            Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        </div>
    </div>

    <!-- AQUÍ SE INSERTA LA TABLA QUE VIENE DEL AJAX -->
    {!! $tabla !!}

</body>
</html>
