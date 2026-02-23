<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salas', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // ex: 2A
            $table->string('serie'); // ex: 2
            $table->string('turma'); // ex: A
            $table->string('curso')->nullable(); // ADM, DES, VND
            $table->string('tipo'); // regular ou tecnico
            $table->string('periodo')->nullable(); // manha, noite
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salas');
    }
};
