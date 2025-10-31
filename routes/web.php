<?php

use App\Http\Controllers\ActivoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AjustesController;
use App\Http\Controllers\BajaController;
use App\Http\Controllers\DetalleTrasladoController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\DoctoController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TrasladoController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ruta raíz: redirige según autenticación y rol
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login.form');
    }

    $user = Auth::user();

    // Suponiendo que tienes el campo 'rol' en la tabla usuarios con valores: 'administrador', 'usuario', etc.
    if ($user->rol === 'administrador') {
        return redirect()->route('dashboardAdmin');
    } else {
        return redirect()->route('dashboardUser');
    }
})->name('home');



// Rutas protegidas (middleware auth)
Route::middleware('auth')->group(function () {

    // Dashboard usuario normal
    Route::get('/dashboard', function () {
        if (auth()->user()->rol !== 'usuario') {
            return redirect()->route('home')->with('error', 'Acceso denegado');
        }
        return view('user.dashboardUser');
    })->middleware('auth')->name('dashboardUser');

    // Dashboard de administrador
    Route::get('/dashboard-admin', function () {
        if (auth()->user()->rol !== 'administrador') {
            return redirect()->route('home')->with('error', 'Acceso denegado');
        }
        return view('admin/dashboardAdmin');
    })->middleware('auth')->name('dashboardAdmin');

    // Dashboard de developer
    Route::get('/dashboard-dev', function () {
        if (auth()->user()->rol !== 'developer') {
            return redirect()->route('home')->with('error', 'Acceso denegado');
        }
        return view('dev/dashboardDev');
    })->middleware('auth')->name('dashboardDev');

    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
Route::get('login', [LoginController::class, 'index'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login');

// Ajustes usuario
Route::get('/ajustes', [AjustesController::class, 'index'])->name('ajustes.index');
Route::post('/ajustes', [AjustesController::class, 'guardar'])->name('ajustes.guardar'); // Cambié el método a guardar para POST
// admin usuarios
Route::get('/dashboard-admin/usuarios/registro', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::get('/dashboard-admin/usuarios/listar', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::post('/dashboard-admin/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
// Route::post('/dashboard-admin/usuarios/', [UsuarioController::class, 'store'])->name('usuarios.store');
// Route::get('/usuarios/roles', [UsuarioController::class, 'roles'])->name('usuarios.roles');

Route::post('/dashboard-admin/responsable', [ResponsableController::class, 'store'])->name('responsables.store');

Route::post('/dashboard/activos', [ActivoController::class, 'store'])->name('activos.store');
Route::get('/dashboard/activos', [ActivoController::class, 'create'])->name('activos.create');
Route::post('/activo/siguiente-codigo', [ActivoController::class, 'obtenerSiguienteCodigo']);
Route::get('/activos/buscarXcod', [ActivoController::class, 'buscar'])->name('activos.buscarXcod');
Route::get('/activos/lista', [ActivoController::class, 'index'])->name('activos.index');
Route::get('/activos/filtrar', [ActivoController::class, 'filtrar'])->name('activos.filtrar');
Route::get('/activo/{id}/detalle', [ActivoController::class, 'detalle'])->name('activo.detalle');
Route::get('/activo/{id}/editar', [ActivoController::class, 'edit'])->name('activo.edit');
Route::post('/activo/{id}/update', [ActivoController::class, 'update'])->name('activo.update');



// Route::post('/dashboard/actas', [DoctoController::class, 'store'])->name('actas.store');
// Route::get('/dashboard/actas', [DoctoController::class, 'create'])->name('actas.create');
// Route::get('/dashboard/actas/lista', [DoctoController::class, 'index'])->name('actas.index');
// // Route::get('/actas/buscar/{numero}/{gestion}', [DoctoController::class, 'buscarDocto']);
// Route::get('/actas/ultimodocto/{gestion}', [DoctoController::class, 'ultimodocto'])->name('actas.ultimodocto');



Route::get('/dashboard/entregas', [EntregaController::class, 'create'])->name('entregas.create');
Route::post('/entregas', [EntregaController::class, 'store'])->name('entregas.store');
Route::get('/dashboard/entregas/realizar', [EntregaController::class, 'createEntrega'])->name('entregas.realizar');
// Route::get('/dashboard/entregas/realizar', [EntregaController::class, 'mostrarVistaPrueba'])->name('entregas.realizar');
Route::get('/actas/get-datos', [EntregaController::class, 'getDatosActa'])->name('actas.getDatos');
Route::post('/actualizar-mensaje', [EntregaController::class, 'actualizarMensaje'])->name('actmensaje');
Route::get('/entregas/activos', [EntregaController::class, 'obtenerActivosPorEntrega'])->name('entregas.activos');
Route::get('actas/buscar/{tipo}/{numero}/{gestion}', [EntregaController::class, 'buscarActaPorTipo']);
Route::post('/entregas/detalles/store', [EntregaController::class, 'storeDetalles']);

Route::get('/getDocto', [EntregaController::class, 'getDocto']);
Route::get('/entregas/{entregaId}/activos', [EntregaController::class, 'activosDeEntrega'])->name('activos.deEntrega');
Route::post('/entregas/guardar-activos', [EntregaController::class, 'guardarActivos'])->name('activos.guardarPorEntrega');
Route::post('/entregas/guardar-entrega-realizada', [EntregaController::class, 'guardarEntregaRealizada']);


Route::get('/ubicaciones/{id}/servicios', [UbicacionController::class, 'servicios']);

Route::get('/servicios/{id}/responsable', [ServicioController::class, 'responsable']);



Route::get('/responsables/{id}', [ResponsableController::class, 'show']);




// Route::get('/inventarios/consultar', [InventarioController::class, 'consultar'])->name('inventario.consultar');
Route::get('/inventario/ultimo', [InventarioController::class, 'ultimoInventario']);
Route::get('/inventarios/generar', [InventarioController::class, 'generarVacio'])->name('inventarios.generar');
Route::get('/inventarios/filtro', [InventarioController::class, 'filtrar'])->name('inventario.filtrar');
Route::get('/inventarios', [InventarioController::class, 'consultar'])->name('inventario.consultar');
Route::get('/inventario/{id}/activos', [InventarioController::class, 'activosInventario'])->name('inventario.activos');

// Route::get('/inventarios/filtro', [InventarioController::class, 'consultar'])->name('inventarios.filtrar');


Route::get('/bajas', [BajaController::class, 'create'])->name('bajas.create');


// web.php
// Route::get('/traslados/registrar', [TrasladoController::class, 'create'])->name('traslados.create');
Route::get('/traslados/mostrarBuscar', [TrasladoController::class, 'mostrarBuscar'])->name('traslados.mostrarBuscar');
// Route::post('/traslados/store', [TrasladoController::class, 'store'])->name('traslados.store');
// Route::get('/traslados/mostrarInventario', [TrasladoController::class, 'mostrarInventario'])->name('traslados.mostrarInventario');
Route::get('/traslados/mostrarInventario', [TrasladoController::class, 'mostrarInventario'])->name('traslados.mostrarInventario');
Route::get('/traslados/{id}', [TrasladoController::class,'show'])->name('traslados.show');
Route::get('/traslados', [TrasladoController::class, 'create'])->name('traslados.create');
Route::post('/traslados/guardar', [TrasladoController::class, 'store'])->name('traslados.store');
Route::post('/traslados/buscar', [TrasladoController::class, 'buscar'])->name('traslados.buscar');
Route::post('/traslados/buscarActivos', [TrasladoController::class, 'buscarActivos'])->name('traslados.buscarActivos');
// Route::post('/traslados/buscarInventario', [TrasladoController::class, 'buscar'])->name('traslados.buscarInventario');
Route::get('/traslados/generar-numero/{gestion}', [TrasladoController::class, 'generarNumeroAjax'])->name('traslados.generarNumero');


Route::post('/traslados/{id}/activos/agregar', [TrasladoController::class,'agregarActivo']);
Route::post('/traslados/{id}/activos/eliminar', [TrasladoController::class, 'eliminarActivo'])->name('traslados.activos.eliminar');


Route::get('/traslados/{id}/editar', [TrasladoController::class, 'edit'])->name('traslados.edit');
Route::put('/traslados/{id}/update', [TrasladoController::class, 'update'])->name('traslados.update');

// Vista parcial de tabla de activos
Route::get('/traslados/{id}/activos', [TrasladoController::class,'tablaActivos']);
Route::get('/traslados/{id}/detalle', [TrasladoController::class, 'detalleParcial'])->name('traslados.detalleParcial');
Route::post('/traslados/{id}/activos/editar', [TrasladoController::class,'editarActivo']);
Route::post('/traslados/{id}/activos/eliminar', [TrasladoController::class,'eliminarActivo']);
Route::post('/traslados/{id}/finalizar', [TrasladoController::class, 'guardarTraslado'])->name('traslados.finalizar');


Route::post('/traslados/{id}/activos/limpiar', [DetalleTrasladoController::class, 'limpiarActivos'])->name('traslados.activos.limpiar');









Route::get('/devolucion/generar-numero/{gestion}', [DevolucionController::class, 'generarNumeroAjax'])->name('devolucion.generarNumero');


Route::get('/devolucion/mostrarBuscarActa', [DevolucionController::class, 'mostrarBuscarActa'])->name('devolucion.mostrarBuscarActa');
Route::get('/devolucion/mostrarInventario', [DevolucionController::class, 'mostrarInventario'])->name('devolucion.mostrarInventario');
Route::post('/devolucion/buscarActivos', [DevolucionController::class, 'buscarActivos'])->name('devolucion.buscarActivos');
Route::post('/devolucion/buscar', [DevolucionController::class, 'buscar'])->name('devolucion.buscar');
Route::get('/devolucion/{id}/activos', [DevolucionController::class,'tablaActivos']);
Route::get('/devolucion/{id?}', [DevolucionController::class,'show'])->name('devolucion.show');
Route::get('/devolucion', [DevolucionController::class, 'create'])->name('devolucion.create');
Route::post('/devolucion/guardar', [DevolucionController::class, 'store'])->name('devolucion.store');
Route::get('/devolucion/{id}/detalleDevolucion', [DevolucionController::class, 'detalleParcialDevolucion'])->name('traslados.detalleDevolucion');
Route::get('/devolucion/{id}/editar', [DevolucionController::class, 'edit'])->name('devolucion.edit');
Route::put('/devolucion/{id}/update', [DevolucionController::class, 'update'])->name('devolucion.update');
Route::post('/devolucion/{id}/activos/editar', [DevolucionController::class,'editarActivo']);
Route::post('/devolucion/{id}/activos/eliminar', [DevolucionController::class,'eliminarActivo']);
Route::post('/devolucion/{id}/activos/agregar', [DevolucionController::class,'agregarActivo']);

// Route::get('/devoluciones/{id}/detalleDevolucion', [DevolucionController::class, 'detalleParcialDevolucion'])->name('devolucion.detalleParcialDevolucion');













Route::get('/entregas/{id}', [EntregaController::class,'show'])->name('entregas.show');














Route::get('/prueba', [TrasladoController::class, 'prueba'])->name('pruebas');
