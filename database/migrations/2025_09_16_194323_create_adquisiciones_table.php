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
      [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:10:00',
        'updated_at' => '2025-01-03 00:10:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:11:00',
        'updated_at' => '2025-01-03 00:11:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:12:00',
        'updated_at' => '2025-01-03 00:12:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:13:00',
        'updated_at' => '2025-01-03 00:13:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:14:00',
        'updated_at' => '2025-01-03 00:14:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:15:00',
        'updated_at' => '2025-01-03 00:15:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:16:00',
        'updated_at' => '2025-01-03 00:16:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:17:00',
        'updated_at' => '2025-01-03 00:17:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:18:00',
        'updated_at' => '2025-01-03 00:18:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:19:00',
        'updated_at' => '2025-01-03 00:19:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:20:00',
        'updated_at' => '2025-01-03 00:20:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:21:00',
        'updated_at' => '2025-01-03 00:21:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:22:00',
        'updated_at' => '2025-01-03 00:22:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:23:00',
        'updated_at' => '2025-01-03 00:23:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:24:00',
        'updated_at' => '2025-01-03 00:24:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:25:00',
        'updated_at' => '2025-01-03 00:25:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:26:00',
        'updated_at' => '2025-01-03 00:26:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:27:00',
        'updated_at' => '2025-01-03 00:27:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:28:00',
        'updated_at' => '2025-01-03 00:28:00',
    ],
    [
        'fecha' => '2025-01-03',
        'tipo' => 'OTRO',
        'comentarios' => '',
        'id_usuario' => 1,
        'created_at' => '2025-01-03 00:29:00',
        'updated_at' => '2025-01-03 00:29:00',
    ],
    [
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:30:00',
    'updated_at' => '2025-01-03 00:30:00',
],
[
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:31:00',
    'updated_at' => '2025-01-03 00:31:00',
],
[
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:32:00',
    'updated_at' => '2025-01-03 00:32:00',
],
[
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:33:00',
    'updated_at' => '2025-01-03 00:33:00',
],
[
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:34:00',
    'updated_at' => '2025-01-03 00:34:00',
],
[
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:35:00',
    'updated_at' => '2025-01-03 00:35:00',
],
[
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:36:00',
    'updated_at' => '2025-01-03 00:36:00',
],
[
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:37:00',
    'updated_at' => '2025-01-03 00:37:00',
],
[
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:38:00',
    'updated_at' => '2025-01-03 00:38:00',
],
[
    'fecha' => '2025-01-03',
    'tipo' => 'OTRO',
    'comentarios' => '',
    'id_usuario' => 1,
    'created_at' => '2025-01-03 00:39:00',
    'updated_at' => '2025-01-03 00:39:00',
],

]);


    }

    public function down(): void
    {
        Schema::dropIfExists('adquisiciones');
    }
};
