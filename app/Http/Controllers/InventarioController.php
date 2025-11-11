<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\DetalleInventario;
use App\Models\Inventario;
use App\Models\Responsable;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function consultar()
    // {
    //     $servicios = Servicio::orderBy('nombre')->get();
    //     $responsables = Responsable::orderBy('nombre')->get();

    //     // Carga los 20 primeros sin filtros
    //     $inventarios = Inventario::orderBy('fecha', 'desc')->paginate(20);

    //     return view('user.inventario.consultar', compact('inventarios', 'servicios', 'responsables'));
    // }


    public function activosInventario($id_inventario)
    {
        // Busca el inventario con sus detalles y activos relacionados
        $inventario = Inventario::with('detalles.activo')->findOrFail($id_inventario);

        // Pagina los detalles con sus activos
        $detalles = $inventario->detalles()->with('activo')->paginate(20);

        // Devuelve la vista con los detalles paginados
        return view('user.inventario.activos', compact('detalles', 'id_inventario'));
    }



    public function consultar()
{
    $servicios = Servicio::orderBy('nombre')->get();
    $responsables = Responsable::orderBy('nombre')->get();

    // No carga inventarios aquí
    return view('user.inventario.consultar', compact('servicios', 'responsables'));
}

    public function filtrar(Request $request)
{
    $query = Inventario::orderBy('fecha', 'desc');

    if ($request->filled('servicio') && !in_array($request->servicio, ['0', 'all'])) {
        $query->where('id_servicio', $request->servicio);
    }

    if ($request->filled('responsable') && !in_array($request->responsable, ['0', 'all'])) {
        $query->where('id_responsable', $request->responsable);
    }

    // 🔁 Solo uno de los dos: gestión o rango de fechas
    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
    } elseif ($request->filled('gestion') && !in_array($request->gestion, ['0', 'all'])) {
        $query->where('gestion', $request->gestion);
    }

    $inventarios = $query->paginate(20)->withQueryString();

    return view('user.inventario.parcial', compact('inventarios'))->render();
}


    public function ultimoInventario(Request $request)
    {
        $servicioId = $request->input('servicio_id');

        if (!$servicioId) {
            return response()->json(null, 400); // Bad Request si no se pasa el servicio
        }

        // Obtener el último inventario filtrando por servicio_id y ordenando por gestión descendente
        $inventario = Inventario::where('id_servicio', $servicioId)
            ->orderByDesc('gestion')
            ->latest('created_at')
            ->first();

        if (!$inventario) {
            return response()->json(null);
        }

        $cantidadActivos = DetalleInventario::where('id_inventario', $inventario->id_inventario)
            ->sum('cantidad');
              $nombreResponsable = $inventario->responsable ? $inventario->responsable->nombre : 'No asignado';

        // Contar los activos asociados
        // $cantidadActivos = $inventario->activos()->count();

        // Convertir todo el inventario a array
        $data = $inventario->toArray();

        // Agregar la cantidad de activos
        $data['cantidad_activos'] = $cantidadActivos;
        $data['nombre_responsable'] = $nombreResponsable;
        return response()->json($data);
    }
    public function generarNumeroDocumento()
    {
        $maxNumero = 999; // máximo permitido
        // Trae todos los numeros_documento existentes (solo esa columna)
        $numerosExistentes = Inventario::pluck('numero_documento')->toArray();

        // Convertimos a un set para búsqueda rápida
        $numerosExistentesSet = array_flip($numerosExistentes);

        for ($i = 1; $i <= $maxNumero; $i++) {
            $numeroFormateado = str_pad($i, 3, '0', STR_PAD_LEFT);
            if (!isset($numerosExistentesSet[$numeroFormateado])) {
                return $numeroFormateado;
            }
        }

        throw new \Exception('No hay números disponibles');
    }
    // Generar un nuevo inventario
    // public function generarVacio(Request $request)
    // {
    //     $request->validate([
    //         'id_servicio' => 'required|exists:servicios,id_servicio',
    //         'id_responsable' => 'required|exists:responsables,id_responsable',
    //         'gestion' => 'required',
    //         'fecha' => 'required|date',
    //     ]);

    //     try {
    //         $inventario = Inventario::create([
    //             'numero_documento' => $this->generarNumeroDocumento(),
    //             'gestion' => $request->input('gestion'),
    //             'fecha' => $request->input('fecha'),
    //             'id_usuario' => Auth::id(),
    //             'id_responsable' => $request->input('id_responsable'),
    //             'id_servicio' => $request->input('id_servicio'),
    //             'observaciones' => "generado automaticamente" ?? null,
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'inventario' => $inventario
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'error' => 'Error al generar inventario: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    /**
     * Show the form for creating a new resource.
     */
    // public function consultar(Request $request)
    // {
    //     $query = Inventario::orderBy('fecha', 'desc');

    //     if ($request->filled('servicio') && !in_array($request->servicio, ['0', 'all'])) {
    //         $query->where('id_servicio', $request->servicio);
    //     }

    //     if ($request->filled('responsable') && !in_array($request->responsable, ['0', 'all'])) {
    //         $query->where('id_responsable', $request->responsable);
    //     }

    //     if ($request->filled('gestion') && !in_array($request->gestion, ['0', 'all'])) {
    //         $query->where('gestion', $request->gestion);
    //     }

    //     if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
    //         $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
    //     }

    //     $inventarios = $query->paginate(20)->withQueryString();

    //     $servicios = Servicio::orderBy('nombre')->get();
    //     $responsables = Responsable::orderBy('nombre')->get();
    //     $gestiones = Inventario::select('gestion')->distinct()->orderByDesc('gestion')->pluck('gestion');

    //     if ($request->ajax() && (
    //         $request->has('servicio') ||
    //         $request->has('responsable') ||
    //         $request->has('gestion') ||
    //         $request->has('fecha_inicio') ||
    //         $request->has('page') // para paginación
    //     )) {
    //         return view('user.inventario.parcial', compact('inventarios'))->render();
    //     }

    //     return view('user.inventario.consultar', compact('inventarios', 'servicios', 'responsables', 'gestiones'));
    // }




     // public function consultar()
    // {
    //     // Últimos 20 inventarios
    //     $inventarios = Inventario::orderBy('fecha', 'desc')->take(20)->get();

    //     // Todos los servicios
    //     $servicios = Servicio::orderBy('nombre')->get();

    //     // Todos los responsables
    //     $responsables = Responsable::orderBy('nombre')->get();

    //     // Gestiones disponibles desde Inventario (esto sí lo tomamos desde inventarios)
    //     $gestiones = Inventario::select('gestion')->distinct()->orderByDesc('gestion')->pluck('gestion');

    //     return view('user.inventario.consultar', compact('inventarios', 'servicios', 'responsables', 'gestiones'));
    // }

//     public function filtrar(Request $request)
// {
//     $query = Inventario::query();

//     if ($request->filled('servicio')) {
//         $query->where('id_servicio', $request->servicio);
//     }

//     if ($request->filled('gestion')) {
//         $query->where('gestion', $request->gestion);
//     }

//     if ($request->filled('responsable')) {
//         $query->where('id_responsable', $request->responsable);
//     }

//     if ($request->filled('fecha_inicio')) {
//         $query->whereDate('fecha', '>=', $request->fecha_inicio);
//     }

//     if ($request->filled('fecha_fin')) {
//         $query->whereDate('fecha', '<=', $request->fecha_fin);
//     }

//     $inventarios = $query->orderBy('numero_documento', 'desc')->take(100)->get();

//     // 👇 Aquí retornamos solo la tabla renderizada
//     return view('inventarios.partials.tabla', compact('inventarios'));
// }










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
    public function show(Inventario $inventario)
    {
        return view('user.inventario.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $inventario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        //
    }
}
