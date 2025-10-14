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
            [
                'nombre' => 'Soporte Técnico',
                'descripcion' => 'Área de soporte técnico',
                'id_responsable' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Atención al Cliente',
                'descripcion' => 'Área de atención al cliente',
                'id_responsable' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
