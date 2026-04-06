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
            $table->text('relato_aluno')->nullable();
            $table->date('data_relato_aluno')->nullable();

            $table->text('relato_responsavel')->nullable();
            $table->date('data_relato_responsavel')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ocorrencias', function (Blueprint $table) {
            $table->dropColumn([
                'relato_aluno',
                'data_relato_aluno',
                'relato_responsavel',
                'data_relato_responsavel'
            ]);
        });
    }
};
