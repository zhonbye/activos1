<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetalleDevolucion;
use App\Models\Devolucion;
use App\Models\Estado;
use App\Models\Servicio;
use App\Models\Traslado;
use App\Models\Unidad;
use Illuminate\Http\Request;
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
    $servicios = Servicio::with('responsable')->get();

    // Determinar la gestión actual (sin Carbon)
    $gestionActual = date('Y');

    // Generar número de documento disponible
    $numeroDisponible = $this->generarNumeroDocumento($gestionActual);

    // Retornar vista con variables
    return view('user.devolucion.parcial_nuevo', compact('servicios', 'gestionActual', 'numeroDisponible'));
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
//             return view('user.traslados.parcial_buscar', compact('servicios'));
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
//             return view('user.traslados.parcial_buscar')->with(['message' => 'Ocurrió un error al cargar la vista de búsqueda.']);
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

        return response()->json([
            'success' => true,
            'message' => 'Nueva Devolución registrada correctamente.',
            'data' => $devolucion,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $devolucion = Devolucion::findOrFail($id);
        return view('user.devolucion.show', compact('devolucion'));
    }
    public function tablaActivos($id)
    {
        $detalles = DetalleDevolucion::with('activo.unidad', 'activo.estado', 'activo.detalleInventario')
        ->where('id_devolucion', $id)
        ->get()
        ->map(function ($detalle) {
            $idActivo = $detalle->id_activo;

            $cantidadDisponible = $detalle->activo->detalleInventario->cantidad ?? 0;
            $cantidadUsada = DetalleDevolucion::where('id_activo', $idActivo)->sum('cantidad');
            $cantidadEnActa = $detalle->cantidad ?? 0;

            // Obtener todos los traslados donde aparece este mismo activo
            $actasInfo = DetalleDevolucion::where('id_activo', $idActivo)
                ->with('devolucion')
                ->get()
                ->map(function ($d) {
                    return [
                        'id_devolucion' => $d->id_devolucion,
                        'numero_documento' => $d->devolucion->numero_documento ?? null,
                        'cantidad' => $d->cantidad ?? 0,
                    ];
                });

            // Agregar propiedades dinámicas correctamente
            $detalle->setAttribute('cantidad_disponible', $cantidadDisponible);
            $detalle->setAttribute('cantidad_usada', $cantidadUsada);
            $detalle->setAttribute('cantidad_en_acta', $cantidadEnActa);
            $detalle->setAttribute('actas_info', $actasInfo);

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
    public function edit(Devolucion $devolucion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Devolucion $devolucion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Devolucion $devolucion)
    {
        //
    }
}
