<?php

namespace Database\Seeders;

use App\Models\Sala;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaSeeder extends Seeder
{
    public function run(): void
    {
        $salas = [

            // Fundamental
            ['nome' => '6A', 'serie' => '6', 'turma' => 'A', 'tipo' => 'regular'],
            ['nome' => '6B', 'serie' => '6', 'turma' => 'B', 'tipo' => 'regular'],
            ['nome' => '7A', 'serie' => '7', 'turma' => 'A', 'tipo' => 'regular'],
            ['nome' => '7B', 'serie' => '7', 'turma' => 'B', 'tipo' => 'regular'],
            ['nome' => '8A', 'serie' => '8', 'turma' => 'A', 'tipo' => 'regular'],
            ['nome' => '8B', 'serie' => '8', 'turma' => 'B', 'tipo' => 'regular'],
            ['nome' => '9A', 'serie' => '9', 'turma' => 'A', 'tipo' => 'regular'],
            ['nome' => '9B', 'serie' => '9', 'turma' => 'B', 'tipo' => 'regular'],
            ['nome' => '9C', 'serie' => '9', 'turma' => 'C', 'tipo' => 'regular'],

            // 1º Ensino Médio
            ['nome' => '1A', 'serie' => '1', 'turma' => 'A', 'tipo' => 'regular'],
            ['nome' => '1B', 'serie' => '1', 'turma' => 'B', 'tipo' => 'regular'],
            ['nome' => '1C', 'serie' => '1', 'turma' => 'C', 'tipo' => 'regular'],
            ['nome' => '1D', 'serie' => '1', 'turma' => 'D', 'tipo' => 'regular'],
            ['nome' => '1E', 'serie' => '1', 'turma' => 'E', 'tipo' => 'regular'],
            ['nome' => '1F', 'serie' => '1', 'turma' => 'F', 'tipo' => 'regular'],
            ['nome' => '1G', 'serie' => '1', 'turma' => 'G', 'tipo' => 'regular'],

            // 2º Ensino Médio Técnico
            ['nome' => '2A', 'serie' => '2', 'turma' => 'A', 'tipo' => 'tecnico', 'curso' => 'ADM'],
            ['nome' => '2B', 'serie' => '2', 'turma' => 'B', 'tipo' => 'tecnico', 'curso' => 'ADM'],
            ['nome' => '2C', 'serie' => '2', 'turma' => 'C', 'tipo' => 'tecnico', 'curso' => 'DES'],
            ['nome' => '2D', 'serie' => '2', 'turma' => 'D', 'tipo' => 'tecnico', 'curso' => 'DES'],
            ['nome' => '2E', 'serie' => '2', 'turma' => 'E', 'tipo' => 'tecnico', 'curso' => 'VND'],
            ['nome' => '2F', 'serie' => '2', 'turma' => 'F', 'tipo' => 'tecnico', 'curso' => 'VND'],

            // 2º Regular (IMPORTANTE - nome repetido!)
            ['nome' => '2A-REG', 'serie' => '2', 'turma' => 'A', 'tipo' => 'regular'],

            // 3º Ensino Médio
            ['nome' => '3A', 'serie' => '3', 'turma' => 'A', 'tipo' => 'tecnico', 'curso' => 'ADM', 'periodo' => 'manha'],
            ['nome' => '3B', 'serie' => '3', 'turma' => 'B', 'tipo' => 'tecnico', 'curso' => 'VND', 'periodo' => 'manha'],

            ['nome' => '3A-N', 'serie' => '3', 'turma' => 'A', 'tipo' => 'regular', 'periodo' => 'noite'],
            ['nome' => '3B-N', 'serie' => '3', 'turma' => 'B', 'tipo' => 'regular', 'periodo' => 'noite'],
            ['nome' => '3C-N', 'serie' => '3', 'turma' => 'C', 'tipo' => 'regular', 'periodo' => 'noite'],
        ];

        foreach ($salas as $sala) {
            Sala::updateOrCreate(
                ['nome' => $sala['nome']], // chave única
                $sala
            );
        }
    }
}
