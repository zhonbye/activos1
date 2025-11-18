<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id('id_servicio');
            $table->string('nombre');
            $table->string('descripcion', 200)->nullable();

            // Declaramos id_responsable como unsignedBigInteger
            $table->unsignedBigInteger('id_responsable');

            // Definimos la FK explícitamente porque la pk en responsables es id_responsable
            $table->foreign('id_responsable')
                ->references('id_responsable')
                ->on('responsables')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });

        // Insertamos datos de prueba
    DB::table('servicios')->insert([
    ['nombre' => 'Activos fijos', 'descripcion' => 'Área encargada de la gestión de activos fijos', 'id_responsable' => 1, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Ginecología', 'descripcion' => 'Área de ginecología y atención a pacientes femeninas', 'id_responsable' => 2, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Pediatría', 'descripcion' => 'Área de atención a niños y adolescentes', 'id_responsable' => 3, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Laboratorio', 'descripcion' => 'Área de análisis clínicos y laboratorio', 'id_responsable' => 4, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Radiología', 'descripcion' => 'Área de estudios de imagen y diagnóstico', 'id_responsable' => 5, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Farmacia', 'descripcion' => 'Área de distribución y control de medicamentos', 'id_responsable' => 6, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Emergencias', 'descripcion' => 'Área de atención de urgencias y emergencias', 'id_responsable' => 7, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Enfermería', 'descripcion' => 'Área de enfermería y atención a pacientes', 'id_responsable' => 8, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Administración', 'descripcion' => 'Área administrativa del hospital', 'id_responsable' => 9, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Auxiliar de Enfermería', 'descripcion' => 'Área de apoyo en enfermería', 'id_responsable' => 10, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Cirugía General', 'descripcion' => 'Área de cirugía y procedimientos quirúrgicos', 'id_responsable' => 11, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Urología', 'descripcion' => 'Área de diagnóstico y tratamiento urológico', 'id_responsable' => 12, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Cardiología', 'descripcion' => 'Área de atención y estudio cardiológico', 'id_responsable' => 13, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Traumatología', 'descripcion' => 'Área de ortopedia y traumatología', 'id_responsable' => 14, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Nutrición', 'descripcion' => 'Área de dietética y nutrición', 'id_responsable' => 15, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Fisioterapia', 'descripcion' => 'Área de rehabilitación y fisioterapia', 'id_responsable' => 16, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Psicología', 'descripcion' => 'Área de atención psicológica y soporte emocional', 'id_responsable' => 17, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Servicios Generales', 'descripcion' => 'Área de mantenimiento, limpieza y apoyo logístico', 'id_responsable' => 18, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Nutrición Clínica', 'descripcion' => 'Área de planificación de dietas y soporte nutricional', 'id_responsable' => 19, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Docencia e Investigación', 'descripcion' => 'Área de formación y estudios médicos', 'id_responsable' => 20, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
['nombre' => 'Dirección', 'descripcion' => 'Área de dirección del hospital', 'id_responsable' => 21, 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
]);

    }

    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
