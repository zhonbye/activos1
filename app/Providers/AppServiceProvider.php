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
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
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
















    View::composer('admin.panelControl', function ($view) {

        // -----------------------------
        // 1️⃣ Totales para las cards
        // -----------------------------
        $countActivos = Activo::count();
        $countUsuarios = Usuario::count();
        $countUnidades = Unidad::count();
        $countCategorias = Categoria::count();
        // $countReportes = Reporte::count();

        // Total de movimientos combinando tablas
        $countMovimientos =
            Entrega::count() +
            Traslado::count() +
            Devolucion::count() +
            Baja::count();

        // -----------------------------
        // 2️⃣ Activos por estado
        // -----------------------------
        $activosPorEstado = Activo::join('estados', 'activos.id_estado', '=', 'estados.id_estado')
            ->select('estados.nombre as estado', DB::raw('COUNT(activos.id_activo) as total'))
            ->groupBy('estados.nombre')
            ->pluck('total', 'estado');

        // -----------------------------
        // 3️⃣ Movimientos por usuario
        // -----------------------------
        $usuarios = Usuario::pluck('usuario', 'id_usuario'); // ['1'=>'juan', '2'=>'maria', ...]

        $dataMovimientosUsuarios = [];
        foreach ($usuarios as $id_usuario => $nombre) {
            $movimientos = 0;
            $movimientos += Entrega::where('id_usuario', $id_usuario)->count();
            $movimientos += Traslado::where('id_usuario', $id_usuario)->count();
            $movimientos += Devolucion::where('id_usuario',$id_usuario)->count();
            $movimientos += Baja::where('id_usuario', $id_usuario)->count();
            $dataMovimientosUsuarios[] = $movimientos;
        }

        // -----------------------------
        // 4️⃣ Activos por unidad
        // -----------------------------
        $unidades = Unidad::pluck('nombre', 'id_unidad'); // ['1'=>'Recursos Humanos', '2'=>'Logística']
        $dataActivosUnidades = [];

        foreach ($unidades as $id_unidad => $nombre) {
            $count = Activo::where('id_unidad', $id_unidad)->count();
            $dataActivosUnidades[] = $count;
        }

        // -----------------------------
        // 5️⃣ Pasar a la vista
        // -----------------------------
        $view->with([
            'countActivos' => $countActivos,
            'countUsuarios' => $countUsuarios,
            'countUnidades' => $countUnidades,
            'countCategorias' => $countCategorias,
            'countMovimientos' => $countMovimientos,
            // 'countReportes' => $countReportes,
            'activosPorEstado' => $activosPorEstado,
            'usuarios' => array_values($usuarios->toArray()),
            'dataMovimientosUsuarios' => $dataMovimientosUsuarios,
            'unidades' => array_values($unidades->toArray()),
            'dataActivosUnidades' => $dataActivosUnidades,
        ]);
    });









// use Illuminate\Support\Facades\Auth;

View::composer('user.panelControl', function ($view) {

    $usuarioId = Auth::id(); // ID del usuario logueado

    // -----------------------------
    // 1️⃣ Totales para cards (solo del usuario)
    // -----------------------------
    $countActivos = Activo::count(); // Activos no dependen del usuario, si quieres solo los suyos habría que tener id_usuario
    $countEntregas = Entrega::where('estado', 'finalizado')
        ->where('id_usuario', $usuarioId)
        ->count();
    $countTraslados = Traslado::where('estado', 'finalizado')
        ->where('id_usuario', $usuarioId)
        ->count();
    // $countBajas = Baja::where('estado', 'finalizado')
    //     ->where('id_usuario', $usuarioId)
    //     ->count();
    $countDevoluciones = Devolucion::where('estado', 'finalizado')
        ->where('id_usuario', $usuarioId)
        ->count();
    $countInventarios = Inventario::where('estado', 'vigente')
        ->where('id_usuario', $usuarioId) // si inventario tiene id_usuario
        ->count();

    // -----------------------------
    // 2️⃣ Activos por estado (puede ser global o por usuario si aplica)
    // -----------------------------
    $activosPorEstado = Activo::join('estados', 'activos.id_estado', '=', 'estados.id_estado')
        ->select('estados.nombre as estado', DB::raw('count(activos.id_activo) as total'))
        ->groupBy('estados.nombre')
        ->pluck('total', 'estado');

    // -----------------------------
    // 3️⃣ Movimientos por semana (solo usuario)
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
            ->where('id_usuario', $usuarioId)
            ->count();

        $dataTraslados[] = Traslado::whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->where('estado', 'finalizado')
            ->where('id_usuario', $usuarioId)
            ->count();

        // $dataBajas[] = Baja::whereBetween('created_at', [$fechaInicio, $fechaFin])
        //     ->where('estado', 'finalizado')
        //     ->where('id_usuario', $usuarioId)
        //     ->count();

        $dataDevoluciones[] = Devolucion::whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->where('estado', 'finalizado')
            ->where('id_usuario', $usuarioId)
            ->count();
    }

    // -----------------------------
    // 4️⃣ Activos por servicio (detalle inventario)
    // -----------------------------
    $dataServicios = [];
    $servicios = DB::table('servicios')->pluck('nombre', 'id_servicio');

    foreach ($servicios as $id_servicio => $nombre) {
        $inventario = DB::table('inventarios')
            ->where('id_servicio', $id_servicio)
            ->where('estado', 'vigente')
            ->where('id_usuario', $usuarioId) // solo del usuario
            ->latest('id_servicio')
            ->first();

        if ($inventario) {
            $count = DB::table('detalle_inventarios')
                ->where('id_inventario', $inventario->id_inventario)
                ->count();
        } else {
            $count = 0;
        }

        $dataServicios[$nombre] = $count;
    }

    // -----------------------------
    // 5️⃣ Pasar todo a la vista
    // -----------------------------
    $view->with([
        'countActivos' => $countActivos,
        'countEntregas' => $countEntregas,
        'countTraslados' => $countTraslados,
        // 'countBajas' => $countBajas,
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







    // View::composer('user.panelControl', function ($view) {

    //     // -----------------------------
    //     // 1️⃣ Totales para cards
    //     // -----------------------------
    //     $countActivos = Activo::count();
    //     $countEntregas = Entrega::where('estado', 'finalizado')->count();
    //     $countTraslados = Traslado::where('estado', 'finalizado')->count();
    //     $countBajas = Baja::where('estado', 'finalizado')->count();
    //     $countDevoluciones = Devolucion::where('estado', 'finalizado')->count();
    //     $countInventarios = Inventario::where('estado', 'vigente')->count();

    //     // -----------------------------
    //     // 2️⃣ Activos por estado
    //     // -----------------------------
    //     $activosPorEstado = Activo::join('estados', 'activos.id_estado', '=', 'estados.id_estado')
    //         ->select('estados.nombre as estado', DB::raw('count(activos.id_activo) as total'))
    //         ->groupBy('estados.nombre')
    //         ->pluck('total', 'estado'); // ['Nuevo'=>50, 'Usado'=>60, ...]

    //     // -----------------------------
    //     // 3️⃣ Movimientos por semana
    //     // -----------------------------
    //     $semanas = [
    //         'Semana 1' => now()->startOfMonth(),
    //         'Semana 2' => now()->startOfMonth()->addWeek(),
    //         'Semana 3' => now()->startOfMonth()->addWeeks(2),
    //         'Semana 4' => now()->startOfMonth()->addWeeks(3),
    //     ];

    //     $dataEntregas = [];
    //     $dataTraslados = [];
    //     $dataBajas = [];
    //     $dataDevoluciones = [];

    //     foreach ($semanas as $semana => $fechaInicio) {
    //         $fechaFin = $fechaInicio->copy()->addWeek()->subSecond();

    //         $dataEntregas[] = Entrega::whereBetween('created_at', [$fechaInicio, $fechaFin])
    //             ->where('estado', 'finalizado')
    //             ->count();

    //         $dataTraslados[] = Traslado::whereBetween('created_at', [$fechaInicio, $fechaFin])
    //             ->where('estado', 'finalizado')
    //             ->count();

    //         $dataBajas[] = Baja::whereBetween('created_at', [$fechaInicio, $fechaFin])
    //             ->where('estado', 'finalizado')
    //             ->count();

    //         $dataDevoluciones[] = Devolucion::whereBetween('created_at', [$fechaInicio, $fechaFin])
    //             ->where('estado', 'finalizado')
    //             ->count();
    //     }

    //     // -----------------------------
    //     // 4️⃣ Activos por servicio (detalle inventario)
    //     // -----------------------------
    //     $dataServicios = [];
    //     $servicios = DB::table('servicios')->pluck('nombre', 'id_servicio'); // id = id_servicio

    //     foreach ($servicios as $id_servicio => $nombre) {

    //         // Obtener inventario vigente de este servicio
    //         $inventario = DB::table('inventarios')
    //             ->where('id_servicio', $id_servicio)
    //             ->where('estado', 'vigente')
    //             ->latest('id_servicio')
    //             ->first();

    //         if ($inventario) {
    //             // Contar los activos en detalle_inventario
    //             $count = DB::table('detalle_inventarios')
    //                 ->where('id_inventario', $inventario->id_inventario)
    //                 ->count();
    //         } else {
    //             $count = 0;
    //         }

    //         $dataServicios[$nombre] = $count;
    //     }

    //     // -----------------------------
    //     // 5️⃣ Pasamos todo a la vista
    //     // -----------------------------
    //     $view->with([
    //         'countActivos' => $countActivos,
    //         'countEntregas' => $countEntregas,
    //         'countTraslados' => $countTraslados,
    //         'countBajas' => $countBajas,
    //         'countDevoluciones' => $countDevoluciones,
    //         'countInventarios' => $countInventarios,
    //         'activosPorEstado' => $activosPorEstado,
    //         'semanas' => array_keys($semanas),
    //         'dataEntregas' => $dataEntregas,
    //         'dataTraslados' => $dataTraslados,
    //         'dataBajas' => $dataBajas,
    //         'dataDevoluciones' => $dataDevoluciones,
    //         'servicios' => array_keys($dataServicios),
    //         'dataServicios' => array_values($dataServicios),
    //     ]);
    // });
}

}
