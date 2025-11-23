<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Donantes</title>
    <style>
@font-face {
    font-family: 'alger2';
    src: url("/fonts/alger/alger.ttf") format("truetype");
    font-weight: normal;
    font-style: normal;
}

body {
    font-family: Arial, sans-serif;
    font-size: 11px;
    margin-top: 100px;
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
    height: auto;
    margin-bottom: 0px;
}

.contenido {}

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
    display: table-header-group;
}

tfoot {
    display: table-footer-group;
}

.totales {
    margin-top: 10px;
    font-weight: bold;
}
    </style>
</head>
<body>

<div class="header-fijo">
    <img src="{{ public_path('plantillaPrint/headerPrint1.png') }}" alt="Hospital Walter Khon">
</div>

<div class="contenido">
   <div style="text-align:center; margin-bottom:15px;">
        <div style="font-family:'alger2'; font-size:26px; text-decoration: underline;">
            REPORTE DE DONANTES
        </div>
        <div style="font-size:10px; margin-top:3px;">
            Documento interno - Fecha de emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
        </div>
   </div>

   <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Contacto</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donantes as $donante)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $donante->nombre }}</td>
                    <td>{{ $donante->TIPO }}</td>
                    <td>{{ $donante->contacto ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($donante->created_at)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
   </table>

   <div class="totales" style="display: flex; gap: 40px; margin-left: 20px; margin-top: 10px;">
        <div>
            <p><strong>Total de donantes:</strong> {{ $donantes->count() }}</p>
        </div>





<table>

  

    {{-- Mostrar conteos por lugar al final o donde quieras --}}
    <h5>Donantes por TIPO:</h5>
    <ul>
    @foreach($conteosPorLugar as $lugar => $cantidad)
        <li>{{ $lugar }}: {{ $cantidad }} donantes</li>
    @endforeach
    </ul>

</table>



   </div>

</div>

</body>
</html>
