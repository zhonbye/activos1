<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bajas', function (Blueprint $table) {
            $table->id('id_baja');
            $table->unsignedBigInteger('id_docto');
            $table->unsignedBigInteger('id_activo');
            $table->date('fecha_baja');
            $table->string('motivo', 100);
            $table->unsignedBigInteger('id_responsable');
            $table->unsignedBigInteger('id_ubicacion');
            $table->text('comentarios')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('id_docto')->references('id_docto')->on('doctos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_activo')->references('id_activo')->on('activos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_responsable')->references('id_responsable')->on('responsables')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_ubicacion')->references('id_ubicacion')->on('ubicaciones')->onDelete('restrict')->onUpdate('cascade');
        });

        // Inserción de ejemplo
        DB::table('bajas')->insert([
            'id_docto' => 1,
            'id_activo' => 1,
            'fecha_baja' => now()->toDateString(),
            'motivo' => 'Activo obsoleto',
            'id_responsable' => 1,
            'id_ubicacion' => 1,
            'comentarios' => 'El equipo ya no funciona correctamente.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('bajas');
    }
};
