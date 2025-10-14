<?php
session_start(); // iniciar sesión
$responsables = $_SESSION['responsablesDirectivos'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Acta de Entrega</title>
<style>
    body { font-family: "Times New Roman", serif; font-size: 12pt; margin: 30px; }
    .header { text-align: center; margin-bottom: 10px; }
    .header table { width: 100%; }
    .header img { width: 80px; height: auto; }
    .title { text-align: center; font-size: 16pt; font-weight: bold; text-decoration: underline; margin-bottom: 10px; }
    .subtitle { text-align: center; font-weight: bold; margin-bottom: 20px; }
    .doc-info { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
    .doc-info td { padding: 3px 5px; vertical-align: top; }
    .table-activos { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .table-activos th, .table-activos td { border: 1px solid #000; padding: 5px; text-align: center; }
    .firmas { width: 100%; margin-top: 50px; border-collapse: collapse; }
    .firmas td { width: 50%; text-align: center; padding-top: 50px; }
</style>
</head>
<body>

<!-- Encabezado -->
<div class="header">
    <table>
        <tr>
            <td><img src="logo1.png" alt="Logo 1"></td>
            <td>
                MINISTERIO DE SALUD Y DEPORTES<br>
                SERVICIO DEPARTAMENTAL DE SALUD<br>
                HOSPITAL DE 2DO NIVEL WALTER KHON
            </td>
            <td><img src="logo2.png" alt="Logo 2"></td>
        </tr>
    </table>
</div>

<!-- Título -->
<div class="title">ACTA DE ENTREGA</div>
<div class="subtitle">DOC. N° __NUMERO__</div>

<!-- Información del documento -->
<table class="doc-info">
    <tr>
        <td><strong>En fecha:</strong></td>
        <td>__FECHA__</td>
    </tr>
    <tr>
        <td><strong>POR INSTRUCCIÓN:</strong></td>
        <td>
            <?php foreach($responsables as $r) {
                echo htmlspecialchars($r->abreviatura . ' ' . $r->nombre . " - " . $r->cargo) . "<br>";
            } ?>
        </td>
    </tr>
    <tr>
        <td><strong>SE HACE ENTREGA A:</strong></td>
        <td>Lic. __RESPONSABLE__<br>SERVICIO: __SERVICIO__</td>
    </tr>
</table>

<p>Por autorización de Dirección y Administración del Hospital de II Nivel Walter Khon se procede a la ENTREGA DE ACTIVOS FIJOS que a continuación se detalla:</p>

<!-- Tabla de activos -->
<table class="table-activos">
    <thead>
        <tr>
            <th>CÓDIGO</th>
            <th>CANT.</th>
            <th>UNIDAD DE MEDIDA</th>
            <th>NOMBRE</th>
            <th>DETALLE</th>
            <th>ESTADO DEL EQUIPO</th>
        </tr>
    </thead>
    <tbody id="tablaActivos">
        <!-- Aquí puedes generar filas dinámicamente con PHP o JS -->
        <tr>
            <td>S/C</td>
            <td>4</td>
            <td>UNIDAD</td>
            <td>OLLA A PRESIÓN MARCA CLOCK</td>
            <td>ACTIVOS FIJOS</td>
            <td>NUEVO</td>
        </tr>
    </tbody>
</table>

<!-- Firmas -->
<table class="firmas">
    <tr>
        <td>_________________________<br>RESPONSABLE</td>
        <td>_________________________<br>ADMINISTRADOR</td>
    </tr>
</table>

</body>
</html>
