<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Responsable;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $servicios = Servicio::orderBy('nombre')->get();
        $servicios = Servicio::whereRaw('LOWER(nombre) NOT LIKE ?', ['%activos fijos%'])->get();
        $responsables = Responsable::orderBy('nombre')->get();

        // No carga inventarios aquí
        // return view('user.inventario.consultar', );
        return view('user.movimientos.listar', compact('servicios', 'responsables'));
    }

    public function filtrar(Request $request)
    {
        $tipoActa = $request->input('tipo_acta', 'all');

        $resultados = collect();

        // -----------------------------
        // Entregas
        // -----------------------------
        if ($tipoActa === 'all' || $tipoActa === 'entrega') {
            $query = DB::table('entregas')
                ->leftJoin('usuarios as u', 'entregas.id_usuario', '=', 'u.id_usuario') // tu tabla es usuarios
                ->leftJoin('responsables as r', 'entregas.id_responsable', '=', 'r.id_responsable')
                ->leftJoin('servicios as s', 'entregas.id_servicio', '=', 's.id_servicio')
                ->select(
                    'entregas.*',
                    'u.usuario as usuario',        // nombre del usuario
                    'r.nombre as responsable',  // nombre del responsable
                    's.nombre as servicio',      // nombre del servicio
                    DB::raw('entregas.id_entrega as id')
                );
// Filtro general búsqueda
if ($request->filled('busqueda')) {
    $bus = $request->busqueda;

    $query->where(function($q) use ($bus) {
        $q->where('entregas.numero_documento', 'like', "%{$bus}%")
          ->orWhere('entregas.gestion', 'like', "%{$bus}%")
          ->orWhere('r.nombre', 'like', "%{$bus}%")
          ->orWhere('s.nombre', 'like', "%{$bus}%");
    });
}


            if ($request->filled('numero_documento')) {
                $query->where('numero_documento', 'like', "%{$request->numero_documento}%");
            }

            if ($request->filled('gestion')) {
                $query->where('gestion', $request->gestion);
            }

            // if ($request->filled('estado') && $request->estado !== 'all') {
            //     $query->where('estado', $request->estado);
            // }
            if ($request->filled('estado') && $request->estado !== 'all') {
                $query->where('entregas.estado', $request->estado); // 🔥 FIX
            }


            // Servicio destino en entregas
            // if ($request->filled('id_servicio_destino') && $request->id_servicio_destino !== 'all') {
            //     // $query->where('id_servicio', $request->id_servicio_destino);
            //     $query->where('entregas.id_servicio', $request->id_servicio_destino);

            // }
            if ($request->filled('id_servicio_destino') && $request->id_servicio_destino !== 'all') {
                $query->where('entregas.id_servicio', $request->id_servicio_destino);
            }

            // Rango de fechas
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $resultados = $resultados->concat($query->get()->map(fn($e) => (object) array_merge((array)$e, [
                'tipo_acta' => 'entrega',
                'id' => $e->id_entrega,
            ])));
        }

        // -----------------------------
        // Traslados
        // -----------------------------
        if ($tipoActa === 'all' || $tipoActa === 'traslado') {
            $query = DB::table('traslados')
                ->leftJoin('usuarios as u', 'traslados.id_usuario', '=', 'u.id_usuario')

                // Responsables
                ->leftJoin('responsables as r_origen', 'traslados.id_responsable_origen', '=', 'r_origen.id_responsable')
                ->leftJoin('responsables as r_destino', 'traslados.id_responsable_destino', '=', 'r_destino.id_responsable')

                // Servicios
                ->leftJoin('servicios as s_origen', 'traslados.id_servicio_origen', '=', 's_origen.id_servicio')
                ->leftJoin('servicios as s_destino', 'traslados.id_servicio_destino', '=', 's_destino.id_servicio')

                ->select(
                    'traslados.*',
                    'u.usuario as usuario',
                    'r_origen.nombre as responsable_origen',
                    'r_destino.nombre as responsable_destino',
                    's_origen.nombre as servicio_origen',
                    's_destino.nombre as servicio_destino',
                    DB::raw('traslados.id_traslado as id') // Normalizamos id para Blade
                );
// Filtro general búsqueda
if ($request->filled('busqueda')) {
    $bus = $request->busqueda;

    $query->where(function($q) use ($bus) {
        $q->where('traslados.numero_documento', 'like', "%{$bus}%")
          ->orWhere('traslados.gestion', 'like', "%{$bus}%")
          ->orWhere('r_origen.nombre', 'like', "%{$bus}%")
          ->orWhere('r_destino.nombre', 'like', "%{$bus}%")
          ->orWhere('s_origen.nombre', 'like', "%{$bus}%")
          ->orWhere('s_destino.nombre', 'like', "%{$bus}%");
    });
}


            if ($request->filled('numero_documento')) {
                $query->where('numero_documento', 'like', "%{$request->numero_documento}%");
            }

            if ($request->filled('gestion')) {
                $query->where('gestion', $request->gestion);
            }

            // if ($request->filled('estado') && $request->estado !== 'all') {
            //     $query->where('estado', $request->estado);
            // }

            if ($request->filled('estado') && $request->estado !== 'all') {
                $query->where('traslados.estado', $request->estado); // 🔥 FIX
            }

            // Servicios origen y destino
            if ($request->filled('id_servicio_origen') && $request->id_servicio_origen !== 'all') {
                $query->where('id_servicio_origen', $request->id_servicio_origen);
            }

            // if ($request->filled('id_servicio_destino') && $request->id_servicio_destino !== 'all') {
            //     $query->where('id_servicio_destino', $request->id_servicio_destino);
            // }
            if ($request->filled('id_servicio_destino') && $request->id_servicio_destino !== 'all') {
                $query->where('id_servicio_destino', $request->id_servicio_destino);
            }
            // Rango de fechas
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $resultados = $resultados->concat($query->get()->map(fn($t) => (object) array_merge((array)$t, ['tipo_acta' => 'traslado'])));
        }

        // -----------------------------
        // Devoluciones
        // -----------------------------
        if ($tipoActa === 'all' || $tipoActa === 'devolucion') {
            // $query = DB::table('devoluciones');
            $query = DB::table('devoluciones')
                ->leftJoin('usuarios as u', 'devoluciones.id_usuario', '=', 'u.id_usuario')
                ->leftJoin('responsables as r', 'devoluciones.id_responsable', '=', 'r.id_responsable')
                ->leftJoin('servicios as s', 'devoluciones.id_servicio', '=', 's.id_servicio')
                ->select(
                    'devoluciones.*',
                    'u.usuario as usuario',
                    'r.nombre as responsable',
                    's.nombre as servicio',
                    DB::raw('devoluciones.id_devolucion as id') // Normalizamos id
                );
// Filtro general búsqueda
if ($request->filled('busqueda')) {
    $bus = $request->busqueda;

    $query->where(function($q) use ($bus) {
        $q->where('devoluciones.numero_documento', 'like', "%{$bus}%")
          ->orWhere('devoluciones.gestion', 'like', "%{$bus}%")
          ->orWhere('r.nombre', 'like', "%{$bus}%")
          ->orWhere('s.nombre', 'like', "%{$bus}%");
    });
}

            if ($request->filled('numero_documento')) {
                $query->where('numero_documento', 'like', "%{$request->numero_documento}%");
            }

            if ($request->filled('gestion')) {
                $query->where('gestion', $request->gestion);
            }

            // if ($request->filled('estado') && $request->estado !== 'all') {
            //     $query->where('estado', $request->estado);
            // }
            if ($request->filled('estado') && $request->estado !== 'all') {
                $query->where('devoluciones.estado', $request->estado); // 🔥 FIX
            }
            // Servicio origen
            if ($request->filled('id_servicio_origen') && $request->id_servicio_origen !== 'all') {
                $query->where('id_servicio', $request->id_servicio_origen);
            }

            // Rango de fechas
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $resultados = $resultados->concat($query->get()->map(fn($d) => (object) array_merge((array)$d, ['tipo_acta' => 'devolucion'])));
        }

        // -----------------------------
        // Ordenar
        // -----------------------------
        $ordenarPor = $request->input('ordenar_por', 'fecha');
        $direccion  = $request->input('direccion', 'desc');

        $resultados = $resultados->sortBy($ordenarPor, SORT_REGULAR, $direccion === 'desc');
        session(['resultados_filtrados' => $resultados]);
        // dd($resultados);
        // -----------------------------
        // Paginación manual
        // -----------------------------
        $perPage = 20;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $resultados->slice(($page - 1) * $perPage, $perPage)->values(),
            $resultados->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('user.movimientos.parcial', ['inventarios' => $paginated])->render();
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movimiento $movimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimiento $movimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movimiento $movimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movimiento $movimiento)
    {
        //
    }
}
