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
        'codigo' => 'AMD-EMG-003',
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
        'codigo' => 'AMD-EMG-004',
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
        'codigo' => 'AMD-EMG-005',
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
        'codigo' => 'AMD-EMG-006',
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
        'codigo' => 'AMD-EMG-007',
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
        'codigo' => 'AMD-EMG-008',
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
        'codigo' => 'AMD-EMG-009',
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
        'codigo' => 'AMD-EMG-010',
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
      [
        'codigo' => 'AMD-EMG-011',
        'nombre' => 'Desfibrilador portátil',
        'detalle' => 'Equipo de desfibrilación para emergencias',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6, // Electromedicina
        'id_unidad' => 6, // Equipo
        'id_estado' => 1, // NUEVO
        'id_adquisicion' => 11,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-012',
        'nombre' => 'Monitor multiparámetro',
        'detalle' => 'Monitor de signos vitales para emergencias',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6, 
        'id_unidad' => 6,
        'id_estado' => 1,
        'id_adquisicion' => 12,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-013',
        'nombre' => 'Bolsa de aspiración manual',
        'detalle' => 'Equipo para aspiración de secreciones',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17, // Emergencias
        'id_unidad' => 2, // Pieza
        'id_estado' => 2, // BUENO
        'id_adquisicion' => 13,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-014',
        'nombre' => 'Tabla espinal rígida',
        'detalle' => 'Tabla para traslado de pacientes traumáticos',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 1, // Unidad
        'id_estado' => 2,
        'id_adquisicion' => 14,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-015',
        'nombre' => 'Collar cervical ajustable',
        'detalle' => 'Collar ortopédico para inmovilización',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 2,
        'id_estado' => 1,
        'id_adquisicion' => 15,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-016',
        'nombre' => 'Camilla de transporte plegable',
        'detalle' => 'Camilla liviana para emergencias',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 1, // Mobiliario
        'id_unidad' => 1,
        'id_estado' => 1,
        'id_adquisicion' => 16,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-017',
        'nombre' => 'Botiquín de emergencias',
        'detalle' => 'Botiquín equipado para primeros auxilios',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 8, // Insumos permanentes
        'id_unidad' => 3, // Caja
        'id_estado' => 2,
        'id_adquisicion' => 17,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-018',
        'nombre' => 'Radio comunicador portátil',
        'detalle' => 'Radio de comunicación para emergencias',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 15, // Telecomunicaciones
        'id_unidad' => 1,
        'id_estado' => 1,
        'id_adquisicion' => 18,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-019',
        'nombre' => 'Maletín de vía aérea',
        'detalle' => 'Set de equipos para manejo avanzado de vía aérea',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 5, // Set
        'id_estado' => 1,
        'id_adquisicion' => 19,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-020',
        'nombre' => 'Silla de ruedas plegable',
        'detalle' => 'Silla de transporte para pacientes',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 1,
        'id_unidad' => 1,
        'id_estado' => 2,
        'id_adquisicion' => 20,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-021',
        'nombre' => 'Equipo de oxigenoterapia portátil',
        'detalle' => 'Cilindro portátil con regulador',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6,
        'id_unidad' => 6,
        'id_estado' => 1,
        'id_adquisicion' => 21,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-022',
        'nombre' => 'Tensiómetro digital profesional',
        'detalle' => 'Monitor de presión arterial',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6,
        'id_unidad' => 2,
        'id_estado' => 1,
        'id_adquisicion' => 22,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-023',
        'nombre' => 'Estetoscopio clínico',
        'detalle' => 'Estetoscopio de alta sensibilidad',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 2,
        'id_estado' => 2,
        'id_adquisicion' => 23,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-024',
        'nombre' => 'Maletín de trauma',
        'detalle' => 'Kit para manejo de traumatismos',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 5,
        'id_estado' => 1,
        'id_adquisicion' => 24,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-025',
        'nombre' => 'Linterna táctica médica',
        'detalle' => 'Linterna de bolsillo para emergencias',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6,
        'id_unidad' => 2,
        'id_estado' => 2,
        'id_adquisicion' => 25,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-026',
        'nombre' => 'Electrocardiógrafo portátil',
        'detalle' => 'Equipo portátil para ECG',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6,
        'id_unidad' => 6,
        'id_estado' => 1,
        'id_adquisicion' => 26,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-027',
        'nombre' => 'Tirantes de inmovilización',
        'detalle' => 'Cintas para asegurar pacientes a camillas o tablas',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 5,
        'id_estado' => 2,
        'id_adquisicion' => 27,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-028',
        'nombre' => 'Termómetro infrarrojo',
        'detalle' => 'Termómetro sin contacto',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6,
        'id_unidad' => 2,
        'id_estado' => 1,
        'id_adquisicion' => 28,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-029',
        'nombre' => 'Inmovilizador de cabeza',
        'detalle' => 'Inmovilizador rígido para emergencias',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 1,
        'id_estado' => 1,
        'id_adquisicion' => 29,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-030',
        'nombre' => 'Manta térmica de emergencia',
        'detalle' => 'Manta aluminizada para shock térmico',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 8, // Insumos permanentes
        'id_unidad' => 2,
        'id_estado' => 2,
        'id_adquisicion' => 30,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
      [
        'codigo' => 'AMD-EMG-031',
        'nombre' => 'Talonera inmovilizadora',
        'detalle' => 'Inmovilizador para extremidades inferiores',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17, // Emergencias
        'id_unidad' => 2, // Pieza
        'id_estado' => 2,
        'id_adquisicion' => 31,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-032',
        'nombre' => 'Kit de inmovilización pediátrico',
        'detalle' => 'Set de inmovilización para pacientes pediátricos',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 5, // Set
        'id_estado' => 1,
        'id_adquisicion' => 32,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-033',
        'nombre' => 'Bomba de aspiración portátil',
        'detalle' => 'Equipo para succión en emergencias',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6, // Electromedicina
        'id_unidad' => 6, // Equipo
        'id_estado' => 2,
        'id_adquisicion' => 33,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-034',
        'nombre' => 'Cánula orofaríngea',
        'detalle' => 'Dispositivo para mantener vía aérea permeable',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 2, // Pieza
        'id_estado' => 1,
        'id_adquisicion' => 34,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-035',
        'nombre' => 'Nebulizador portátil',
        'detalle' => 'Equipo para nebulización en emergencias',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6,
        'id_unidad' => 6,
        'id_estado' => 2,
        'id_adquisicion' => 35,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-036',
        'nombre' => 'Bolsa para hipotermia',
        'detalle' => 'Bolsa especial para tratamiento de hipotermia',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 8, // Insumos permanentes
        'id_unidad' => 2,
        'id_estado' => 1,
        'id_adquisicion' => 36,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-037',
        'nombre' => 'Sonda de aspiración',
        'detalle' => 'Sonda médica para succión de secreciones',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 2,
        'id_estado' => 2,
        'id_adquisicion' => 37,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-038',
        'nombre' => 'Mochila médica de respuesta rápida',
        'detalle' => 'Mochila equipada para atención en campo',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 17,
        'id_unidad' => 5, // Set / mezcla de insumos
        'id_estado' => 1,
        'id_adquisicion' => 38,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-039',
        'nombre' => 'Laringoscopio con luz LED',
        'detalle' => 'Equipo para intubación endotraqueal',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 6, // Electromedicina
        'id_unidad' => 6,
        'id_estado' => 2,
        'id_adquisicion' => 39,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'codigo' => 'AMD-EMG-040',
        'nombre' => 'Kit de curaciones avanzado',
        'detalle' => 'Set completo para manejo de heridas',
        'estado_situacional' => 'inactivo',
        'id_categoria' => 8, // Insumos permanentes
        'id_unidad' => 5, 
        'id_estado' => 1,
        'id_adquisicion' => 40,
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
