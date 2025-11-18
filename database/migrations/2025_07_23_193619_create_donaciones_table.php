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
        'id_adquisicion' => 4,
        'id_donante' => 2,
        'motivo' => 'Donación benéfica',
        'precio' => 300.00,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'id_adquisicion' => 5,
        'id_donante' => 1,
        'motivo' => 'Donación benéfica',
        'precio' => 200.00,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'id_adquisicion' => 6,
        'id_donante' => 1,
        'motivo' => 'Donación benéfica',
        'precio' => 900.00,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
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
