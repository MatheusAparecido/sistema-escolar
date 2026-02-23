<?php

namespace App\Services;

use App\Models\Aluno;

class AlunoImportService
{
    public function importar($arquivo)
    {
        $handle = fopen($arquivo, 'r');

        if (!$handle) {
            throw new \Exception('Erro ao abrir o arquivo.');
        }

        $header = true;

        while (($row = fgetcsv($handle, 1000, ",")) !== false) {

            if ($header) {
                $header = false;
                continue;
            }

            $ra = $row[0];
            $nome = $row[1];
            $sala_id = $row[2];

            Aluno::updateOrCreate(
                ['ra' => $ra],
                [
                    'nome' => $nome,
                    'sala_id' => $sala_id
                ]
            );
        }

        fclose($handle);
    }
}
