<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ocorrencias', function (Blueprint $table) {
            $table->foreignId('professor_id')
                ->nullable()
                ->after('aluno_id')
                ->constrained()
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('ocorrencias', function (Blueprint $table) {
            $table->dropForeign(['professor_id']);
            $table->dropColumn('professor_id');
        });
    }
};
