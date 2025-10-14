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

            $table->timestamps();

        });

        DB::table('adquisiciones')->insert([
            ['fecha' => now()->toDateString(), 'tipo' => 'COMPRA', 'comentarios' => 'Compra inicial'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('adquisiciones');
    }
};
