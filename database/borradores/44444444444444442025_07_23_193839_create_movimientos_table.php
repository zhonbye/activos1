<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->unsignedBigInteger('id_docto');
            $table->unsignedBigInteger('id_activo');
            $table->integer('cantidad');
            $table->unsignedBigInteger('origen');
            $table->unsignedBigInteger('destino');
            $table->string('motivo', 100);
            $table->text('comentarios')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('id_docto')->references('id_docto')->on('doctos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_activo')->references('id_activo')->on('activos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('origen')->references('id_ubicacion')->on('ubicaciones')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('destino')->references('id_ubicacion')->on('ubicaciones')->onDelete('restrict')->onUpdate('cascade');
        });

        // Ejemplo de inserción de prueba
        DB::table('movimientos')->insert([
            'id_docto' => 1,
            'id_activo' => 1,
            'cantidad' => 1,
            'origen' => 1,
            'destino' => 2,
            'motivo' => 'Traslado a nuevo ambiente',
            'comentarios' => 'Traslado solicitado por mantenimiento',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
