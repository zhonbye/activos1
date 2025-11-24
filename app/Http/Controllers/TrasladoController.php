<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Categoria;
use App\Models\DetalleInventario;
use App\Models\DetalleTraslado;
use App\Models\Inventario;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Traslado;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // $servicios = Servicio::all(); // para llenar selects
 $servicios = Servicio::whereRaw('LOWER(nombre) NOT LIKE ?', ['%activos fijos%'])->get();

        // Determinar la gestión actual (sin Carbon, con PHP puro)
        $gestionActual = date('Y');

        // Generar número de documento disponible
        $numeroDisponible = $this->generarNumeroDocumento($gestionActual);

        // Retornar vista con variables
        return view('user.traslados.parcial_nuevo', compact('servicios', 'gestionActual', 'numeroDisponible'));
    }




 public function imprimir($id_traslado)
{
    $traslado = Traslado::with([
        'servicioOrigen',
        'servicioDestino',
        'responsableOrigen.cargo',
        'responsableDestino.cargo'
    ])->findOrFail($id_traslado);

    // Fecha literal
    $fecha_traslado_literal = $this->fechaLiteral($traslado->fecha);

    // Detalles
    $detalles = DetalleTraslado::with([
        'activo.unidad',
        'activo.estado',
    ])->where('id_traslado', $id_traslado)->get();

    // -----------------------------
    // RESPONSABLE ORIGEN
    // -----------------------------
    $responsableOrigen = null;
    if ($traslado->responsableOrigen) {
        $r = $traslado->responsableOrigen;
        if ($r->cargo) {
            $responsableOrigen = $r->cargo->abreviatura . ' ' . $r->nombre;
        }
    }

    // -----------------------------
    // RESPONSABLE DESTINO
    // -----------------------------
    $responsableDestino = null;
    if ($traslado->responsableDestino) {
        $r = $traslado->responsableDestino;
        if ($r->cargo) {
            $responsableDestino = $r->cargo->abreviatura . ' ' . $r->nombre;
        }
    }

    // -----------------------------
    // SERVICIO ORIGEN
    // -----------------------------
    $servicioOrigen = $traslado->servicioOrigen ? $traslado->servicioOrigen->nombre : null;

    // -----------------------------
    // SERVICIO DESTINO
    // -----------------------------
    $servicioDestino = $traslado->servicioDestino ? $traslado->servicioDestino->nombre : null;

    // Director, administrador, responsable de activos
    $responsables = $this->obtenerResponsables();

    return view('user.traslados.imprimir', compact(
        'traslado',
        'detalles',
        'fecha_traslado_literal',
        'responsableOrigen',
        'responsableDestino',
        'servicioOrigen',
        'servicioDestino',
        'responsables'
    ));
}








public function fechaLiteral($fecha) {
    if (!$fecha) return ''; // si está vacío

    $meses = [
        1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
        5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
        9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
    ];

    // Reemplazar guiones por barras
    $fecha = str_replace('-', '/', $fecha);
    $partes = explode('/', $fecha);

    // Validar que haya al menos 3 partes
    if (count($partes) != 3) return $fecha; // devuelve tal cual si no tiene 3 partes

    // Detectar formato
    if (strlen($partes[0]) == 4) {
        // yyyy/mm/dd
        $ano = $partes[0];
        $mes = (int)$partes[1];
        $dia = $partes[2];
    } elseif (strlen($partes[2]) == 4) {
        // dd/mm/yyyy
        $dia = $partes[0];
        $mes = (int)$partes[1];
        $ano = $partes[2];
    } else {
        // año en 2 dígitos
        $dia = $partes[0];
        $mes = (int)$partes[1];
        $ano = '20' . $partes[2];
    }

    // Validar que el mes exista
    $mes = $mes >=1 && $mes <=12 ? $mes : 1;

    return intval($dia) . ' de ' . $meses[$mes] . ' del ' . $ano;
}

public function obtenerResponsables() {
    $roles = ['Director', 'Administrador'];
    $personas = Responsable::with('cargo')->whereIn('rol', $roles)->get()->keyBy('rol');

    $director = $personas->has('Director') 
        ?  $personas['Director']->cargo->abreviatura.' '.$personas['Director']->nombre
        : null;

    $administrador = $personas->has('Administrador') 
        ? $personas['Administrador']->cargo->abreviatura.' '. $personas['Administrador']->nombre 
        : null;

    // Responsable de activos fijos
    $responsableActivos = null;
    $servicio_activos = Servicio::where('nombre', 'LIKE', '%Activos Fijos%')->first();
    if ($servicio_activos && $servicio_activos->id_responsable) {
        $res = Responsable::with('cargo')->find($servicio_activos->id_responsable);
        if ($res) {
            $responsableActivos = $res->nombre . ' (' . $res->cargo->nombre . ')';
        }
    }

    return compact('director', 'administrador', 'responsableActivos');
}


    public function guardarTraslado(Request $request, $id)
    {
        $traslado = Traslado::find($id);

        if (!$traslado) {
            return response()->json([
                'success' => false,
                'message' => 'Traslado no encontrado.'
            ], 404);
        }

        // Evitar volver a finalizar un traslado ya cerrado
        if ($traslado->estado === 'finalizado') {
            return response()->json([
                'success' => false,
                'message' => 'Este traslado ya está finalizado.'
            ], 422);
        }

        // Buscar inventario destino (pendiente)
        $inventarioDestino = Inventario::where('id_servicio', $traslado->id_servicio_destino)
            ->where('gestion', $traslado->gestion)
            ->where('estado', 'vigente')
            ->orderBy('created_at', 'desc')
            ->first();

        // Obtener detalles del traslado
        $detallesTraslado = DetalleTraslado::where('id_traslado', $id)->get();
        if ($detallesTraslado->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No hay activos asociados a este traslado.'
            ], 422);
        }
        if (!$inventarioDestino) {
            return response()->json([
                'success' => false,
                'message' => 'No existe inventario vigente para el servicio destino en la gestión actual.'
            ], 422);
        }

        // Buscar inventario origen (pendiente)
        $inventarioOrigen = Inventario::where('id_servicio', $traslado->id_servicio_origen)
            ->where('gestion', $traslado->gestion)
            ->where('estado', 'vigente')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$inventarioOrigen) {
            return response()->json([
                'success' => false,
                'message' => 'No existe inventario pendiente para el servicio origen en la gestión actual.'
            ], 422);
        }



        DB::beginTransaction();

        try {
            foreach ($detallesTraslado as $detalle) {
                $idActivo = $detalle->id_activo;

                // Buscar detalle en inventario origen
                $detalleOrigen = DetalleInventario::where('id_inventario', $inventarioOrigen->id_inventario)
                    ->where('id_activo', $idActivo)
                    ->first();

                if (!$detalleOrigen) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "El activo ID {$idActivo} no se encuentra en el inventario de origen."
                    ], 422);
                }

                // Guardar el estado antes de eliminar
                $estadoAnterior = $detalleOrigen->estado_actual;

                // Eliminar el activo del inventario origen
                $detalleOrigen->delete();

                // Verificar si ya existe en destino
                $detalleDestino = DetalleInventario::where('id_inventario', $inventarioDestino->id_inventario)
                    ->where('id_activo', $idActivo)
                    ->first();

                if (!$detalleDestino) {
                    // Crear nuevo registro en destino
                    DetalleInventario::create([
                        'id_inventario' => $inventarioDestino->id_inventario,
                        'id_activo' => $idActivo,
                        'estado_actual' => $estadoAnterior, // se transfiere el estado
                        'observaciones' => $detalle->observaciones ?? '',
                    ]);
                }
            }

            // Finalizar traslado
            $traslado->estado = 'finalizado';
            $traslado->updated_at = now();
            $traslado->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Traslado finalizado correctamente. Los activos se movieron entre inventarios.',
                'data' => ['id_traslado' => $traslado->id_traslado]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el traslado: ' . $e->getMessage()
            ], 500);
        }
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
if ($request->estado) {
    $query->where('estado', $request->estado);
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
    // public function buscarInventario(Request $request)
    // {
    //     try {
    //         $query = Activo::query()->activos();

    //         // Filtro por servicio (por ejemplo, si tienes activo relacionado con servicio)
    //         if ($request->id_servicio) {
    //             // Supongo que en la tabla activo tienes algún campo id_servicio o alguna relación
    //             // Si no, debes ajustar esto a la relación correcta
    //             $query->where('id_servicio', $request->id_servicio);
    //         }

    //         // Filtro por código (insensible a mayúsculas/minúsculas)
    //         if ($request->codigo_activo) {
    //             $codigo = $request->codigo_activo;
    //             $query->whereRaw('LOWER(codigo) LIKE ?', ['%' . strtolower($codigo) . '%']);
    //         }

    //         // Filtro por nombre
    //         if ($request->nombre_activo) {
    //             $nombre = $request->nombre_activo;
    //             $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($nombre) . '%']);
    //         }

    //         // Filtro por categoría
    //         if ($request->categoria_activo) {
    //             $categoria = $request->categoria_activo;
    //             // Puede ser por id o por nombre, ajusta según cómo envíes el filtro
    //             $query->whereHas('categoria', function ($q) use ($categoria) {
    //                 $q->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($categoria) . '%']);
    //             });
    //         }

    //         $activos = $query->orderBy('nombre')->get();

    //         return view('user.activos.parcial_resultados_busqueda', compact('activos'));
    //     } catch (\Exception $e) {
    //         // \Log::error('Error en búsqueda de activos: '.$e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Ocurrió un error al buscar los activos.'
    //         ], 500);
    //     }
    // }


    public function buscarActivos(Request $request)
    {

        try {
            // Consulta base de inventarios
           $inventariosQuery = Inventario::where('estado', 'vigente'); // 🔥 SOLO VIGENTES

if ($request->filled('id_servicio_origen')) {
    $inventariosQuery->where('id_servicio', $request->id_servicio_origen);
}



            $inventarios = $inventariosQuery->pluck('id_inventario');

            $detalleQuery = DetalleInventario::with(['activo', 'inventario'])
                ->whereIn('id_inventario', $inventarios)
                // ->where('estado_actual', '!=', 'eliminado')
                ->whereHas('activo', function ($q) {
                    $q->soloActivos();
                });

            // Filtros opcionales
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

            $detalles = $detalleQuery->get();
            $idTrasladoActual = $request->id_traslado ?? null;
            foreach ($detalles as $detalle) {
                $idActivo = $detalle->activo->id_activo ?? null;
                // 🔹 Obtener IDs y número_documento de las actas donde aparece este activo
                $actas = DetalleTraslado::where('id_activo', $idActivo)
                    ->join('traslados as t', 't.id_traslado', '=', 'detalle_traslados.id_traslado')
                    ->where('t.estado', 'pendiente')   // 🔹 solo traslados pendientes
                    ->select('detalle_traslados.id_traslado', 't.numero_documento')
                    ->distinct()
                    ->get()
                    ->map(function ($a) {
                        return [
                            'id_traslado' => $a->id_traslado,
                            'numero_documento' => $a->numero_documento,
                        ];
                    })
                    ->values()
                    ->toArray();


                // 🔹 Determinar si este activo está en el TRASLADO actual
                $enTrasladoActual = $idTrasladoActual
                    ? collect($actas)->contains('id_traslado', $idTrasladoActual)
                    : false;

                // 🔹 Determinar si está en OTROS traslados distintos
                $enOtrosTraslados = $idTrasladoActual
                    ? collect($actas)->where('id_traslado', '!=', $idTrasladoActual)->isNotEmpty()
                    : collect($actas)->isNotEmpty();
                // dd($idTrasladoActual ." y ". $enTrasladoActual );

                // ✅ Guardar variables con los nombres que usa tu vista Blade
                $detalle->setAttribute('en_traslado_actual', $enTrasladoActual);
                $detalle->setAttribute('en_otros_traslados', $enOtrosTraslados);
                $detalle->setAttribute('actas_info', $actas);
                $detalle->setAttribute('id_traslado_actual', $idTrasladoActual);
            }




            return view('user.traslados.parcial_resultados_inventario', compact('detalles'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar en el inventario: ' . $e->getMessage()
            ], 500);
        }
    }





    public function mostrarBuscar()
    {
        try {
             $servicios = Servicio::whereRaw('LOWER(nombre) NOT LIKE ?', ['%activos fijos%'])->get();

            // $servicios = Servicio::all(); // Para llenar los selects
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
            // $servicios = Servicio::all();     // Para llenar selects de servicios
            $categorias = Categoria::all();   // Para llenar selects de categorías

            return view('user.traslados.parcial_inventario', compact('categorias'));
        } catch (\Exception $e) {
            // Opcional: loguear el error
            // \Log::error('Error al cargar parcial de búsqueda: '.$e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
                ], 500);
            }

            return view('user.traslados.parcial_inventario')->with(['message' => 'Ocurrió un error al cargar la vista de búsqueda.']);
        }
    }




    // use Illuminate\Database\QueryException;

    public function store(Request $request)
    {
        $rules = [
            'numero_documento' => ['required', 'regex:/^\d+$/', 'max:3'],
            'gestion' => ['required', 'digits:4'],
            'fecha' => 'required|date|after_or_equal:' . $request->gestion . '-01-01|before_or_equal:' . $request->gestion . '-12-31',
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
            'fecha.date' => 'La fecha no es válida.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior al año de la gestión.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior al año de la gestión.',
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
$responsableOrigen = Servicio::find($request->id_servicio_origen)?->id_responsable ?? null;
$responsableDestino = Servicio::find($request->id_servicio_destino)?->id_responsable ?? null;

        // ✅ Si pasó todas las validaciones, guardar
        $traslado = Traslado::create([
            'numero_documento' => $numero,
            'gestion' => $gestion,
            'fecha' => $request->fecha,
            'id_usuario' => auth()->id(),
           'id_servicio_origen' => $request->id_servicio_origen,
    'id_responsable_origen' => $responsableOrigen,    // nuevo campo en tabla
    'id_servicio_destino' => $request->id_servicio_destino,
    'id_responsable_destino' => $responsableDestino,  // nuevo campo en tabla
            'observaciones' => $request->observaciones,
            'estado' => 'pendiente',
        ]);

     $siguienteNumero = $this->generarNumeroDocumento($gestion);


// 👉 Formatearlo
$siguienteNumero = str_pad((int) $siguienteNumero, 3, '0', STR_PAD_LEFT);


// ✅ 3. Devolver el número siguiente al frontend
return response()->json([
    'success' => true,
    'message' => 'Nuevo Traslado agregado correctamente.',
    'data' => $traslado,
    'siguiente_numero' => $siguienteNumero,
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
  public function show($id = null)
{
    // Servicios para selects (excluyendo "activos fijos")
    $servicios = Servicio::whereRaw('LOWER(nombre) NOT LIKE ?', ['%activos fijos%'])->get();

    // Determinar la gestión actual
    $gestionActual = date('Y');

    // Generar número de documento disponible
    $numeroDisponible = $this->generarNumeroDocumento($gestionActual);

    $categorias = Categoria::all();

    if ($id) {
        $traslado = Traslado::find($id); // find en vez de findOrFail
    } else {
        $traslado = Traslado::latest('id_traslado')->first();
// dd($traslado);  
    }

    // Si no hay traslados, crear un objeto vacío con relaciones vacías
    if (!$traslado) {
        $traslado = new Traslado([
            'id_traslado' => '',
            'fecha' => '',
            'observaciones' => '',
            'id_servicio_origen' => '',
            'id_servicio_destino' => '',
            'id_usuario' => '',
        ]);

        // Relaciones vacías
        $traslado->setRelation('usuario', new Usuario   (['usuario' => '']));
        $traslado->setRelation('servicioOrigen', new Servicio(['nombre' => '']));
        $traslado->setRelation('servicioDestino', new Servicio(['nombre' => '']));
        $traslado->setRelation('responsable', new Responsable(['nombre' => '']));
    }

    return view(
        'user.traslados.show',
        compact('traslado', 'categorias', 'servicios', 'gestionActual', 'numeroDisponible')
    );
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
        //         $detalles = DetalleTraslado::with('activo.unidad', 'activo.estado', 'activo.detalleInventario')
        //         ->where('id_traslado', $id)
        //         ->get()
        //         ->map(function ($detalle) {
        //             $idActivo = $detalle->id_activo;

        //             // $cantidadDisponible = $detalle->activo->detalleInventario->cantidad ?? 0;
        //             // Buscar el último inventario PENDIENTE del servicio de la devolución
        // $ultimoInventario = Inventario::where('id_servicio', $detalle->traslado->id_servicio_origen)
        //     ->where('estado', 'pendiente')
        //     ->orderByDesc('fecha')
        //     ->first();

        //             // Obtener todos los traslados donde aparece este mismo activo
        //             $actasInfo = DetalleTraslado::where('id_activo', $idActivo)
        //                 ->with('traslado') // asumimos que hay relación `traslado` que tiene `numero_documento`
        //                 ->get()
        //                 ->map(function ($d) {
        //                     return [
        //                         'id_traslado' => $d->id_traslado,
        //                         'numero_documento' => $d->traslado->numero_documento ?? null,
        //                         'cantidad' => $d->cantidad ?? 0,
        //                     ];
        //                 });



        //             return $detalle;
        //         });
        $detalles = DetalleTraslado::with('activo.unidad', 'activo.estado')
            ->where('id_traslado', $id)
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
                $detalle->setAttribute('actas_info', DetalleTraslado::where('id_activo', $detalle->id_activo)
                    ->with('traslado')
                    ->get()
                    ->map(function ($d) {
                        return [
                            'id_traslado' => $d->id_traslado,
                            'numero_documento' => $d->traslado->numero_documento ?? null,
                        ];
                    }));

                return $detalle;
            });
        return view('user.traslados.parcial_activos', compact('detalles'));
    }



    // Agregar activo al traslado
    public function agregarActivo(Request $request, $id)
    {
        try {
            // 1️⃣ Verificar traslado
            $traslado = Traslado::findOrFail($id);
            if (!$traslado->isEditable()) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se puede modificar este traslado (FINALIZADO o ELIMINADO).'
                ], 422);
            }

            // 2️⃣ Buscar el activo
            $activo = Activo::activos()->findOrFail($request->id_activo);

            // 3️⃣ Buscar detalle inventario
            $detalleInventario = DetalleInventario::where('id_activo', $activo->id_activo)
                // ->where('estado_actual', '=', 'activo')
                ->first();

            if (!$detalleInventario) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró el detalle de inventario para este activo.'
                ], 404);
            }

            // 4️⃣ Evitar duplicados
            if (DetalleTraslado::where('id_traslado', $id)->where('id_activo', $activo->id_activo)->exists()) {
                return response()->json([
                    'success' => false,
                    'error' => 'El activo ya fue agregado a este traslado.'
                ], 422);
            }





            // 8️⃣ Crear el detalle con la cantidad solicitada
            $detalle = DetalleTraslado::create([
                'id_traslado' => $id,
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
                'error' => 'Traslado o activo no encontrado.'
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

        if (!$detalle) {
            return response()->json(['error' => 'Detalle no encontrado'], 404);
        }

        // Validar longitud de observaciones
        if ($request->observaciones !== null) {
            if (strlen($request->observaciones) > 100) {
                return response()->json(['error' => 'El campo observaciones no puede tener más de 100 caracteres'], 422);
            }
            $detalle->observaciones = $request->observaciones;
        }

        if ($request->cantidad !== null) {
            $detalle->cantidad = $request->cantidad;
        }

        $detalle->save();

        return response()->json(['success' => true, 'detalle' => $detalle]);
    }

    // Eliminar activo
    public function eliminarActivo(Request $request, $id)
    {
        try {
            // 1️⃣ Verificar que el traslado exista
            $traslado = Traslado::findOrFail($id);

            if (!$traslado->isEditable()) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se puede eliminar activos de un traslado FINALIZADO o ELIMINADO.'
                ], 422);
            }

            // 3️⃣ Buscar el detalle del traslado (activo específico)
            $detalle = DetalleTraslado::where('id_traslado', $id)
                ->where('id_activo', $request->id_activo)
                ->first();

            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'error' => 'El activo no se encuentra en este traslado.'
                ], 404);
            }

            // Guardar la cantidad antes de eliminar
            $cantidadEliminada = $detalle->cantidad;

            // 4️⃣ Eliminar el detalle
            $detalle->delete();

            // 5️⃣ Respuesta exitosa con cantidad eliminada
            return response()->json([
                'success' => true,
                'message' => 'Activo eliminado correctamente del traslado.',
                'cantidad_eliminada' => $cantidadEliminada
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Traslado no encontrado.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Ocurrió un error inesperado: ' . $e->getMessage()
            ], 500);
        }
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
        // $servicios = Servicio::all();     // Para servicios
         $servicios = Servicio::whereRaw('LOWER(nombre) NOT LIKE ?', ['%activos fijos%'])->get();

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
                ], 403);
            }

            $rules = [
                'numero_documento' => [
                    'required',
                    'regex:/^\d{1,20}$/',
                    // Regla para que sea único por gestión, excluyendo el registro actual
                    'unique:traslados,numero_documento,' . $id . ',id_traslado,gestion,' . $request->gestion
                ],
                'gestion' => 'required|digits:4|integer',
                'fecha' => 'required|date|after_or_equal:' . $request->gestion . '-01-01|before_or_equal:' . $request->gestion . '-12-31',
                'observaciones' => 'nullable|string|max:100',
                'id_servicio_origen' => 'required|exists:servicios,id_servicio',
                'id_servicio_destino' => 'required|exists:servicios,id_servicio|different:id_servicio_origen',
            ];

            $messages = [
                'numero_documento.required' => 'El número de traslado es obligatorio.',
                'numero_documento.regex' => 'El número de traslado debe contener solo números.',
                'numero_documento.unique' => 'El número de documento ya existe para esta gestión.',
                'gestion.required' => 'La gestión es obligatoria.',
                'gestion.digits' => 'La gestión debe tener 4 dígitos.',
                'fecha.required' => 'Debe indicar una fecha.',
                'fecha.date' => 'La fecha no es válida.',
                'fecha.after_or_equal' => 'La fecha no puede ser anterior al año de la gestión.',
                'fecha.before_or_equal' => 'La fecha no puede ser posterior al año de la gestión.',
                'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
                'id_servicio_origen.required' => 'Debe seleccionar un servicio de origen.',
                'id_servicio_destino.required' => 'Debe seleccionar un servicio de destino.',
                'id_servicio_destino.different' => 'El servicio destino no puede ser igual al origen.',
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
            $traslado->update([
                'numero_documento' => str_pad((int)$request->numero_documento, 3, '0', STR_PAD_LEFT),
                'gestion' => (int)$request->gestion,
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
