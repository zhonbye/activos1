<?php

namespace App\Providers;

use App\Models\Activo;
use App\Models\Entrega;
use App\Models\Traslado;
use App\Models\Baja;
use App\Models\Cargo;
use App\Models\Categoria;
use App\Models\Devolucion;
use App\Models\Estado;
use App\Models\Inventario;
use App\Models\Unidad;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    
    

    public function boot(): void
{


  View::composer('user.parametros.parametros', function ($view) {
        // Obtener todas las unidades
        $unidades = Unidad::orderBy('nombre')->get(); // Puedes filtrar o paginar si quieres
        $estados = Estado::orderBy('nombre')->get(); // Puedes filtrar o paginar si quieres
        $cargos = Cargo::orderBy('nombre')->get(); // Puedes filtrar o paginar si quieres
        $categorias = Categoria::orderBy('nombre')->get(); // Puedes filtrar o paginar si quieres

        // Pasar la variable a la vista
        $view->with([
    'unidades' => $unidades,
    'estados' => $estados,
    'cargos' => $cargos,
    'categorias' => $categorias,
]);
    });


    View::composer('user.panelControl', function ($view) {

        // -----------------------------
        // 1️⃣ Totales para cards
        // -----------------------------
        $countActivos = Activo::count();
        $countEntregas = Entrega::where('estado', 'finalizado')->count();
        $countTraslados = Traslado::where('estado', 'finalizado')->count();
        $countBajas = Baja::where('estado', 'finalizado')->count();
        $countDevoluciones = Devolucion::where('estado', 'finalizado')->count();
        $countInventarios = Inventario::where('estado', 'vigente')->count();

        // -----------------------------
        // 2️⃣ Activos por estado
        // -----------------------------
        $activosPorEstado = Activo::join('estados', 'activos.id_estado', '=', 'estados.id_estado')
            ->select('estados.nombre as estado', DB::raw('count(activos.id_activo) as total'))
            ->groupBy('estados.nombre')
            ->pluck('total', 'estado'); // ['Nuevo'=>50, 'Usado'=>60, ...]

        // -----------------------------
        // 3️⃣ Movimientos por semana
        // -----------------------------
        $semanas = [
            'Semana 1' => now()->startOfMonth(),
            'Semana 2' => now()->startOfMonth()->addWeek(),
            'Semana 3' => now()->startOfMonth()->addWeeks(2),
            'Semana 4' => now()->startOfMonth()->addWeeks(3),
        ];

        $dataEntregas = [];
        $dataTraslados = [];
        $dataBajas = [];
        $dataDevoluciones = [];

        foreach ($semanas as $semana => $fechaInicio) {
            $fechaFin = $fechaInicio->copy()->addWeek()->subSecond();

            $dataEntregas[] = Entrega::whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->where('estado', 'finalizado')
                ->count();

            $dataTraslados[] = Traslado::whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->where('estado', 'finalizado')
                ->count();

            $dataBajas[] = Baja::whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->where('estado', 'finalizado')
                ->count();

            $dataDevoluciones[] = Devolucion::whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->where('estado', 'finalizado')
                ->count();
        }

        // -----------------------------
        // 4️⃣ Activos por servicio (detalle inventario)
        // -----------------------------
        $dataServicios = [];
        $servicios = DB::table('servicios')->pluck('nombre', 'id_servicio'); // id = id_servicio

        foreach ($servicios as $id_servicio => $nombre) {

            // Obtener inventario vigente de este servicio
            $inventario = DB::table('inventarios')
                ->where('id_servicio', $id_servicio)
                ->where('estado', 'vigente')
                ->latest('id_servicio')
                ->first();

            if ($inventario) {
                // Contar los activos en detalle_inventario
                $count = DB::table('detalle_inventarios')
                    ->where('id_inventario', $inventario->id_inventario)
                    ->count();
            } else {
                $count = 0;
            }

            $dataServicios[$nombre] = $count;
        }

        // -----------------------------
        // 5️⃣ Pasamos todo a la vista
        // -----------------------------
        $view->with([
            'countActivos' => $countActivos,
            'countEntregas' => $countEntregas,
            'countTraslados' => $countTraslados,
            'countBajas' => $countBajas,
            'countDevoluciones' => $countDevoluciones,
            'countInventarios' => $countInventarios,
            'activosPorEstado' => $activosPorEstado,
            'semanas' => array_keys($semanas),
            'dataEntregas' => $dataEntregas,
            'dataTraslados' => $dataTraslados,
            'dataBajas' => $dataBajas,
            'dataDevoluciones' => $dataDevoluciones,
            'servicios' => array_keys($dataServicios),
            'dataServicios' => array_values($dataServicios),
        ]);
    });
}

}
