<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposOcorrenciasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_ocorrencias')->insert([
            ['nome' => 'Pedagógica'],
            ['nome' => 'Comportamental'],
            ['nome' => 'Outros'],
        ]);
    }
}
