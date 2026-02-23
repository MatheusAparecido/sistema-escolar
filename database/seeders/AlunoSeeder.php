<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alunos')->insert([
            ['nome' => 'João Silva', 'sala_id' => 1],
            ['nome' => 'Maria Souza', 'sala_id' => 1],
            ['nome' => 'Pedro Santos', 'sala_id' => 2],
            ['nome' => 'Ana Oliveira', 'sala_id' => 3],
            ['nome' => 'Lucas Lima', 'sala_id' => 4],
        ]);
    }
}
