<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adquisiciones', function (Blueprint $table) {
            $table->id('id_adquisicion');
            $table->date('fecha');
            $table->enum('tipo', ['COMPRA', 'DONACION','OTRO']);
            $table->string('comentarios', 100)->nullable();
    $table->unsignedBigInteger('id_usuario');

            $table->timestamps();
    $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');

        });

       DB::table('adquisiciones')->insert([
    [
        'fecha' => '2025-01-03',
        'tipo' => 'COMPRA',
        'comentarios' => 'Camilla plegable para emergencias',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'COMPRA',
        'comentarios' => 'Desfibrilador portátil adquirido',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:01:00',
        'updated_at' => '2025-01-03 00:01:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'COMPRA',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:02:00',
        'updated_at' => '2025-01-03 00:02:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'DONACION',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:03:00',
        'updated_at' => '2025-01-03 00:03:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'DONACION',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:04:00',
        'updated_at' => '2025-01-03 00:04:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'DONACION',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:05:00',
        'updated_at' => '2025-01-03 00:05:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:06:00',
        'updated_at' => '2025-01-03 00:06:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:07:00',
        'updated_at' => '2025-01-03 00:07:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:08:00',
        'updated_at' => '2025-01-03 00:08:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:09:00',
        'updated_at' => '2025-01-03 00:09:00',
    ],
]);


    }

    public function down(): void
    {
        Schema::dropIfExists('adquisiciones');
    }
};
