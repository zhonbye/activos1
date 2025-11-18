<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre', 50);
            $table->string('descripcion', 100)->nullable();
            $table->timestamps();
        });

        DB::table('categorias')->insert([
    ['nombre' => 'Mobiliario', 'descripcion' => 'Muebles del hospital'],
    ['nombre' => 'Equipamiento Médico', 'descripcion' => 'Equipos médicos'],
    ['nombre' => 'Informática', 'descripcion' => 'Computadoras, impresoras, etc.'],
    ['nombre' => 'Instrumental Quirúrgico', 'descripcion' => 'Instrumentos usados en cirugías'],
    ['nombre' => 'Equipos de Laboratorio', 'descripcion' => 'Equipos para análisis clínicos y laboratorio'],
    ['nombre' => 'Electromedicina', 'descripcion' => 'Equipos electrónicos de uso médico'],
    ['nombre' => 'Vehículos', 'descripcion' => 'Ambulancias y vehículos institucionales'],
    ['nombre' => 'Insumos Permanentes', 'descripcion' => 'Insumos reutilizables de larga duración'],
    ['nombre' => 'Mobiliario de Oficina', 'descripcion' => 'Escritorios, sillas, estantes, archivadores'],
    ['nombre' => 'Audio y Video', 'descripcion' => 'Parlantes, televisores, proyectores'],
    ['nombre' => 'Herramientas', 'descripcion' => 'Herramientas de mantenimiento y reparación'],
    ['nombre' => 'Refrigeración', 'descripcion' => 'Heladeras, congeladores, frigobares'],
    ['nombre' => 'Calefacción y Climatización', 'descripcion' => 'Aires acondicionados, calefactores'],
    ['nombre' => 'Luminarias', 'descripcion' => 'Lámparas, focos, luminarias especiales'],
    ['nombre' => 'Telecomunicaciones', 'descripcion' => 'Radios, teléfonos, routers'],
    ['nombre' => 'Equipamiento Odontológico', 'descripcion' => 'Equipos para odontología'],
    ['nombre' => 'Equipamiento de Emergencias', 'descripcion' => 'Equipos para emergencias y urgencias'],
    ['nombre' => 'Equipamiento de Cocina', 'descripcion' => 'Cocinas, hornos, microondas'],
    ['nombre' => 'Lavandería', 'descripcion' => 'Lavadoras, secadoras, planchadoras'],
    ['nombre' => 'Limpieza y Sanitización', 'descripcion' => 'Equipos de limpieza industrial'],
    ['nombre' => 'Seguridad Industrial', 'descripcion' => 'Equipos de seguridad y protección'],
    ['nombre' => 'Didácticos', 'descripcion' => 'Material didáctico o de capacitación'],
    ['nombre' => 'Construcción y Mantenimiento', 'descripcion' => 'Equipos para obras y mantenimiento'],
    ['nombre' => 'Energía y Potencia', 'descripcion' => 'Generadores, UPS, estabilizadores'],
    ['nombre' => 'Sistemas Biomédicos', 'descripcion' => 'Equipos avanzados biomédicos'],
    ['nombre' => 'Decoración', 'descripcion' => 'Cuadros, cortinas, adornos'],
]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
