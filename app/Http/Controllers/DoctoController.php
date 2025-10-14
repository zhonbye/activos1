<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Docto;
use App\Models\Usuario;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DoctoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function buscarDocto($numero, $gestion)
{
    $acta = Docto::where('numero', $numero)
        ->where('gestion', $gestion)
        ->first();

    if (!$acta) {
        return response()->json(['success' => false, 'message' => 'Acta no encontrada.']);
    }

    return response()->json([
        'success' => true,
        'acta' => [
            'id' => $acta->id_docto,
            'numero' => $acta->numero,
            'gestion' => $acta->gestion,
            'tipo' => $acta->tipo,
            'fecha' => $acta->fecha,
            'detalle' => $acta->detalle,
        ]
    ]);
}

    public function create()
    {
        $ultimo = Docto::orderBy('id_docto', 'desc')->first();
        $numeroSiguiente = $ultimo ? str_pad($ultimo->numero + 1, 3, '0', STR_PAD_LEFT) : '001';
    //     $gestion = date('Y'); // o la gestión que quieras por defecto
    // $numeroSiguiente = $this->obtenerSiguienteNumero($gestion);


        return view('user.actas.registrar', [
            'numeroSiguiente' => $numeroSiguiente,
            'ubicaciones' => Ubicacion::all(),
            'responsables' => Responsable::all(),
            'servicios' => Servicio::all(),
        ]);
    }


        // $responsables = Responsable::all();
        // $usuarios = Usuario::all();
        // $ubicaciones = Ubicacion::all();
        // return view('user.actas.registrar',compact('responsables','usuarios','ubicaciones'));


    /**
     * Store a newly created resource in storage.
     */
    public function ultimodocto($gestion)
{
    $ultimo = Docto::where('gestion', $gestion)->orderBy('id_docto', 'desc')->first();

    // $siguienteNumero = $ultimo ? (int)$ultimo->numero + 1 : 1;
    if (!$ultimo) {
        $numeroFormateado = '001';
    } else {
        $siguienteNumero = (int)$ultimo->numero + 1;
        $numeroFormateado = str_pad($siguienteNumero, 3, '0', STR_PAD_LEFT);
    }

    return response()->json([
        'success' => true,
        'numero' => $numeroFormateado
    ]);
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero' => [
                'required',
                'regex:/^\d+$/',
                Rule::unique('doctos')->where(function ($query) use ($request) {
                    return $query->where('gestion', $request->gestion);
                }),
            ],
            'gestion' => 'required|integer',
            'fecha' => 'required|date',
            'tipo' => 'required|in:ENTREGA,DEVOLUCIÓN,TRASLADO,INVENTARIO',
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'id_responsable' => 'required|exists:responsables,id_responsable',
            'detalle' => 'nullable|string|max:200',
        ], [
            'numero.required' => 'El número es obligatorio.',
            'numero.regex' => 'El número solo debe contener dígitos (sin letras ni símbolos).',
            'numero.unique' => 'Ya existe un documento con ese número en la misma gestión.',
            'gestion.required' => 'La gestión es obligatoria.',
            'gestion.integer' => 'La gestión debe ser un entero.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'tipo.required' => 'El tipo es obligatorio.',
            'tipo.in' => 'El tipo seleccionado no es válido.',
            'id_servicio.required' => 'Debe seleccionar un servicio.',
            'id_servicio.exists' => 'El servicio seleccionado no existe.',
            'id_responsable.required' => 'Debe seleccionar un responsable.',
            'id_responsable.exists' => 'El responsable seleccionado no existe.',
            'detalle.string' => 'El detalle debe ser texto.',
            'detalle.max' => 'El detalle no puede exceder 200 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Errores de validación en los campos.'
            ], 422);
        }

        try {
            $validated = $validator->validated();
            // dd($validated);

            $docto = Docto::create([
                'numero' => $validated['numero'],
                'gestion' => $validated['gestion'],
                'fecha' => $validated['fecha'],
                'tipo' => $validated['tipo'],
                'id_usuario' => auth()->id(),  // usuario autenticado
                'id_servicio' => $validated['id_servicio'],
                'id_responsable' => $validated['id_responsable'],
                'detalle' => $validated['detalle'] ?? null,
            ]);


            $ultimo = Docto::where('gestion', $validated['gestion'])
    ->orderBy('id_docto', 'desc')
    ->first();

$numeroSiguiente = $ultimo ? str_pad((int)$ultimo->numero + 1, 3, '0', STR_PAD_LEFT) : '001';

            return response()->json([
                'success' => true,
                'message' => 'Acta creada correctamente.',
                'numeroSiguiente' => $numeroSiguiente,
                'id_docto' => $docto->id_docto
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear acta: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Docto $docto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Docto $docto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docto $docto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docto $docto)
    {
        //
    }
}
