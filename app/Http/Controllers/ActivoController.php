<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Adquisicion;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\DetalleBaja;
use App\Models\DetalleDevolucion;
use App\Models\DetalleEntrega;
use App\Models\DetalleTraslado;
use App\Models\Docto;
use App\Models\Donacion;
use App\Models\Donante;
use App\Models\Estado;
use App\Models\Proveedor;
use App\Models\Responsable;
use App\Models\Ubicacion;
use App\Models\Unidad;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function historial() {
        return view('user.activos.historial'); // solo carga la vista y filtros
    }

public function filtrarHistorial(Request $request) {
    $activoFiltro = $request->activo;
    $tipoFiltro = $request->tipo;
    $servicioOrigen = $request->servicio_origen;
    $servicioDestino = $request->servicio_destino;
    $fechaInicio = $request->fecha_inicio;
    $fechaFin = $request->fecha_fin;

    $historial = collect();

    // Entregas
    $entregas = DetalleEntrega::with(['activo', 'entrega.responsable', 'entrega.servicio'])
        ->when($activoFiltro, fn($q) => $q->whereHas('activo', fn($q2) =>
            $q2->where('nombre', 'like', "%$activoFiltro%")->orWhere('codigo', 'like', "%$activoFiltro%")
        ))
        ->when($fechaInicio, fn($q) => $q->whereHas('entrega', fn($q2) => $q2->where('fecha', '>=', $fechaInicio)))
        ->when($fechaFin, fn($q) => $q->whereHas('entrega', fn($q2) => $q2->where('fecha', '<=', $fechaFin)))
        ->get()
        ->map(fn($d) => [
            'fecha' => $d->entrega->fecha,
            'codigo' => $d->activo->codigo,
            'activo' => $d->activo->nombre,
            'tipo_movimiento' => 'entrega',
            'origen' => $d->entrega->servicio->nombre ?? '',
            'destino' => '',
            'usuario' => $d->entrega->responsable->nombre ?? '',
            'observaciones' => $d->observaciones,
            'id' => $d->entrega->id_entrega
        ]);

    // Traslados
    $traslados = DetalleTraslado::with(['activo', 'traslado.servicioOrigen', 'traslado.servicioDestino', 'traslado.usuario'])
        ->when($activoFiltro, fn($q) => $q->whereHas('activo', fn($q2) =>
            $q2->where('nombre', 'like', "%$activoFiltro%")->orWhere('codigo', 'like', "%$activoFiltro%")
        ))
        ->when($fechaInicio, fn($q) => $q->whereHas('traslado', fn($q2) => $q2->where('fecha', '>=', $fechaInicio)))
        ->when($fechaFin, fn($q) => $q->whereHas('traslado', fn($q2) => $q2->where('fecha', '<=', $fechaFin)))
        ->get()
        ->map(fn($d) => [
            'fecha' => $d->traslado->fecha,
            'codigo' => $d->activo->codigo,
            'activo' => $d->activo->nombre,
            'tipo_movimiento' => 'traslado',
            'origen' => $d->traslado->servicioOrigen->nombre ?? '',
            'destino' => $d->traslado->servicioDestino->nombre ?? '',
            'usuario' => $d->traslado->usuario->name ?? '',
            'observaciones' => $d->observaciones,
            'id' => $d->traslado->id_traslado
        ]);

    // Devoluciones
    $devoluciones = DetalleDevolucion::with(['activo', 'devolucion.servicio', 'devolucion.usuario'])
        ->when($activoFiltro, fn($q) => $q->whereHas('activo', fn($q2) =>
            $q2->where('nombre', 'like', "%$activoFiltro%")->orWhere('codigo', 'like', "%$activoFiltro%")
        ))
        ->when($fechaInicio, fn($q) => $q->whereHas('devolucion', fn($q2) => $q2->where('fecha', '>=', $fechaInicio)))
        ->when($fechaFin, fn($q) => $q->whereHas('devolucion', fn($q2) => $q2->where('fecha', '<=', $fechaFin)))
        ->get()
        ->map(fn($d) => [
            'fecha' => $d->devolucion->fecha,
            'codigo' => $d->activo->codigo,
            'activo' => $d->activo->nombre,
            'tipo_movimiento' => 'devolución',
            'origen' => '',
            'destino' => $d->devolucion->servicio->nombre ?? '',
            'usuario' => $d->devolucion->usuario->name ?? '',
            'observaciones' => $d->observaciones,
            'id' => $d->devolucion->id_devolucion
        ]);

    // Bajas
    $bajas = DetalleBaja::with(['activo', 'baja.usuario'])
        ->when($activoFiltro, fn($q) => $q->whereHas('activo', fn($q2) =>
            $q2->where('nombre', 'like', "%$activoFiltro%")->orWhere('codigo', 'like', "%$activoFiltro%")
        ))
        ->when($fechaInicio, fn($q) => $q->whereHas('baja', fn($q2) => $q2->where('fecha', '>=', $fechaInicio)))
        ->when($fechaFin, fn($q) => $q->whereHas('baja', fn($q2) => $q2->where('fecha', '<=', $fechaFin)))
        ->get()
        ->map(fn($d) => [
            'fecha' => $d->baja->fecha,
            'codigo' => $d->activo->codigo,
            'activo' => $d->activo->nombre,
            'tipo_movimiento' => 'baja',
            'origen' => '',
            'destino' => '',
            'usuario' => $d->baja->usuario->name ?? '',
            'observaciones' => $d->observaciones,
            'id' => $d->baja->id_baja
        ]);

    // Mezclamos todo y ordenamos por fecha descendente
    $historial = $entregas->merge($traslados)->merge($devoluciones)->merge($bajas)
        ->sortByDesc('fecha');

    // Retornamos la vista parcial con los datos filtrados
    return view('user.activos.parcial_historial', compact('historial'));
}
























    public function update(Request $request, $id)
{
    // Buscar activo, incluyendo su adquisición y relaciones
    $activo = Activo::with(['adquisicion.compra', 'adquisicion.donacion'])->findOrFail($id);

    // Reglas de validación
    $rules = [
        'codigo' => 'required|string|max:50|unique:activos,codigo,' . $activo->id_activo . ',id_activo',
        'nombre' => 'required|string|max:255',
        'detalle' => 'nullable|string|max:500',
        'id_categoria' => 'required|exists:categorias,id_categoria',
        'id_unidad' => 'required|exists:unidades,id_unidad',
        'id_estado' => 'required|exists:estados,id_estado',
        'fecha' => 'nullable|date',
        'comentarios' => 'nullable|string|max:100',
        'sin_datos' => 'nullable|boolean',
        'tipo_adquisicion' => 'nullable|string|in:compra,donacion,otro',
    ];

    if (!$request->boolean('sin_datos') && $request->tipo_adquisicion === 'compra') {
        $rules = array_merge($rules, [
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'precio_compra' => 'required|numeric|min:0',
        ]);
    }

    if (!$request->boolean('sin_datos') && $request->tipo_adquisicion === 'donacion') {
        $rules = array_merge($rules, [
            'id_donante' => 'required|exists:donantes,id_donante',
            'motivo' => 'required|string|max:255',
            'precio_donacion' => 'required|numeric|min:0',
        ]);
    }

    // Mensajes personalizados
    $messages = [
        'codigo.required' => 'El código es obligatorio.',
        'codigo.unique' => 'El código ya está en uso.',
        'nombre.required' => 'El nombre es obligatorio.',
        'id_categoria.required' => 'Debe seleccionar una categoría.',
        'id_categoria.exists' => 'La categoría seleccionada no existe.',
        'id_unidad.required' => 'Debe seleccionar una unidad de medida.',
        'id_unidad.exists' => 'La unidad de medida seleccionada no existe.',
        'id_estado.required' => 'Debe seleccionar un estado.',
        'id_estado.exists' => 'El estado seleccionado no existe.',
        'fecha.date' => 'La fecha no es válida.',
        'precio_compra.required' => 'El precio de compra es obligatorio.',
        'precio_compra.numeric' => 'El precio de compra debe ser un número válido.',
        'precio_compra.min' => 'El precio de compra debe ser mínimo 0.',
        'id_proveedor.required' => 'Debe seleccionar un proveedor.',
        'id_proveedor.exists' => 'El proveedor seleccionado no existe.',
        'id_donante.required' => 'El donante es obligatorio.',
        'id_donante.exists' => 'El donante seleccionado no existe.',
        'motivo.required' => 'El motivo es obligatorio.',
        'motivo.string' => 'El motivo debe ser texto.',
        'precio_donacion.required' => 'El precio estimado es obligatorio.',
        'precio_donacion.numeric' => 'El precio estimado debe ser un número válido.',
        'precio_donacion.min' => 'El precio estimado debe ser mínimo 0.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'Errores de validación en los campos.'
        ], 422);
    }

    DB::beginTransaction();
    try {
        // Actualizar datos del activo
        $activo->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'detalle' => $request->detalle,
            'id_categoria' => $request->id_categoria,
            'id_unidad' => $request->id_unidad,
            'id_estado' => $request->id_estado,
        ]);

        // Actualizar o crear adquisición
        if ($request->tipo_adquisicion === 'compra' || $request->tipo_adquisicion === 'donacion') {
            $adquisicion = $activo->adquisicion;
            if (!$adquisicion) {
                $adquisicion = new Adquisicion();
                $adquisicion->id_adquisicion = null; // Laravel auto increment
                $adquisicion->activo_id = $activo->id_activo;
            }

            $adquisicion->tipo = $request->tipo_adquisicion;
            $adquisicion->fecha = $request->fecha;
            $adquisicion->comentarios = $request->comentarios;
            $adquisicion->save();

            // Actualizar detalles según tipo
            if ($request->tipo_adquisicion === 'compra') {
                // Eliminar donacion si existía
                if ($adquisicion->donacion) $adquisicion->donacion()->delete();

                $compra = $adquisicion->compra ?? new Compra();
                $compra->id_adquisicion = $adquisicion->id_adquisicion;
                $compra->id_proveedor = $request->id_proveedor;
                $compra->precio = $request->precio_compra;
                $compra->save();
            }

            if ($request->tipo_adquisicion === 'donacion') {
                // Eliminar compra si existía
                if ($adquisicion->compra) $adquisicion->compra()->delete();

                $donacion = $adquisicion->donacion ?? new Donacion();
                $donacion->id_adquisicion = $adquisicion->id_adquisicion;
                $donacion->id_donante = $request->id_donante;
                $donacion->motivo = $request->motivo;
                $donacion->precio = $request->precio_donacion;
                $donacion->save();
            }
        } else {
            // Tipo "otro", eliminar compra o donacion si existían
            if ($activo->adquisicion) {
                if ($activo->adquisicion->compra) $activo->adquisicion->compra()->delete();
                if ($activo->adquisicion->donacion) $activo->adquisicion->donacion()->delete();
                // Mantener solo la adquisición básica
                $activo->adquisicion->tipo = 'otro';
                $activo->adquisicion->fecha = $request->fecha;
                $activo->adquisicion->comentarios = $request->comentarios;
                $activo->adquisicion->save();
            }
        }

        DB::commit();

        return response()->json([
        'success' => true,
        'message' => 'Activo actualizado correctamente.',
        'data' => [
            'id_activo' => $activo->id_activo,
            'codigo' => $activo->codigo,
            'nombre' => $activo->nombre,
            'detalle' => $activo->detalle,
            'categoria' => $activo->categoria->nombre ?? 'N/A',
            'unidad' => $activo->unidad->nombre ?? 'N/A',
            'estado' => $activo->estado->nombre ?? 'N/A',
            'fecha' => $activo->created_at->format('d/m/Y'),
        ],
    ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el activo: ' . $e->getMessage(),
        ], 500);
    }
}

   public function edit($id)
{
    // Traer activo usando scopeActivo (ignora eliminados)
    $activo = Activo::activos()
        ->with([
            'categoria',
            'unidad',
            'estado',
            'adquisicion.compra.proveedor',
            'adquisicion.donacion.donante'
        ])
        ->findOrFail($id);

    // Traer datos para selects
    $categorias = Categoria::all();
    $unidades = Unidad::all();
    $estados = Estado::all();

    return view('user.activos.parcial_editar', compact('activo', 'categorias', 'unidades', 'estados'));
}


   public function index()
{
    $activos = Activo::activos()->with(['unidad','estado','categoria'])->paginate(20);
    $categorias = Categoria::all();
    $unidades = Unidad::all();
    sleep(2);

    return view('user.activos.listar', compact('activos','categorias','unidades'));
}


public function detalle($id)
{
    $activo = Activo::activos()->with([
        'categoria',
        'unidad',
        'estado',
        'adquisicion.compra.proveedor', // compras
        'adquisicion.donacion.donante'  // donaciones
    ])->findOrFail($id);
//  dd($activo->adquisicion, $activo->adquisicion->compra, $activo->adquisicion->donacion);
// $activo = Activo::with([
//     'adquisicion.compra',
//     'adquisicion.donacion'
// ])->findOrFail($id);

// dd($activo->adquisicion->compra, $activo->adquisicion->donacion);


    return view('user.activos.parcial_detalle', compact('activo'))->render();
}

public function filtrar(Request $request)
{
    $query = Activo::activos()->with(['unidad', 'estado', 'categoria']);

    // Filtros existentes
    if ($request->filled('codigo')) {
        $query->where('codigo', $request->codigo);
    }
    if ($request->filled('nombre')) {
        $query->where('nombre', 'like', "%{$request->nombre}%");
    }
    if ($request->filled('detalle')) {
        $query->where('detalle', 'like', "%{$request->detalle}%");
    }
    if ($request->filled('categoria') && $request->categoria != 'all') {
        $query->where('id_categoria', $request->categoria);
    }
    if ($request->filled('unidad') && $request->unidad != 'all') {
        $query->where('id_unidad', $request->unidad);
    }
    if ($request->filled('estado') && $request->estado != 'all') {
        $query->where('id_estado', $request->estado);
    }

    // Fecha de creación (rango)
    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $fechaInicio = $request->fecha_inicio . ' 00:00:00';
        $fechaFin    = $request->fecha_fin . ' 23:59:59';
        $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }

    // Ordenamiento dinámico
    $ordenarPor = $request->input('ordenar_por', 'created_at'); // default
    $direccion  = $request->input('direccion', 'desc');         // default
    $query->orderBy($ordenarPor, $direccion);

    // Paginación
    $activos = $query->paginate(20)->withQueryString();

    return view('user.activos.parcial', compact('activos'))->render();
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $estados = Estado::all();
        $categorias = Categoria::all();
        $unidadesmed = Unidad::all();
        $proveedores = Proveedor::all();  // o el query que uses
        $donantes = Donante::all();

        return view('user.activos.registrar', compact('estados', 'categorias', 'unidadesmed', 'proveedores', 'donantes'));
    }


    public function obtenerSiguienteCodigo(Request $request)
    {
        $codigoBase = $request->input('codigo_base');

        if (!$codigoBase) {
            return response()->json([
                'success' => false,
                'message' => 'No se envió código base'
            ]);
        }

        // Separar prefijo (letras + guiones) y número al final
        if (!preg_match('/^(.*?)(\d+)$/', $codigoBase, $matches)) {
            // No tiene número al final
            $prefijo = $codigoBase;
            $numero = 1;
            $longitudNumero = 3; // Por defecto, o cambia según tu formato
        } else {
            $prefijo = $matches[1];
            $numero = intval($matches[2]);
            $longitudNumero = strlen($matches[2]); // Para mantener ceros a la izquierda
        }

        // Traer todos los códigos que empiezan con el prefijo
       $codigos = Activo::where('codigo', 'like', $prefijo . '%')
            ->where('estado_situacional', 'activo') // filtra solo activos vigentes
            ->pluck('codigo')
            ->toArray();


        // Extraer solo los números de los códigos existentes
        $numerosExistentes = [];

        foreach ($codigos as $codigo) {
            if (preg_match('/^' . preg_quote($prefijo, '/') . '(\d+)$/', $codigo, $m)) {
                $numerosExistentes[] = intval($m[1]);
            }
        }

        sort($numerosExistentes);

        // Buscar el primer número faltante empezando desde 1
        $siguienteNumero = 1;
        foreach ($numerosExistentes as $num) {
            if ($num == $siguienteNumero) {
                $siguienteNumero++;
            } elseif ($num > $siguienteNumero) {
                // Encontramos un hueco
                break;
            }
        }

        // Formatear el número con ceros a la izquierda
        $formatoNumero = str_pad($siguienteNumero, $longitudNumero, '0', STR_PAD_LEFT);

        $siguienteCodigo = $prefijo . $formatoNumero;

        return response()->json([
            'success' => true,
            'siguiente_codigo' => $siguienteCodigo
        ]);
    }
    public function buscar(Request $request)
    {
        $codigo = $request->input('codigo');

        if (!$codigo) {
            return response()->json(['error' => 'Debe proporcionar un código o nombre.'], 422);
        }

        $activo = Activo::with(['unidad', 'estado'])
            ->where('estado_situacional', 'activo')
            ->whereRaw('LOWER(codigo) = ?', [$codigo    ])
            ->first();
        if (!$activo) {
            return response()->json(['error' => 'No se encontró activo con ese código o nombre.'], 404);
        }

        // Construimos el objeto con IDs y nombres
        $data = [
            'id_activo' => $activo->id_activo,
            'codigo' => $activo->codigo,
            'nombre' => $activo->nombre,
            'detalle' => $activo->detalle,
            'id_unidad' => $activo->id_unidad,
            'unidad' => $activo->unidad->nombre,   // nombre de la unidad
            'id_estado' => $activo->id_estado,
            'estado' => $activo->estado->nombre,   // nombre del estado
            'created_at' => $activo->created_at,
            'updated_at' => $activo->updated_at,
        ];

        return response()->json(['activo' => $data]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'codigo' => 'required|string|max:50',
            'nombre' => 'required|string|max:255',
            'detalle' => 'nullable|string|max:500',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_unidad' => 'required|exists:unidades,id_unidad',
            'id_estado' => 'required|exists:estados,id_estado',
            'fecha' => 'nullable|date',
            'comentarios' => 'nullable|string|max:500',
            'sin_datos' => 'nullable|boolean',
            'tipo_adquisicion' => 'nullable|string|in:compra,donacion',
        ];

        // Verifica si sin_datos no está marcado y tipo_adquisicion es 'compra'
        if (!$request->boolean('sin_datos') && $request->tipo_adquisicion === 'compra') {
            $rules = array_merge($rules, [
                'id_proveedor' => 'required|exists:proveedores,id_proveedor',
                'precio_compra' => 'required|numeric|min:0',
            ]);
        }

        // Verifica si sin_datos no está marcado y tipo_adquisicion es 'donacion'
        if (!$request->boolean('sin_datos') && $request->tipo_adquisicion === 'donacion') {
            $rules = array_merge($rules, [
                'id_donante' => 'required|exists:donantes,id_donante',
                'motivo' => 'required|string|max:255',
                'precio_donacion' => 'required|numeric|min:0',
            ]);
        }

        // Mensajes de validación personalizados
        $messages = [
            'codigo.required' => 'El código es obligatorio.',
            // 'codigo.unique' => 'El código ya está en uso.',
            'nombre.required' => 'El nombre es obligatorio.',
            'id_categoria.required' => 'Debe seleccionar una categoría.',
            'id_categoria.exists' => 'La categoría seleccionada no existe.',
            'id_unidad.required' => 'Debe seleccionar una unidad de medida.',
            'id_unidad.exists' => 'La unidad de medida seleccionada no existe.',
            'id_estado.required' => 'Debe seleccionar un estado.',
            'id_estado.exists' => 'El estado seleccionado no existe.',
            'fecha.date' => 'La fecha no es válida.',
            'precio_compra.required' => 'El precio de compra es obligatorio.',
            'precio_compra.numeric' => 'El precio de compra debe ser un número válido.',
            'precio_compra.min' => 'El precio de compra debe ser mínimo 0.',
            'id_proveedor.required' => 'Debe seleccionar un proveedor.',
            'id_proveedor.exists' => 'El proveedor seleccionado no existe.',
            'id_donante.required' => 'Debe seleccionar un donante.',
            'id_donante.exists' => 'El donante seleccionado no existe.',
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.string' => 'El motivo debe ser texto.',
            'precio_donacion.required' => 'El precio estimado es obligatorio.',
            'precio_donacion.numeric' => 'El precio estimado debe ser un número válido.',
            'precio_donacion.min' => 'El precio estimado debe ser mínimo 0.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        // dd($request->all());


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Errores de validación en los campos.'
            ], 422);
        }
       // ✅ Verifica duplicados solo en activos con estado "activo"
if (Activo::soloActivos()->where('codigo', $request->codigo)->exists()) {
    return response()->json([
        'success' => false,
        'message' => 'El código ya está en uso por un activo con estado activo.'
    ], 422);
}

        DB::beginTransaction();

        try {
            $validated = $validator->validated();

            $sinDatos = $request->boolean('sin_datos');
            $tipoAdquisicion = $sinDatos ? 'otro' : ($validated['tipo_adquisicion'] ?? 'otro');

            // Guardar adquisición
            $adquisicion = new Adquisicion();
            $adquisicion->fecha = $validated['fecha'] ?? null;
            $adquisicion->comentarios = $validated['comentarios'] ?? null;
            $adquisicion->tipo = $tipoAdquisicion;
            $adquisicion->save();

            // Guardar activo con la adquisición recién creada
            $activo = new Activo();
            $activo->codigo = $validated['codigo'];
            $activo->nombre = $validated['nombre'];
            $activo->detalle = $validated['detalle'] ?? null;
            $activo->id_categoria = $validated['id_categoria'];
            $activo->id_unidad = $validated['id_unidad'];
            $activo->id_estado = $validated['id_estado'];
            $activo->id_adquisicion = $adquisicion->id_adquisicion; // importante, asignar el ID
            $activo->save();

            // Guardar compra o donación si aplica
            if (!$sinDatos) {
                if ($tipoAdquisicion === 'compra') {
                    Compra::create([
                        'id_adquisicion' => $adquisicion->id_adquisicion, // CORRECTO
                        'id_proveedor' => $validated['id_proveedor'],
                        'precio' => $validated['precio_compra'],
                    ]);
                } elseif ($tipoAdquisicion === 'donacion') {
                    Donacion::create([
                        'id_adquisicion' => $adquisicion->id_adquisicion, // CORRECTO
                        'id_donante' => $validated['id_donante'],
                        'motivo' => $validated['motivo'],
                        'precio_estimado' => $validated['precio_donacion'],
                    ]);
                }
            }


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Activo registrado correctamente.',
                'activo_id' => $activo->id_activo,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el activo: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Activo $activo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activo $activo)
    {
        //
    }
}
