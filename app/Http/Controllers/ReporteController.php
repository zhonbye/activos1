<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{






public function imprimirDonantes()
    {
        // Tomamos los donantes filtrados de la sesión
        $donantes = session('donantes_filtrados', collect());

        if ($donantes->isEmpty()) {
            return back()->with('error', 'No hay donantes para imprimir.');
        }

        // Contar donantes por lugar sin alterar la lista
        $conteosPorLugar = $donantes->groupBy('tipo')->map(fn($grupo) => $grupo->count());

        // Generar PDF
        $pdf = Pdf::loadView('user.donantes.reporteDonante', [
            'donantes' => $donantes,
            'conteosPorLugar' => $conteosPorLugar
        ]);

        return $pdf->stream('reporte-proveedores.pdf');
    }

    public function imprimirProveedores()
    {
        // Tomamos los proveedores filtrados de la sesión
        $proveedores = session('proveedores_filtrados', collect());

        if ($proveedores->isEmpty()) {
            return back()->with('error', 'No hay proveedores para imprimir.');
        }

        // Contar proveedores por lugar sin alterar la lista
        $conteosPorLugar = $proveedores->groupBy('lugar')->map(fn($grupo) => $grupo->count());

        // Generar PDF
        $pdf = Pdf::loadView('user.proveedores.reporteProveedores', [
            'proveedores' => $proveedores,
            'conteosPorLugar' => $conteosPorLugar
        ]);

        return $pdf->stream('reporte-proveedores.pdf');
    }






public function imprimirActas()
{
    $resultados = session('resultados_filtrados', collect());

    if ($resultados->isEmpty()) {
        return back()->with('error', 'No hay resultados para imprimir.');
    }

    $pdf = Pdf::loadView('user.movimientos.reporte', [
        'resultados' => $resultados
    ]);

    return $pdf->stream('reporte-actas.pdf');
}






}
