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
        Schema::create('donaciones', function (Blueprint $table) {
            $table->id('id_adquisicion'); // PK
            $table->unsignedBigInteger('id_donante');
            $table->string('motivo',40);

            $table->decimal('precio', 10, 2)->default(0);
            $table->timestamps();

            // Relaciones (foreign keys) definidas después de los campos
            $table->foreign('id_donante')
                ->references('id_donante')->on('donantes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        DB::table('donaciones')->insert([
            [
                'id_adquisicion' => 2,
                'id_donante' => 1,
                'motivo' => 'Donación benéfica',
                'precio' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donaciones');
    }
};
