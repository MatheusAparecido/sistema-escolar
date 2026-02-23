<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Sala;
use App\Services\AlunoImportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function form()
    {
        return view('alunos.import');
    }

    public function importar(Request $request)
    {
        $request->validate([
            'arquivo' => 'required|file|mimes:csv,txt'
        ]);

        $path = $request->file('arquivo')->getRealPath();

        $file = fopen($path, 'r');

        // Pular cabeçalho
        fgetcsv($file);

        while (($row = fgetcsv($file, 1000, ',')) !== FALSE) {

            $nome = $row[0];
            $ra = $row[1];
            $salaNome = $row[2];

            // Criar ou buscar sala
            $sala = Sala::where('nome', $salaNome)->first();

            if (!$sala) {
                continue; // pula se não encontrar
            }

            // Atualizar ou criar aluno pelo RA
            Aluno::updateOrCreate(
                ['ra' => $ra],
                [
                    'nome' => $nome,
                    'sala_id' => $sala->id
                ]
            );
        }

        fclose($file);

        return redirect()->route('salas.index')->with('success', 'Importação concluída!');
    }

    public function porSala($id)
    {
        $sala = Sala::findOrFail($id);

        $alunos = Aluno::where('sala_id', $id)->get();

        return view('alunos.index', compact('alunos', 'sala'));
    }

    public function show($id)
    {
        $aluno = Aluno::with('sala', 'ocorrencias')->findOrFail($id);

        return view('alunos.show', compact('aluno'));
    }

    public function exportarPDF($id)
    {
        $aluno = Aluno::with('sala', 'ocorrencias')->findOrFail($id);

        $pdf = Pdf::loadView('alunos.pdf', compact('aluno'));

        return $pdf->download('aluno_' . $aluno->nome . '.pdf');
    }
}
