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
        Schema::table('text_on_ocorrencias', function (Blueprint $table) {
            Schema::table('ocorrencias', function (Blueprint $table) {
                $table->text('foto')->nullable()->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('text_on_ocorrencias', function (Blueprint $table) {
            //
        });
    }
};
