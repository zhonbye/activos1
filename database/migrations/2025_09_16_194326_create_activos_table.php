<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->id('id_activo');
            $table->string('codigo');
            $table->string('nombre');
            $table->text('detalle')->nullable();
            $table->string('estado_situacional')->default('inactivo');
            // Definir columnas FK como unsignedBigInteger porque las PK referenciadas lo son
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_unidad');
            $table->unsignedBigInteger('id_estado');
            $table->unsignedBigInteger('id_adquisicion');

            // Relaciones FK explícitas con nombres de columnas PK correspondientes
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_unidad')->references('id_unidad')->on('unidades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_estado')->references('id_estado')->on('estados')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_adquisicion')->references('id_adquisicion')->on('adquisiciones')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
DB::table('activos')->insert([
    [
        'codigo' => 'AMD-EMG-001',
        'nombre' => 'Camilla plegable',
        'detalle' => 'Camilla color blanco, plegable',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 1, // Mobiliario
        'id_unidad' => 1,    // Unidad
        'id_estado' => 2,    // BUENO
        'id_adquisicion' => 1,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-002',
        'nombre' => 'Desfibrilador portátil',
        'detalle' => 'Equipo portátil para reanimación',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17, // Equipamiento de Emergencias
        'id_unidad' => 6,     // Equipo
        'id_estado' => 2,
        'id_adquisicion' => 2,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-004',
        'nombre' => 'Silla de ruedas',
        'detalle' => 'Silla color azul para traslado',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 1,
        'id_unidad' => 1,
        'id_estado' => 2,
        'id_adquisicion' => 3,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-005',
        'nombre' => 'Monitor de signos vitales',
        'detalle' => 'Monitor portátil para pacientes críticos',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6, // Electromedicina
        'id_unidad' => 6,
        'id_estado' => 2,
        'id_adquisicion' => 4,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-006',
        'nombre' => 'Oxímetro portátil',
        'detalle' => 'Medidor de oxígeno en sangre, compacto',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6,
        'id_unidad' => 2,
        'id_estado' => 2,
        'id_adquisicion' => 5,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-007',
        'nombre' => 'Ambu manual',
        'detalle' => 'Bolsa de resucitación manual pequeña',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 6,
        'id_estado' => 2,
        'id_adquisicion' => 6,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-008',
        'nombre' => 'Maletín de trauma',
        'detalle' => 'Equipo portátil con vendajes y férulas',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 6,
        'id_estado' => 2,
        'id_adquisicion' => 7,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-009',
        'nombre' => 'Mascarilla de oxígeno',
        'detalle' => 'Mascarilla transparente con tubo',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 8,
        'id_unidad' => 2,
        'id_estado' => 2,
        'id_adquisicion' => 8,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-010',
        'nombre' => 'Respirador manual',
        'detalle' => 'Dispositivo portátil para asistencia respiratoria',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 6,
        'id_estado' => 2,
        'id_adquisicion' => 9,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-003',
        'nombre' => 'Botiquín de primeros auxilios',
        'detalle' => 'Botiquín con material básico',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 8, // Insumos Permanentes
        'id_unidad' => 2,    // Pieza
        'id_estado' => 2,
        'id_adquisicion' => 10,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
]);

    }

    public function down(): void
    {
        Schema::dropIfExists('activos');
    }
};
