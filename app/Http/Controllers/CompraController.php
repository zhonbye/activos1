<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function filtrar(Request $request)
    {
        // Recibimos los filtros
        $idProveedor = $request->input('proveedor_id');
        $codigo      = $request->input('codigo');
        $nombre      = $request->input('nombre');
        $fecha       = $request->input('fecha');

        // Empezamos la consulta en la tabla compras
        $query = Compra::query()
            ->join('adquisiciones', 'compras.id_adquisicion', '=', 'adquisiciones.id_adquisicion')
            ->join('activos', 'adquisiciones.id_adquisicion', '=', 'activos.id_adquisicion')
            ->select(
                'compras.*',
                'adquisiciones.fecha',
                'adquisiciones.id_adquisicion',
                'activos.id_activo',
                'activos.codigo',
                'activos.nombre',
                'activos.detalle',
                'activos.estado_situacional'
            );

        // Filtrar por proveedor
        if ($idProveedor) {
            $query->where('compras.id_proveedor', $idProveedor);
        }

        // Filtrar por código del activo
        if ($codigo) {
            $query->where('activos.codigo', 'like', "%$codigo%");
        }

        // Filtrar por nombre del activo
        if ($nombre) {
            $query->where('activos.nombre', 'like', "%$nombre%");
        }

        // Filtrar por fecha de adquisición
        if ($fecha) {
            $query->where('adquisiciones.fecha', $fecha);
        }

        // Orden y paginación
        $compras = $query->orderBy('compras.id_adquisicion', 'desc')->paginate(10);

        // Retornamos la vista parcial
        return view('user.proveedores.parcial_compras', compact('compras'));
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
    public function show(Compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compra $compra)
    {
        //
    }
}
