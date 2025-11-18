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
        Schema::create('cargos', function (Blueprint $table) {
    $table->id('id_cargo');
    $table->string('nombre', 100)->unique();
    $table->string('abreviatura', 10)->nullable(); // Nueva columna
    $table->timestamps();
});

// Insertar datos con abreviaturas
DB::table('cargos')->insert([
    // MÉDICOS Y PERSONAL DE SALUD (los más comunes)
    ['nombre' => 'Médico', 'abreviatura' => 'Dr.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Médica', 'abreviatura' => 'Dra.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Cirujano', 'abreviatura' => 'Ciru.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Cirujana', 'abreviatura' => 'Cira.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Anestesiólogo', 'abreviatura' => 'Anes.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Anestesióloga', 'abreviatura' => 'Anes.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Enfermero', 'abreviatura' => 'Enf.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Enfermera', 'abreviatura' => 'Enf.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Licenciado en Enfermería', 'abreviatura' => 'Lic.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Licenciada en Enfermería', 'abreviatura' => 'Lic.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Ginecólogo', 'abreviatura' => 'Gine.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Ginecóloga', 'abreviatura' => 'Gine.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Pediatra', 'abreviatura' => 'Ped.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Internista', 'abreviatura' => 'Int.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Emergenciólogo', 'abreviatura' => 'Emerg.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Emergencióloga', 'abreviatura' => 'Emerg.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Radiólogo', 'abreviatura' => 'Rad.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Radióloga', 'abreviatura' => 'Rad.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Odontólogo', 'abreviatura' => 'Odont.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Odontóloga', 'abreviatura' => 'Odont.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Tecnólogo Médico', 'abreviatura' => 'Tec.Med.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Tecnóloga Médica', 'abreviatura' => 'Tec.Med.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Auxiliar de Enfermería', 'abreviatura' => 'Aux.Enf.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Auxiliar de Laboratorio', 'abreviatura' => 'Aux.Lab.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],

    // PERSONAL TÉCNICO
    ['nombre' => 'Técnico en Laboratorio', 'abreviatura' => 'Tec.Lab.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Técnica en Laboratorio', 'abreviatura' => 'Tec.Lab.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Técnico en Radiología', 'abreviatura' => 'Tec.Rad.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Técnica en Radiología', 'abreviatura' => 'Tec.Rad.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Técnico en Farmacia', 'abreviatura' => 'Tec.Farm.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Técnica en Farmacia', 'abreviatura' => 'Tec.Farm.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'licenciado', 'abreviatura' => 'Lic.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'licenciada', 'abreviatura' => 'Lic.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],

    // PERSONAL ADMINISTRATIVO
    ['nombre' => 'Administrador', 'abreviatura' => 'Adm.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Administradora', 'abreviatura' => 'Adm.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Secretario', 'abreviatura' => 'Sec.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Secretaria', 'abreviatura' => 'Sec.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Contador', 'abreviatura' => 'Cont.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Contadora', 'abreviatura' => 'Cont.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Auxiliar Administrativo', 'abreviatura' => 'Aux.Adm.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Auxiliar Administrativa', 'abreviatura' => 'Aux.Adm.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],

    // PERSONAL DE SERVICIO
    ['nombre' => 'Portero', 'abreviatura' => 'Port.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Portera', 'abreviatura' => 'Port.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Conserje', 'abreviatura' => 'Cons.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Operario de Limpieza', 'abreviatura' => 'Limp.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Operaria de Limpieza', 'abreviatura' => 'Limp.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Chofer', 'abreviatura' => 'Chof.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Cocinero', 'abreviatura' => 'Coc.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
    ['nombre' => 'Cocinera', 'abreviatura' => 'Coc.', 'created_at' => '2025-01-01 00:00:00', 'updated_at' => '2025-01-01 00:00:00'],
]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
