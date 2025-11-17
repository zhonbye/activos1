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
        return view('user.movimientos.listar',compact('servicios', 'responsables'));
    }

    public function filtrar(Request $request)
    {
        $tipoActa = $request->input('tipo_acta', 'all');

        $resultados = collect();

        // -----------------------------
        // Entregas
        // -----------------------------
        if ($tipoActa === 'all' || $tipoActa === 'entrega') {
            $query = DB::table('entregas');

            if ($request->filled('numero_documento')) {
                $query->where('numero_documento', 'like', "%{$request->numero_documento}%");
            }

            if ($request->filled('gestion')) {
                $query->where('gestion', $request->gestion);
            }

            if ($request->filled('estado') && $request->estado !== 'all') {
                $query->where('estado', $request->estado);
            }

            // Servicio destino en entregas
            if ($request->filled('id_servicio_destino') && $request->id_servicio_destino !== 'all') {
                $query->where('id_servicio', $request->id_servicio_destino);
            }

            // Rango de fechas
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
            }

            $resultados = $resultados->concat($query->get()->map(fn($e) => (object) array_merge((array)$e, ['tipo_acta' => 'entrega'])));
        }

        // -----------------------------
        // Traslados
        // -----------------------------
        if ($tipoActa === 'all' || $tipoActa === 'traslado') {
            $query = DB::table('traslados');

            if ($request->filled('numero_documento')) {
                $query->where('numero_documento', 'like', "%{$request->numero_documento}%");
            }

            if ($request->filled('gestion')) {
                $query->where('gestion', $request->gestion);
            }

            if ($request->filled('estado') && $request->estado !== 'all') {
                $query->where('estado', $request->estado);
            }

            // Servicios origen y destino
            if ($request->filled('id_servicio_origen') && $request->id_servicio_origen !== 'all') {
                $query->where('id_servicio_origen', $request->id_servicio_origen);
            }

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
            $query = DB::table('devoluciones');

            if ($request->filled('numero_documento')) {
                $query->where('numero_documento', 'like', "%{$request->numero_documento}%");
            }

            if ($request->filled('gestion')) {
                $query->where('gestion', $request->gestion);
            }

            if ($request->filled('estado') && $request->estado !== 'all') {
                $query->where('estado', $request->estado);
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
