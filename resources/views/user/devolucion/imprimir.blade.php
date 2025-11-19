








<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Imprimir Activo</title>
    <link rel="stylesheet" href="{{ asset('fonts/Algerian/font.css') }}">
    <style>
 @font-face {
    /* 1. Nombra la fuente para usarla en el resto del CSS */
    font-family: 'alger2';

    /* 2. Dile al navegador dónde está el archivo */
    src: url('/fonts/alger/alger.ttf') format('truetype'); 

    /* Opcional: Define el peso y estilo si lo hubiera */
    font-weight: normal; 
    font-style: normal; 
}
        .alger {
    font-family: 'alger2', sans-serif; /* Fuente personalizada */
    font-size: 26px;
    font-weight: normal;               /* Quita negrita */
    transform: skewX(-10deg);          /* Simula cursiva */
    text-decoration: underline;
    text-decoration-style: double;     /* Doble línea */
    text-align: center;                /* Centrado horizontal */
    display: block;  
    text-decoration-thickness: 1px;    
    text-underline-offset: 2px;              /* Para que text-align funcione en spans */
}
      h1 {
            font-size: 16px !important;
            margin-top: 0px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }



        .devolucion-info p {
            margin: 5px;
            line-height: 1.1;
        }

        @media print {
            table {
                width: 100%;
                border-collapse: collapse;
            }

            thead {
                display: table-header-group;
                /* REPITE el encabezado en cada página */
            }

            tbody {
                display: table-row-group;
            }
            
      body {
        font-size: 11px; 
    margin: 0 30px;   /* 0 arriba/abajo – 30px izquierda/derecha */
}

            
           .page {
    page-break-after: always;
    margin-top: 30px;
    margin-bottom: 20px;
}
            .partible {
        page-break-inside: auto !important;
        break-inside: auto !important;
    }
    .entero {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

        }
    </style>

</head>

<body >
{{-- <div class="empty_sp" style="height:160px;"></div> --}}

    <header class="header-print">
        <img src="{{ asset('plantillaPrint/headerPrint1.png') }}" alt="header"
            style="width: 100%; height: 100%; display: block;">
    </header>


 
    {{-- <div class="main"> --}}

        <div class="alger">ACTA DE DEVOLUCIÓN</div>
        {{-- <img src="{{ asset('plantillaPrint/headerTittle.png') }}" alt="header"
            style="height: auto; width: 40%; display: block; margin: 10px auto 0 auto;"> --}}

        <main style="margin-top: 0px;">

        <h1 class="alger" style="margin-bottom:30px;">DOCTO. Nº {{ $devolucion->numero_documento }}</h1>




<div class="devolucion-info" style="font-size:13px; font-family: Arial, sans-serif; margin-top:10px; background: transparent; display:flex; flex-direction:column; gap:8px;">

    <!-- Fila 1: En fecha -->
    <div style="display:flex; justify-content:flex-start; gap:10px;">
        <div style="flex:1; text-align:right; font-weight:bold;">En fecha:</div>
        <div style="flex:3; text-align:left;">{{ $fecha_devolucion_literal }}</div>
    </div>

    <!-- Fila 2: Por instrucción -->
    <div style="display:flex; justify-content:flex-start; gap:10px;">
        <div style="flex:1; text-align:right; font-weight:bold;">Por instrucción de:</div>
        <div style="flex:3; text-align:left;">
            {{ $responsables['director'] ?? '-' }}<br>
            <strong style="text-decoration: underline;">DIRECTOR DEL HOSPITAL DE II NIVEL WALTER KHON</strong><br>
            {{ $responsables['administrador'] ?? '-' }}<br>
            <strong style="text-decoration: underline;">ADMINISTRADOR DEL HOSPITAL DE II NIVEL WALTER KHON</strong>
        </div>
    </div>

    <!-- Fila 3: Se hace devolución a -->
    <div style="display:flex; justify-content:flex-start; gap:10px;">
        <div style="flex:1; text-align:right; font-weight:bold;">Se hace devolución a:</div>
        <div style="flex:3; text-align:left;">{{ strtoupper($responsableDevolucion ?? '-') }}</div>
    </div>

    <!-- Fila 4: Del servicio -->
    <div style="display:flex; justify-content:flex-start; gap:10px;">
        <div style="flex:1; text-align:right; font-weight:bold;">Del servicio:</div>
        <div style="flex:3; text-align:left;">{{ strtoupper($servicio ?? '-') }}</div>
    </div>

</div>





        <p>
            Por autorización de Dirección y Administración del Hospital de II Nivel Walter Khon dirigido por
            {{ $responsables['director'] ?? '-' }} y {{ $responsables['administrador'] ?? '-' }} se procede a la devolucion
            de activos que a continuación se detalla:
        </p>
        <!-- Tabla de activos -->
        <table style="width: 100%; border-collapse: collapse; margin: 10px 0;  font-family: Arial, sans-serif;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 5px; text-align: center;">Código</th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center;">Cant.</th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center;">Nombre</th>
                    <th style="border: 1px solid black; padding: 5px; text-align: left;">Detalle</th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center;">Unidad de medida</th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center;">Procedencia</th>
                    <th style="border: 1px solid black; padding: 5px; text-align: center;">Estado</th>
                </tr>
            </thead>
          <tbody>
    @forelse ($detalles as $detalle)
        <tr>
            <td style="border: 1px solid black; padding: 3px; text-align: center;">
                {{ $detalle->activo->codigo ?? '' }}
            </td>
            <td style="border: 1px solid black; padding: 3px; text-align: center;">1</td>
            <td style="border: 1px solid black; padding: 3px; text-align: center;">
                {{ $detalle->activo->nombre ?? '' }}
            </td>
            <td style="border: 1px solid black; padding: 3px; text-align: left;">
                {{ $detalle->activo->detalle ?? '' }}
            </td>
            <td style="border: 1px solid black; padding: 3px; text-align: center;">
                {{ $detalle->activo->unidad->nombre ?? '' }}
            </td>
            <td style="border: 1px solid black; padding: 3px; text-align: center;">Activos fijos</td>
            <td style="border: 1px solid black; padding: 3px; text-align: center;">
                {{ $detalle->activo->estado->nombre ?? '' }}
            </td>
        </tr>
    @empty
        <tr>
            <td style="border: 1px solid black; padding: 3px; text-align: center;" colspan="7">&nbsp;</td>
        </tr>
    @endforelse
</tbody>

        </table>
        </main>



        <footer>


            <div
                style="width: 100%; font-family: Arial, sans-serif; text-align: justify; font-size: 12px; padding: 5px 0;">
                <strong style="text-decoration: underline;"> NOTA:</strong> ESTE ACTIVO ES DEVUELTO
                A <strong>{{ strtoupper($responsabledevolucion ?? '') }}
                </strong> del servicio de: <strong>{{ strtoupper($servicio ?? '') }}</strong> para su USO Y CUSTODIA, DE ACUERDO AL
                <strong>DECRETO SUPREMO Nº 0181</strong> ARTICULOS 146 (ASIGNACION DE ACTIVOS FIJOS) Inc. I,II, Art 147
                (DOCUMENTO DE devolucion) Inc.1, Art 148 (LIBERACION DE LA RESPONSABILIDAD) Inc.I,II, Art. 154 (DEMANDA DE
                SERVICIOS DE MANTENIMIENTO), Art 157 (PROHIBICION PARA LOS SERVIDORES PUBLICOS SOBRE EL USO DE ACTIVOS
                FIJOS MUEBLES) Inc. I,II. LA NO OBSERVANCIA A ESTAS PROHIBICIONES GENERARA RESPONSABILIDADES EN LA
                <strong>LEY No 1178</strong> y sus reglamentos, QUEDA ESTABLECIDO QUE EL RESPONSABLE DEL CUIDADO,
                MANEJO, USO Y CUSTODIA DE LOS BIENES DESCRITOS EN EL PRESENTE ES EL <strong>SERVIDOR PUBLICO</strong>
                QUE LO RECIBE Y DE ACUERDO AL (<strong>RIP</strong>) REGLAMENTO INTERNO DE PERSONAL Art. 21 (Deberes)
                Inc. c). Inc. e). Inc. Art. 22 (Obligaciones) Inc. L). Inc. p). Art. 23 (Prohibiciones) Inc c) utilizar
                bienes muebles, inmuebles o recursos públicos en propósitos distintos a su actividad funcionaria o
                incurrir en acciones que dañen o causen su deterioro o generen riesgos de pérdida o sustracción. bb)
                Retirar de los recintos de la institución, sin previa autorización del superior correspondiente,
                cualquier documentación, bienes u objetos institucionales. ff) Ingresar activos personales a las
                oficinas de la institución, sin conocimiento del encargado de <strong>activos fijos</strong> y personal
                de seguridad de la institución. DONDE TODOS LOS <strong>SERVIDORES PUBLICOS</strong> SON RESPONSABLES DE
                CUALQUIER TRANSGRESION, EXTRAVIO QUE PUDIERA SUFRIR.
            </div>



            <table class="entero"
                style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; text-align: center;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #000; text-align: center; vertical-align: top;"></th>
                        <th style="border: 1px solid #000; text-align: center; vertical-align: top;"><u>ENTREGUE
                            CONFORME</u></th>
                        <th style="border: 1px solid #000; text-align: center; vertical-align: top;"><u>RECIBI
                                CONFORME</u></th>
                        <th style="border: 1px solid #000; text-align: center; vertical-align: top;" colspan="2">
                            <u>AUTORIZADO POR:</u></th>
                    </tr>

                </thead>
                <tbody>
                    {{-- <tr>
                        <th style="border: 1px solid #000; text-align: center; vertical-align: top;"></th>
                        <th style="border: 1px solid #000; text-align: center; vertical-align: top;"><u>ENTREGUE
                                CONFORME</u></th>
                        <th style="border: 1px solid #000; text-align: center; vertical-align: top;"><u>RECIBI
                                CONFORME</u></th>
                        <th style="border: 1px solid #000; text-align: center; vertical-align: top;" colspan="2">
                            <u>AUTORIZADO POR:</u></th>
                    </tr> --}}
                    <tr style="border: 1px solid #000; height: ;">
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            <u>SERVICIO</u>
                        </td>
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            <u>{{ strtoupper($servicio ?? '') }}</u>
                        </td>
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            <u>ACTIVOS FIJOS</u>
                        </td>
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            <u>ADMINISTRACION</u>
                        </td>
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            <u>DIRECCION</u>
                        </td>
                    </tr>
                    <tr style="border: 1px solid #000; height: 100px;">
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            {{-- <u>SERVICIO</u> --}}
                        </td>
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            {{-- <u>ACTIVOS FIJOS</u> --}}
                        </td>
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            {{-- <u>ANESTESIOLOGIA</u> --}}
                        </td>
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            {{-- <u>ADMINISTRACION</u> --}}
                        </td>
                        <td style="border: 1px solid #000; vertical-align: top; text-align: center;">
                            {{-- <u>DIRECCION</u> --}}
                        </td>
                    </tr>

                </tbody>
                
            </table>

        </footer>






        <script>
            window.onload = function() {
                window.print();
            }
        </script>
</body>

</html>
