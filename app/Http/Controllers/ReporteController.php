<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
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
