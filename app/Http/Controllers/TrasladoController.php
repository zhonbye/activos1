<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\DetalleTraslado;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Traslado;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function prueba()
    {

        // Retornar vista con variables
        return view('user.prueba');
    }
    public function create()
    {
        $servicios = Servicio::all(); // para llenar selects

        // Determinar la gestión actual (sin Carbon, con PHP puro)
        $gestionActual = date('Y');

        // Generar número de documento disponible
        $numeroDisponible = $this->generarNumeroDocumento($gestionActual);

        // Retornar vista con variables
        return view('user.traslados.parcial_nuevo', compact('servicios', 'gestionActual', 'numeroDisponible'));
    }
    public function buscar(Request $request)
    {
        try {
            $query = Traslado::query()->noEliminados();

            // Búsqueda insensible a mayúsculas/minúsculas
            if ($request->numero_documento) {
                $numero = $request->numero_documento;
                $query->whereRaw('LOWER(numero_documento) LIKE ?', ['%' . strtolower($numero) . '%']);
            }

            if ($request->gestion) {
                $query->where('gestion', $request->gestion);
            }

            if ($request->fecha_desde) {
                $query->whereDate('fecha', '>=', $request->fecha_desde);
            }

            if ($request->fecha_hasta) {
                $query->whereDate('fecha', '<=', $request->fecha_hasta);
            }

            if ($request->id_servicio_origen) {
                $query->where('id_servicio_origen', $request->id_servicio_origen);
            }

            if ($request->id_servicio_destino) {
                $query->where('id_servicio_destino', $request->id_servicio_destino);
            }

            $traslados = $query->orderBy('fecha', 'desc')->get();

            return view('user.traslados.parcial_resultados_busqueda', compact('traslados'));
        } catch (\Exception $e) {
            // \Log::error('Error en búsqueda de traslados: '.$e-_>getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar los traslados.' . $e
            ], 500);
        }
    }







    public function mostrarBuscar()
    {
        try {
            $servicios = Servicio::all(); // Para llenar los selects
            return view('user.traslados.parcial_buscar', compact('servicios'));
        } catch (\Exception $e) {
            // Opcional: loguear el error
            // \Log::error('Error al cargar parcial de búsqueda: '.$e->getMessage());

            // Si quieres devolver JSON (para AJAX)
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
                ], 500);
            }

            // Para petición normal, devolver vista con mensaje de error
            return view('user.traslados.parcial_buscar')->with(['message' => 'Ocurrió un error al cargar la vista de búsqueda.']);
        }
    }
        public function mostrarInventario()
    {
        try {
            $servicios = Servicio::all(); // Para llenar los selects
            return view('user.traslados.parcial_buscar', compact('servicios'));
        } catch (\Exception $e) {
            // Opcional: loguear el error
            // \Log::error('Error al cargar parcial de búsqueda: '.$e->getMessage());

            // Si quieres devolver JSON (para AJAX)
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
                ], 500);
            }

            // Para petición normal, devolver vista con mensaje de error
            return view('user.traslados.parcial_buscar')->with(['message' => 'Ocurrió un error al cargar la vista de búsqueda.']);
        }
    }




// use Illuminate\Database\QueryException;

public function store(Request $request)
{
    $rules = [
        'numero_documento' => ['required', 'regex:/^\d+$/', 'max:3'],
        'gestion' => ['required', 'digits:4'],
        'fecha' => 'required|date',
        'id_servicio_origen' => 'required|exists:servicios,id_servicio',
        'id_servicio_destino' => 'required|exists:servicios,id_servicio|different:id_servicio_origen',
        'observaciones' => 'nullable|string|max:100',
    ];

    $messages = [
        'numero_documento.required' => 'El número de documento es obligatorio.',
        'numero_documento.regex' => 'El número de documento solo puede contener números.',
        'numero_documento.max' => 'El número de documento no puede superar 3 dígitos.',
        'gestion.required' => 'La gestión es obligatoria.',
        'gestion.digits' => 'La gestión debe tener exactamente 4 dígitos.',
        'fecha.required' => 'La fecha es obligatoria.',
        'id_servicio_origen.required' => 'Debe seleccionar un servicio de origen.',
        'id_servicio_destino.required' => 'Debe seleccionar un servicio de destino.',
        'id_servicio_destino.different' => 'El servicio destino no puede ser igual al origen.',
        'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    // 🔢 Formatear número y gestión
    $numero = str_pad((int) $request->numero_documento, 3, '0', STR_PAD_LEFT);
    $gestion = (int) $request->gestion;

    // 🚫 Verificar si ya existe ese número y gestión
    $existe = Traslado::where('numero_documento', $numero)
        ->where('gestion', $gestion)
        ->where('estado', '!=', 'ELIMINADO')
        ->exists();

    if ($existe) {
        $validator->errors()->add('numero_documento', 'El número de documento ya existe para esta gestión.');
    }

    // ❌ Si hay errores, retornar sin guardar
    if ($validator->fails() || $existe) {
        return response()->json([
            'success' => false,
            'message' => $existe
                ? 'No se puede registrar: el número de documento ya existe para esta gestión.'
                : 'Existen errores en el formulario.',
            'errors' => $validator->errors(),
        ], 422);
    }

    // ✅ Si pasó todas las validaciones, guardar
    $traslado = Traslado::create([
        'numero_documento' => $numero,
        'gestion' => $gestion,
        'fecha' => $request->fecha,
        'id_usuario' => auth()->id(),
        'id_servicio_origen' => $request->id_servicio_origen,
        'id_servicio_destino' => $request->id_servicio_destino,
        'observaciones' => $request->observaciones,
        'estado' => 'activo',
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Traslado guardado correctamente.',
        'data' => $traslado,
    ]);
}









    // public function store(Request $request)
    // {
    //     try {
    //         // 1️⃣ Reglas y mensajes
    //         $rules = [
    //             'numero_documento' => ['required', 'regex:/^\d+$/', 'max:3'],
    //             'gestion' => 'required|numeric',
    //             'fecha' => 'required|date',
    //             'id_servicio_origen' => 'required|exists:servicios,id_servicio',
    //             'id_servicio_destino' => 'required|exists:servicios,id_servicio',
    //             'observaciones' => 'nullable|string|max:100',
    //         ];

    //         $messages = [
    //             'numero_documento.required' => 'El número de documento es obligatorio.',
    //             'numero_documento.regex' => 'El número de documento solo puede contener números.',
    //             'numero_documento.max' => 'El número de documento no puede superar 3 dígitos.',
    //             'gestion.required' => 'La gestión es obligatoria.',
    //             'fecha.required' => 'La fecha es obligatoria.',
    //             'id_servicio_origen.required' => 'Debe seleccionar un servicio de origen.',
    //             'id_servicio_destino.required' => 'Debe seleccionar un servicio de destino.',
    //             'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
    //         ];

    //         $validator = Validator::make($request->all(), $rules, $messages);

    //         // Verificar número de documento único por gestión (solo registros no eliminados)
    //         $numeroExiste = Traslado::where('numero_documento', $request->numero_documento)
    //             ->where('gestion', $request->gestion)
    //             ->where('estado', '!=', 'ELIMINADO')
    //             ->exists();

    //         if ($numeroExiste) {
    //             $validator->errors()->add('numero_documento', 'El número de documento ya existe para esta gestión.');
    //         }

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $validator->errors()->first() // solo primer mensaje
    //             ], 422);
    //         }

    //         // Verificar que origen y destino no sean iguales
    //         if ($request->id_servicio_origen == $request->id_servicio_destino) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'El servicio de origen y destino no pueden ser iguales.'
    //             ], 422);
    //         }

    //         // Guardar traslado
    //         $traslado = Traslado::create([
    //             'numero_documento' => $request->numero_documento,
    //             'gestion' => $request->gestion,
    //             'fecha' => $request->fecha,
    //             'id_usuario' => auth()->id(),
    //             'id_servicio_origen' => $request->id_servicio_origen,
    //             'id_servicio_destino' => $request->id_servicio_destino,
    //             'observaciones' => $request->observaciones,
    //             'estado' => 'ACTIVO',
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Traslado guardado correctamente.',
    //             'data' => $traslado
    //         ]);
    //     } catch (\Exception $e) {
    //         // Captura cualquier error y devuelve solo el mensaje
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Ocurrió un error: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }


public function generarNumeroAjax($gestion)
{
    try {
        $numero = $this->generarNumeroDocumento($gestion);
        return response()->json([
            'success' => true,
            'numero' => $numero
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 400);
    }
}

    public function generarNumeroDocumento(string $gestion): string
{
    $maxNumero = 999;

    $numerosExistentes = Traslado::where('gestion', $gestion)
        ->where('estado', '!=', 'ELIMINADO')
        ->pluck('numero_documento')
        ->toArray();

    // Asegurarse que no haya espacios
    $numerosExistentesSet = array_flip(array_map('trim', $numerosExistentes));

    for ($i = 1; $i <= $maxNumero; $i++) {
        $numeroFormateado = str_pad($i, 3, '0', STR_PAD_LEFT);
        if (!isset($numerosExistentesSet[$numeroFormateado])) {
            return $numeroFormateado;
        }
    }

    throw new \Exception('No hay números disponibles para la gestión ' . $gestion);
}


    public function show($id)
    {
        $traslado = Traslado::findOrFail($id);
        return view('user.traslados.show', compact('traslado'));
    }
    public function detalleParcial($id)
    {
        $traslado = Traslado::with([
            'responsableOrigen',      // Responsable del servicio de origen
            'responsableDestino',     // Responsable del servicio de destino
            'servicioOrigen',         // Servicio de origen
            'servicioDestino',        // Servicio de destino
            // 'detalles.activo'         // Los activos del traslado
        ])->findOrFail($id);

        return view('user.traslados.parcial_traslado', compact('traslado'));
    }

    // Vista parcial de tabla de activos
    public function tablaActivos($id)
    {
        $detalles = DetalleTraslado::with('activo.unidad', 'activo.estado')
            ->where('id_traslado', $id)->get();
        return view('user.traslados.parcial_activos', compact('detalles'));
    }

    // Agregar activo al traslado
    public function agregarActivo(Request $request, $id)
    {
        try {
            // Traer traslado y verificar si está editable
            $traslado = Traslado::findOrFail($id);
            if (!$traslado->isEditable()) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se puede modificar este traslado (FINALIZADO o ELIMINADO).'
                ], 422);
            }

            // Buscar el activo y asegurarse de que esté activo
            $activo = Activo::activos()->findOrFail($request->id_activo);

            // Evitar duplicados en el traslado
            $existe = DetalleTraslado::where('id_traslado', $id)
                ->where('id_activo', $activo->id_activo)
                ->first();
            if ($existe) {
                return response()->json([
                    'success' => false,
                    'error' => 'Activo ya agregado '
                ], 422);
            }

            // Crear el detalle del traslado
            $detalle = DetalleTraslado::create([
                'id_traslado' => $id,
                'id_activo' => $activo->id_activo,
                'cantidad' => $request->cantidad ?? 1,
                'observaciones' => $request->observaciones ?? ''
            ]);

            return response()->json([
                'success' => true,
                'detalle' => $detalle,
                'activo' => $activo,
                'message' => 'Activo agregado correctamente.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Traslado o Activo no encontrado.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Ocurrió un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }

    // Editar cantidad u observaciones
    public function editarActivo(Request $request, $id)
    {
        $detalle = DetalleTraslado::where('id_traslado', $id)
            ->where('id_activo', $request->id_activo)
            ->first();
        if (!$detalle) return response()->json(['error' => 'Detalle no encontrado'], 404);

        if ($request->cantidad !== null) $detalle->cantidad = $request->cantidad;
        if ($request->observaciones !== null) $detalle->observaciones = $request->observaciones;
        $detalle->save();

        return response()->json(['success' => true, 'detalle' => $detalle]);
    }

    // Eliminar activo
    public function eliminarActivo(Request $request, $id)
    {
        $detalle = DetalleTraslado::where('id_traslado', $id)
            ->where('id_activo', $request->id_activo)
            ->first();
        if (!$detalle) return response()->json(['error' => 'Detalle no encontrado'], 404);

        $detalle->delete();
        return response()->json(['success' => true]);
    }
    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //   return view('user.traslados.registrar');
    // }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Traer el traslado y relaciones necesarias
        $traslado = Traslado::with([
            'responsableOrigen',
            'responsableDestino',
            'servicioOrigen',
            'servicioDestino'
        ])->findOrFail($id);

        // Datos para selects
        $usuarios = Usuario::all();       // Para responsables
        $servicios = Servicio::all();     // Para servicios
        $responsables = Responsable::all();     // Para servicios

        return view('user.traslados.parcial_editar', compact('traslado', 'usuarios', 'servicios', 'responsables'));
    }


    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    try {
        $traslado = Traslado::editable()->find($id);

        if (!$traslado) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede modificar este acta: está finalizada o eliminada.'
            ]);
        }

        $rules = [
            'numero_documento' => ['required', 'regex:/^\d{1,20}$/'],
            'gestion' => 'required|digits:4|integer',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string|max:100',
            'id_servicio_origen' => 'required|exists:servicios,id_servicio',
            'id_servicio_destino' => 'required|exists:servicios,id_servicio|different:id_servicio_origen',
        ];

        $messages = [
            'numero_documento.required' => 'El número de traslado es obligatorio.',
            'numero_documento.regex' => 'El número de traslado debe contener solo números.',
            'gestion.required' => 'La gestión es obligatoria.',
            'gestion.digits' => 'La gestión debe tener 4 dígitos.',
            'fecha.required' => 'Debe indicar una fecha.',
            'fecha.date' => 'La fecha no es válida.',
            'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
            'id_servicio_origen.required' => 'Debe seleccionar un servicio de origen.',
            'id_servicio_destino.required' => 'Debe seleccionar un servicio de destino.',
            'id_servicio_destino.different' => 'El servicio destino no puede ser igual al origen.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $numero = str_pad((int)$request->numero_documento, 3, '0', STR_PAD_LEFT);
        $gestion = (int)$request->gestion;

        $existe = Traslado::where('numero_documento', $numero)
            ->where('gestion', $gestion)
            ->where('estado', '!=', 'ELIMINADO')
            ->where('id_traslado', '!=', $id)
            ->exists();

        if ($existe) {
            $validator->errors()->add('numero_documento', 'El número de documento ya existe para esta gestión.');
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Existen errores en el formulario.',
                'errors' => $validator->errors()
            ], 422);
        }

        // 🚫 Si ya existe otro con mismo número/gestión, no actualizar
        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede actualizar: ya existe un traslado con este número y gestión.'
            ], 409);
        }

        // ✅ Actualizar datos
        $traslado->update([
            'numero_documento' => $numero,
            'gestion' => $gestion,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones ?? '',
            'id_servicio_origen' => $request->id_servicio_origen,
            'id_servicio_destino' => $request->id_servicio_destino,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'El traslado ha sido actualizado correctamente.',
            'traslado' => $traslado
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error inesperado al actualizar: ' . $e->getMessage()
        ], 500);
    }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Traslado $traslado)
    {
        //
    }
}
