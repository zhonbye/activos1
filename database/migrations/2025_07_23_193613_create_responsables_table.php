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
        Schema::create('responsables', function (Blueprint $table) {
            $table->id('id_responsable');
            $table->string('nombre', 100);
            $table->string('ci', 30)->unique();
            $table->string('telefono', 30)->nullable();

            $table->unsignedBigInteger('id_cargo');
            $table->string('rol', 50)->default('personal operativo')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo'); // estado del usuario

            $table->foreign('id_cargo')->references('id_cargo')->on('cargos')->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();
        });
DB::table('responsables')->insert([
    ['nombre' => 'Divar Gutiérrez', 'ci' => '7435345678', 'telefono' => '73718313', 'rol' => 'personal operativo', 'estado' => 'activo', 'id_cargo' => 1, 'created_at' => now(), 'updated_at' => now()], // 1 Activos Fijos
    ['nombre' => 'María Gómez', 'ci' => '87654321', 'telefono' => '74392142', 'rol' => 'personal operativo', 'estado' => 'activo', 'id_cargo' => 2, 'created_at' => now(), 'updated_at' => now()], // 2 Ginecología
    ['nombre' => 'Juan Pérez', 'ci' => '78451234', 'telefono' => '76789012', 'rol' => 'coordinador de pediatría', 'estado' => 'activo', 'id_cargo' => 3, 'created_at' => now(), 'updated_at' => now()], // 3 Pediatría
    ['nombre' => 'Lucía Flores', 'ci' => '15893241', 'telefono' => '76123478', 'rol' => 'responsable de laboratorio', 'estado' => 'activo', 'id_cargo' => 24, 'created_at' => now(), 'updated_at' => now()], // 4 Laboratorio
    ['nombre' => 'Carlos Mamani', 'ci' => '17384920', 'telefono' => '76711234', 'rol' => 'coordinador de radiología', 'estado' => 'activo', 'id_cargo' => 26, 'created_at' => now(), 'updated_at' => now()], // 5 Radiología
    ['nombre' => 'Ana Vargas', 'ci' => '14725836', 'telefono' => '76156789', 'rol' => 'responsable de farmacia', 'estado' => 'activo', 'id_cargo' => 28, 'created_at' => now(), 'updated_at' => now()], // 6 Farmacia
    ['nombre' => 'Miguel Salazar', 'ci' => '16273849', 'telefono' => '76812345', 'rol' => 'coordinador de emergencias', 'estado' => 'activo', 'id_cargo' => 15, 'created_at' => now(), 'updated_at' => now()], // 7 Emergencias
    ['nombre' => 'Sofía Rojas', 'ci' => '18374625', 'telefono' => '76123489', 'rol' => 'jefa de enfermería', 'estado' => 'activo', 'id_cargo' => 8, 'created_at' => now(), 'updated_at' => now()], // 8 Enfermería
    ['nombre' => 'Julio Cesar Rivero Pacheco', 'ci' => '00000002', 'telefono' => '70000002', 'rol' => 'Administrador', 'estado' => 'activo', 'id_cargo' => 3, 'created_at' => now(), 'updated_at' => now()], // 9 Administración
    ['nombre' => 'Elena Mamani', 'ci' => '17654321', 'telefono' => '76134567', 'rol' => 'auxiliar de enfermería', 'estado' => 'activo', 'id_cargo' => 23, 'created_at' => now(), 'updated_at' => now()], // 10 Auxiliar de Enfermería
    ['nombre' => 'Fernando Quispe', 'ci' => '19827364', 'telefono' => '76789034', 'rol' => 'administrativo', 'estado' => 'activo', 'id_cargo' => 33, 'created_at' => now(), 'updated_at' => now()], // 11 Cirugía General
    ['nombre' => 'María López', 'ci' => '13934123', 'telefono' => '72123456', 'rol' => 'responsable de nutrición', 'estado' => 'activo', 'id_cargo' => 9, 'created_at' => now(), 'updated_at' => now()], // 12 Nutrición
    ['nombre' => 'Lucía Paredes', 'ci' => '12837465', 'telefono' => '76123789', 'rol' => 'responsable de fisioterapia', 'estado' => 'activo', 'id_cargo' => 16, 'created_at' => now(), 'updated_at' => now()], // 13 Fisioterapia
    ['nombre' => 'Paola Rivas', 'ci' => '19837465', 'telefono' => '76123890', 'rol' => 'responsable de psicología', 'estado' => 'activo', 'id_cargo' => 17, 'created_at' => now(), 'updated_at' => now()], // 14 Psicología
    ['nombre' => 'Juan Torres', 'ci' => '14736258', 'telefono' => '76123901', 'rol' => 'responsable de servicios generales', 'estado' => 'activo', 'id_cargo' => 18, 'created_at' => now(), 'updated_at' => now()], // 15 Servicios Generales
    ['nombre' => 'Marcela Vega', 'ci' => '17283940', 'telefono' => '76123412', 'rol' => 'responsable de nutrición clínica', 'estado' => 'activo', 'id_cargo' => 19, 'created_at' => now(), 'updated_at' => now()], // 16 Nutrición Clínica
    ['nombre' => 'Luis Gutiérrez', 'ci' => '19837491', 'telefono' => '76123423', 'rol' => 'responsable de docencia', 'estado' => 'activo', 'id_cargo' => 20, 'created_at' => now(), 'updated_at' => now()], // 17 Docencia e Investigación
    ['nombre' => 'Francisca Mamani', 'ci' => '12345678', 'telefono' => '76123456', 'rol' => 'coordinadora de cirugía', 'estado' => 'activo', 'id_cargo' => 21, 'created_at' => now(), 'updated_at' => now()], // 18 Cirugía
    ['nombre' => 'Patricia Flores', 'ci' => '23456789', 'telefono' => '76123457', 'rol' => 'coordinadora de urología', 'estado' => 'activo', 'id_cargo' => 22, 'created_at' => now(), 'updated_at' => now()], // 19 Urología
    ['nombre' => 'Oscar Pérez', 'ci' => '34567890', 'telefono' => '76123458', 'rol' => 'coordinador cardiología', 'estado' => 'activo', 'id_cargo' => 23, 'created_at' => now(), 'updated_at' => now()], // 20 Cardiología
    ['nombre' => 'Franz Gutiérrez Choque', 'ci' => '00000001', 'telefono' => '70000001', 'rol' => 'Director', 'estado' => 'activo', 'id_cargo' => 1, 'created_at' => now(), 'updated_at' => now()], // 21 Dirección
]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsables');
    }
};
