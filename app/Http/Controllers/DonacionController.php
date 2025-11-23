<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use Illuminate\Http\Request;

class DonacionController extends Controller
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
        $idDonante = $request->input('donante_id');
        $codigo = $request->input('codigo');
        $nombre = $request->input('nombre');
        $fecha = $request->input('fecha');

        // Empezamos la consulta en la tabla donaciones
        $query = Donacion::query()
            ->join('adquisiciones', 'donaciones.id_adquisicion', '=', 'adquisiciones.id_adquisicion')
            ->join('activos', 'adquisiciones.id_adquisicion', '=', 'activos.id_adquisicion')
            ->select(
                'donaciones.*',
                'adquisiciones.fecha',
                'adquisiciones.id_adquisicion',
                'activos.id_activo',
                'activos.codigo',
                'activos.nombre',
                'activos.detalle',
                'activos.estado_situacional'
            );
// dd($query->first());

        // Filtrar por donante
        if ($idDonante) {
            $query->where('donaciones.id_donante', $idDonante);
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
        $donaciones = $query->orderBy('donaciones.id_adquisicion', 'desc')->paginate(10);

        // Retornamos la vista parcial
        return view('user.donantes.parcial_donaciones', compact('donaciones'));
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
    public function show(Donacion $donacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donacion $donacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donacion $donacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donacion $donacion)
    {
        //
    }
}
