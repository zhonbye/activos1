<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Categoria;
use App\Models\DetalleDevolucion;
use App\Models\DetalleInventario;
use App\Models\Devolucion;
use App\Models\Estado;
use App\Models\Inventario;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Traslado;
use App\Models\Unidad;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DevolucionController extends Controller
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
    public function create()
{
    // Obtener todos los servicios con su responsable (para mostrar en el select)
   $servicios = Servicio::with('responsable')
    ->whereRaw('LOWER(nombre_servicio) NOT LIKE ?', ['%activos fijos%'])
    ->get();

    // Determinar la gestión actual (sin Carbon)
    $gestionActual = date('Y');

    // Generar número de documento disponible
    $numeroDisponible = $this->generarNumeroDocumento($gestionActual);

    // Retornar vista con variables
    return view('user.devolucion.parcial_nuevo', compact('servicios', 'gestionActual', 'numeroDisponible'));
}
public function guardarDevolucion(Request $request, $id)
{
    $devolucion = Devolucion::find($id);

    if (!$devolucion) {
        return response()->json([
            'success' => false,
            'message' => 'Devolución no encontrada.'
        ], 404);
    }

    if ($devolucion->estado === 'finalizado') {
        return response()->json([
            'success' => false,
            'message' => 'Esta devolución ya fue finalizada.'
        ], 422);
    }

    // Buscar servicio destino (ACTIVOS FIJOS)
    $servicioDestino = Servicio::whereRaw('LOWER(nombre) = ?', ['activos fijos'])->first();

    if (!$servicioDestino) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró el servicio responsable de recepción: "ACTIVOS FIJOS".'
        ], 422);
    }

    // Inventario destino (ACTIVOS FIJOS)
    $inventarioDestino = Inventario::where('id_servicio', $servicioDestino->id_servicio)
        ->where('gestion', $devolucion->gestion)
        ->where('estado', 'vigente')
        ->orderBy('created_at', 'desc')
        ->first();

    if (!$inventarioDestino) {
        return response()->json([
            'success' => false,
            'message' => 'No existe inventario vigente en ACTIVOS FIJOS para la gestión actual.'
        ], 422);
    }

    // Inventario origen
    $inventarioOrigen = Inventario::where('id_servicio', $devolucion->id_servicio)
        ->where('gestion', $devolucion->gestion)
        ->where('estado', 'vigente')
        ->orderBy('created_at', 'desc')
        ->first();
// dd($devolucion->id_servicio);
    if (!$inventarioOrigen) {
        return response()->json([
            'success' => false,
            'message' => 'No existe inventario vigente para el servicio origen en la gestión actual.'
        ], 422);
    }

    // Obtener detalle de la devolución
   $detalles = DetalleDevolucion::with(['activo' => function($q) {
    $q->select('id_activo', 'codigo');
}])->where('id_devolucion', $id)->get();


    if ($detalles->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No hay activos registrados en esta devolución.'
        ], 422);
    }

    DB::beginTransaction();

    try {
        foreach ($detalles as $detalle) {
            $idActivo = $detalle->id_activo;

            // Obtener el activo desde origen
            $detalleOrigen = DetalleInventario::where('id_inventario', $inventarioOrigen->id_inventario)
                ->where('id_activo', $idActivo)
                ->first();

            if (!$detalleOrigen) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "El activo  {$detalle->activo->codigo} no se encuentra en el inventario de origen."
                ], 422);
            }

            // Guardar estado antes de mover
            $estadoAnterior = $detalleOrigen->estado_actual;

            // Eliminar del inventario de origen
            $detalleOrigen->delete();

            // Verificar si ya existe en destino
            $detalleDestino = DetalleInventario::where('id_inventario', $inventarioDestino->id_inventario)
                ->where('id_activo', $idActivo)
                ->first();

            if (!$detalleDestino) {
                DetalleInventario::create([
                    'id_inventario' => $inventarioDestino->id_inventario,
                    'id_activo' => $idActivo,
                    'estado_actual' => $estadoAnterior,
                    'observaciones' => $detalle->observaciones ?? '',
                ]);
            }
        }

        // Marcar devolución como finalizada
        $devolucion->estado = 'finalizado';
        $devolucion->updated_at = now();
        $devolucion->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Devolución procesada correctamente. Los activos fueron enviados a ACTIVOS FIJOS.',
            'data' => ['id_devolucion' => $devolucion->id_devolucion]
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error al procesar la devolución: ' . $e->getMessage()
        ], 500);
    }
}


public function limpiarActivos($id)
{
   try {
    $devolucion = Devolucion::find($id);

    if (!$devolucion) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró la devolucion especificado.'
        ]);
    }

    // Verificar si el devolucion está finalizado o eliminado
    if (in_array(strtolower($devolucion->estado), ['finalizado', 'eliminado'])) {
        return response()->json([
            'success' => false,
            'message' => 'No se pueden modificar los activos de esta devolucion porque está finalizado o eliminado.'
        ]);
    }

    // Obtener todos los detalles del devolucion
    $detalles = $devolucion->detalles()->get();

    if ($detalles->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No hay activos para eliminar en esta devolucion.'
        ]);
    }

    // Eliminar los detalles
    $deleted = 0;
    foreach ($detalles as $detalle) {
        $detalle->delete();
        $deleted++;
    }

    return response()->json([
        'success' => true,
        'message' => "Se eliminaron $deleted activos de la devolucion."
    ]);

} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Error al eliminar los activos: ' . $e->getMessage()
    ]);
}

}
public function mostrarInventario()
{
    try {
        // $servicios = Servicio::all(); // Ya no es necesario si solo hay un servicio
        $categorias = Categoria::all(); // Para llenar selects de categorías

        // Cambiamos la vista a la carpeta de devolucion
        return view('user.devolucion.parcial_inventario', compact('categorias'));
    } catch (\Exception $e) {
        // Opcional: loguear el error
        // \Log::error('Error al cargar parcial de inventario de devolucion: '.$e->getMessage());

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al cargar la vista de inventario de devoluciones.'
            ], 500);
        }

        return view('user.devolucion.parcial_inventario')->with([
            'message' => 'Ocurrió un error al cargar la vista de inventario de devoluciones.'
        ]);
    }
}


public function buscar(Request $request)
{
    try {
        $query = Devolucion::query()->noEliminados();

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

        if ($request->id_servicio) {
            $query->where('id_servicio', $request->id_servicio);
        }

        $devoluciones = $query->orderBy('fecha', 'desc')->get();

        return view('user.devolucion.parcial_resultados_busqueda', compact('devoluciones'));
    } catch (\Exception $e) {
        // \Log::error('Error en búsqueda de devoluciones: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al buscar las devoluciones. ' . $e
        ], 500);
    }
}






 public function buscarActivos(Request $request)
{
    try {
        // 🔹 Consulta base: Inventarios del servicio seleccionado
        $inventariosQuery = Inventario::query();

        if ($request->filled('id_servicio')) {
            $inventariosQuery->where('id_servicio', $request->id_servicio);
        }

        $inventarios = $inventariosQuery->pluck('id_inventario');

        // 🔹 Base de detalle de inventarios con relaciones
        $detalleQuery = DetalleInventario::with(['activo', 'inventario'])
            ->whereIn('id_inventario', $inventarios)
            // ->where('estado_actual', '!=', 'eliminado')
            ->whereHas('activo', function ($q) {
                $q->soloActivos();
            });

        // 🔹 Filtros opcionales
        if ($request->filled('codigo_activo')) {
            $codigo = strtolower($request->codigo_activo);
            $detalleQuery->whereHas('activo', function ($q) use ($codigo) {
                $q->soloActivos()
                    ->whereRaw('LOWER(codigo) LIKE ?', ["%{$codigo}%"]);
            });
        }

        if ($request->filled('nombre_activo')) {
            $nombre = strtolower($request->nombre_activo);
            $detalleQuery->whereHas('activo', function ($q) use ($nombre) {
                $q->soloActivos()
                    ->whereRaw('LOWER(nombre) LIKE ?', ["%{$nombre}%"]);
            });
        }

        if ($request->filled('categoria_activo')) {
            $categoria = strtolower($request->categoria_activo);
            $detalleQuery->whereHas('activo.categoria', function ($q) use ($categoria) {
                $q->whereRaw('LOWER(id_categoria) LIKE ?', ["%{$categoria}%"]);
            });
        }

        // 🔹 Obtener resultados
        $detalles = $detalleQuery->get();
        $idDevolucionActual = $request->id_devolucion ?? null;

         foreach ($detalles as $detalle) {
                $idActivo = $detalle->activo->id_activo ?? null;
                // 🔹 Obtener IDs y número_documento de las actas donde aparece este activo
                $actas = DetalleDevolucion::where('id_activo', $idActivo)
                    ->join('devoluciones as t', 't.id_devolucion', '=', 'detalle_devoluciones.id_devolucion')
                    ->where('t.estado', 'pendiente')   // 🔹 solo devoluciones pendientes
                    ->select('detalle_devoluciones.id_devolucion', 't.numero_documento')
                    ->distinct()
                    ->get()
                    ->map(function ($a) {
                        return [
                            'id_devolucion' => $a->id_devolucion,
                            'numero_documento' => $a->numero_documento,
                        ];
                    })
                    ->values()
                    ->toArray();


                // 🔹 Determinar si este activo está en el TRASLADO actual
                $enTrasladoActual = $idDevolucionActual
                    ? collect($actas)->contains('id_devolucion', $idDevolucionActual)
                    : false;

                // 🔹 Determinar si está en OTROS devoluciones distintos
                $enOtrosTraslados = $idDevolucionActual
                    ? collect($actas)->where('id_devolucion', '!=', $idDevolucionActual)->isNotEmpty()
                    : collect($actas)->isNotEmpty();
                // dd($idDevolucionActual ." y ". $enTrasladoActual );

                // ✅ Guardar variables con los nombres que usa tu vista Blade
                $detalle->setAttribute('en_devolucion_actual', $enTrasladoActual);
                $detalle->setAttribute('en_otras_devoluciones', $enOtrosTraslados);
                $detalle->setAttribute('actas_info', $actas);
                $detalle->setAttribute('id_devolucion_actual', $idDevolucionActual);
            }
        return view('user.devolucion.parcial_resultados_inventario', compact('detalles'));

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al buscar en el inventario: ' . $e->getMessage()
        ], 500);
    }
}















public function generarNumeroDocumento(string $gestion): string
{
    $maxNumero = 999;

    $numerosExistentes = Devolucion::where('gestion', $gestion)
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







    public function detalleParcialDevolucion($id)
    {
        $devolucion = Devolucion::with([
            'responsable', // persona responsable
            'servicio'     // servicio asociado
        ])->findOrFail($id);

        return view('user.devolucion.parcial_devolucion', compact('devolucion'));
    }


// public function mostrarBuscar()
//     {
//         try {
//             $servicios = Servicio::all(); // Para llenar los selects
//             return view('user.devolucions.parcial_buscar', compact('servicios'));
//         } catch (\Exception $e) {
//             // Opcional: loguear el error
//             // \Log::error('Error al cargar parcial de búsqueda: '.$e->getMessage());

//             // Si quieres devolver JSON (para AJAX)
//             if (request()->ajax()) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
//                 ], 500);
//             }

//             // Para petición normal, devolver vista con mensaje de error
//             return view('user.devolucions.parcial_buscar')->with(['message' => 'Ocurrió un error al cargar la vista de búsqueda.']);
//         }
//     }
    public function mostrarBuscarActa()
    {
        try {
            // Carga los datos necesarios para los selects
            $categorias = Categoria::all();
            $unidades = Unidad::all();
            $estados = Estado::all();
            $servicios = Servicio::all(); // Para llenar los selects

            // Retorna la vista con los datos
            return view('user.devolucion.parcial_buscarActa', compact('categorias', 'unidades', 'estados','servicios'));

        } catch (\Exception $e) {
            // \Log::error('Error al cargar parcial de búsqueda devoluciones: '.$e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
                ], 500);
            }

            return view('user.devolucion.parcial_buscarActa')->with('message', 'Ocurrió un error al cargar la vista de búsqueda.');
        }
    }


public function eliminarActivo(Request $request, $id)
{
    try {
        // 1️⃣ Verificar que la devolución exista
        $devolucion = Devolucion::findOrFail($id);

        if (!$devolucion->isEditable()) {
            return response()->json([
                'success' => false,
                'error' => 'No se puede eliminar activos de una devolución FINALIZADA o ELIMINADA.'
            ], 422);
        }

        // 2️⃣ Buscar el detalle de la devolución (activo específico)
        $detalle = DetalleDevolucion::where('id_devolucion', $id)
            ->where('id_activo', $request->id_activo)
            ->first();

        if (!$detalle) {
            return response()->json([
                'success' => false,
                'error' => 'El activo no se encuentra en esta devolución.'
            ], 404);
        }

        // Guardar la cantidad antes de eliminar
        $cantidadEliminada = $detalle->cantidad;

        // 3️⃣ Eliminar el detalle
        $detalle->delete();

        // 4️⃣ Respuesta exitosa con cantidad eliminada
        return response()->json([
            'success' => true,
            'message' => 'Activo eliminado correctamente de la devolución.',
            'cantidad_eliminada' => $cantidadEliminada
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'error' => 'Devolución no encontrada.'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Ocurrió un error inesperado: ' . $e->getMessage()
        ], 500);
    }
}


public function agregarActivo(Request $request, $id)
{
    try {
        // 1️⃣ Verificar devolución
        $devolucion = Devolucion::findOrFail($id);
        if (!$devolucion->isEditable()) {
            return response()->json([
                'success' => false,
                'error' => 'No se puede modificar esta devolución (FINALIZADA o ELIMINADA).'
            ], 422);
        }

        // 2️⃣ Buscar el activo
        $activo = Activo::activos()->findOrFail($request->id_activo);

        // 3️⃣ Buscar detalle inventario
        $detalleInventario = DetalleInventario::where('id_activo', $activo->id_activo)
            // ->where('estado_actual', '!=', 'eliminado')
            ->first();

        if (!$detalleInventario) {
            return response()->json([
                'success' => false,
                'error' => 'No se encontró el detalle de inventario para este activo.'
            ], 404);
        }

        // 4️⃣ Evitar duplicados
        if (DetalleDevolucion::where('id_devolucion', $id)->where('id_activo', $activo->id_activo)->exists()) {
            return response()->json([
                'success' => false,
                'error' => 'El activo ya fue agregado a esta devolución.'
            ], 422);
        }

      
        // 8️⃣ Crear el detalle con la cantidad solicitada
        $detalle = DetalleDevolucion::create([
            'id_devolucion' => $id,
            'id_activo' => $activo->id_activo,
            'observaciones' => $request->observaciones ?? ''
        ]);

        return response()->json([
            'success' => true,
            'detalle' => $detalle,
            'activo' => $activo,
            'message' => "Activo agregado correctamente."
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'error' => 'Devolución o activo no encontrado.'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Ocurrió un error inesperado: ' . $e->getMessage()
        ], 500);
    }
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🧩 Reglas de validación
        $rules = [
            'numero_documento' => ['required', 'regex:/^\d+$/', 'max:3'],
            'gestion' => ['required', 'digits:4'],
            'fecha' => 'required|date|after_or_equal:' . $request->gestion . '-01-01|before_or_equal:' . $request->gestion . '-12-31',
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'observaciones' => 'nullable|string|max:100',
        ];

        $messages = [
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.regex' => 'El número de documento solo puede contener números.',
            'numero_documento.max' => 'El número de documento no puede superar 3 dígitos.',
            'gestion.required' => 'La gestión es obligatoria.',
            'gestion.digits' => 'La gestión debe tener exactamente 4 dígitos.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior al año de la gestión.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior al año de la gestión.',
            'id_servicio.required' => 'Debe seleccionar un servicio.',
            'id_servicio.exists' => 'El servicio seleccionado no es válido.',
            'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
        ];

        // 🔍 Validar datos
        $validator = Validator::make($request->all(), $rules, $messages);

        // 🔢 Formatear número y gestión
        $numero = str_pad((int) $request->numero_documento, 3, '0', STR_PAD_LEFT);
        $gestion = (int) $request->gestion;

        // 🚫 Verificar si ya existe una devolución con ese número y gestión
        $existe = Devolucion::where('numero_documento', $numero)
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

        // 🧭 Obtener responsable del servicio seleccionado
        $servicio = Servicio::with('responsable')->find($request->id_servicio);
        $id_responsable = $servicio->responsable->id_responsable ?? null;



        
        // ✅ Crear la devolución
        $devolucion = Devolucion::create([
            'numero_documento' => $numero,
            'gestion' => $gestion,
            'fecha' => $request->fecha,
            'id_usuario' => auth()->id(),
            'id_servicio' => $request->id_servicio,
            'id_responsable' => $id_responsable,
            'observaciones' => $request->observaciones,
            'estado' => 'pendiente',
        ]);
        $siguienteNumero = $this->generarNumeroDocumento($gestion);
    $siguienteNumero = str_pad((int) $siguienteNumero, 3, '0', STR_PAD_LEFT);

return response()->json([
    'success' => true,
    'message' => 'Nueva Devolución registrada correctamente.',
    'data' => $devolucion,
    'siguiente_numero' => $siguienteNumero,
        ]);
    }

public function editarActivo(Request $request, $id)
{
    // Buscar el detalle de la devolución correspondiente al activo
    $detalle = DetalleDevolucion::where('id_devolucion', $id)
        ->where('id_activo', $request->id_activo)
        ->first();

    if (!$detalle) {
        return response()->json(['error' => 'Detalle no encontrado'], 404);
    }

    // Validar longitud de observaciones
    if ($request->observaciones !== null) {
        if (strlen($request->observaciones) > 100) {
            return response()->json([
                'error' => 'El campo observaciones no puede tener más de 100 caracteres'
            ], 422);
        }
        $detalle->observaciones = $request->observaciones;
    }

    // Actualizar cantidad si se envió
    if ($request->cantidad !== null) {
        $detalle->cantidad = $request->cantidad;
    }

    $detalle->save();

    return response()->json(['success' => true, 'detalle' => $detalle]);
}

    /**
     * Display the specified resource.
     */
    public function show($id = null)
{
    $categorias = Categoria::all();
    $unidades = Unidad::all();
    $estados = Estado::all();
    $servicios = Servicio::whereRaw('LOWER(nombre) NOT LIKE ?', ['%activos fijos%'])->get();

    // Determinar la gestión actual
    $gestionActual = date('Y');

    // Generar número de documento disponible
    $numeroDisponible = $this->generarNumeroDocumento($gestionActual);

    if ($id) {
        $devolucion = Devolucion::find($id); // find en vez de findOrFail
    } else {
        $devolucion = Devolucion::latest('id_devolucion')->first();
    }

    // Si no hay devoluciones, crear un objeto vacío con relaciones vacías
    if (!$devolucion) {
        $devolucion = new Devolucion([
            'id_devolucion' => '',
            'fecha' => '',
            'observaciones' => '',
            'id_servicio' => '',
            'id_usuario' => '',
            'id_responsable' => '',
        ]);

        // Relaciones vacías
        $devolucion->setRelation('sUsuario', new Usuario(['usuario' => '']));
        $devolucion->setRelation('servicio', new Servicio(['nombre' => '']));
        $devolucion->setRelation('responsable', new Responsable(['nombre' => '']));
    }

    return view(
        'user.devolucion.show',
        compact(
            'devolucion', 
            'gestionActual', 
            'numeroDisponible', 
            'categorias', 
            'unidades', 
            'estados', 
            'servicios'
        )
    );
}


    public function tablaActivos($id)
    {
        $detalles = DetalleDevolucion::with('activo.unidad', 'activo.estado')
            ->where('id_devolucion', $id)
            ->get()
            ->map(function ($detalle) {
                // Obtener solo datos generales del activo
                $activo = $detalle->activo;

                $detalle->setAttribute('codigo', $activo->codigo ?? '');
                $detalle->setAttribute('nombre', $activo->nombre ?? '');
                $detalle->setAttribute('detalle', $activo->detalle ?? '');
                $detalle->setAttribute('estado', $activo->estado->nombre ?? 'N/D');
                $detalle->setAttribute('unidad', $activo->unidad->nombre ?? '');

                // Opcional: actas en general, si quieres mostrar en botones
                $detalle->setAttribute('actas_info', DetalleDevolucion::where('id_activo', $detalle->id_activo)
                    ->with('devolucion')
                    ->get()
                    ->map(function ($d) {
                        return [
                            'id_devolucion' => $d->id_devolucion,
                            'numero_documento' => $d->devolucion->numero_documento ?? null,
                        ];
                    }));

                return $detalle;
            });
        return view('user.devolucion.parcial_activos', compact('detalles'));
    }

    



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











    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    // Traer la devolución y relaciones necesarias
    $devolucion = Devolucion::with([
        'responsable',
        'servicio'
    ])->findOrFail($id);

    // Datos para selects
    $usuarios = Usuario::all();       // Para responsables
     $servicios = Servicio::whereRaw('LOWER(nombre) NOT LIKE ?', ['%activos fijos%'])->get();
     // Para servicios
    $responsables = Responsable::all(); // Para selects de responsables si aplica

    return view('user.devolucion.parcial_editar', compact('devolucion', 'usuarios', 'servicios', 'responsables'));
}



    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    try {
        $devolucion = Devolucion::editable()->find($id);

        if (!$devolucion) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede modificar esta acta: está finalizada o eliminada.'
            ], 403);
        }

        $rules = [
            'numero_documento' => [
                'required',
                'regex:/^\d{1,20}$/',
                // Único por gestión, excluyendo el registro actual
                'unique:devoluciones,numero_documento,' . $id . ',id_devolucion,gestion,' . $request->gestion
            ],
            'gestion' => 'required|digits:4|integer',
            'fecha' => 'required|date|after_or_equal:' . $request->gestion . '-01-01|before_or_equal:' . $request->gestion . '-12-31',
            'observaciones' => 'nullable|string|max:100',
            'id_servicio' => 'required|exists:servicios,id_servicio',
        ];

        $messages = [
            'numero_documento.required' => 'El número de devolución es obligatorio.',
            'numero_documento.regex' => 'El número de devolución debe contener solo números.',
            'numero_documento.unique' => 'El número de documento ya existe para esta gestión.',
            'gestion.required' => 'La gestión es obligatoria.',
            'gestion.digits' => 'La gestión debe tener 4 dígitos.',
            'fecha.required' => 'Debe indicar una fecha.',
            'fecha.date' => 'La fecha no es válida.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior al año de la gestión.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior al año de la gestión.',
            'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
            'id_servicio.required' => 'Debe seleccionar un servicio.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Existen errores en el formulario.',
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ Actualizar datos
        $devolucion->update([
            'numero_documento' => str_pad((int)$request->numero_documento, 3, '0', STR_PAD_LEFT),
            'gestion' => (int)$request->gestion,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones ?? '',
            'id_servicio' => $request->id_servicio,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'La devolución ha sido actualizada correctamente.',
            'devolucion' => $devolucion
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
    public function destroy(Devolucion $devolucion)
    {
        //
    }
}
