<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Ocorrencia;
use App\Models\Sala;
use App\Models\TipoOcorrencia;
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
        if (!$request->hasFile('file')) {
            return back()->with('error', 'Nenhum arquivo enviado.');
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return back()->with('error', 'Arquivo inválido.');
        }

        $linhas = array_map(function ($linha) {
            return str_getcsv($linha, ';');
        }, file($file->getRealPath()));
        unset($linhas[0]);

        foreach ($linhas as $linha) {

            if (count($linha) < 8) continue;

            $nome = trim($linha[1]);
            $ra = trim($linha[2]) . trim($linha[3]);
            $dataNascimento = $linha[4];
            $emailMicrosoft = trim($linha[5]);
            $emailGoogle = trim($linha[6]);
            $nomeSala = trim($linha[7]);

            try {
                $dataNascimento = \Carbon\Carbon::parse($dataNascimento)->format('Y-m-d');
            } catch (\Exception $e) {
                $dataNascimento = null;
            }

            $sala = \App\Models\Sala::firstOrCreate([
                'nome' => $nomeSala
            ]);

            \App\Models\Aluno::updateOrCreate(
                ['ra' => $ra],
                [
                    'nome' => $nome,
                    'data_nascimento' => $dataNascimento,
                    'email_microsoft' => $emailMicrosoft,
                    'email_google' => $emailGoogle,
                    'sala_id' => $sala->id,
                ]
            );
        }

        return back()->with('success', 'Importação realizada com sucesso!');
    }

    public function porSala($id)
    {
        $sala = Sala::findOrFail($id);

        $alunos = Aluno::where('sala_id', $id)->get();

        return view('alunos.index', compact('alunos', 'sala'));
    }

    public function show(Request $request, $id)
    {
        $aluno = Aluno::with('sala')->findOrFail($id);

        $tipos = TipoOcorrencia::all();

        $query = Ocorrencia::with('tipo')
            ->where('aluno_id', $id);

        // 🔍 filtro por tipo
        if ($request->tipo) {
            $query->where('tipo_ocorrencia_id', $request->tipo);
        }

        // 🔍 busca por descrição
        if ($request->busca) {
            $query->where('descricao', 'like', '%' . $request->busca . '%');
        }

        // 📄 paginação
        $ocorrencias = $query->latest()->paginate(5);

        return view('alunos.show', compact('aluno', 'tipos', 'ocorrencias'));
    }

    public function exportarPDF($id)
    {
        $aluno = Aluno::with('sala', 'ocorrencias')->findOrFail($id);

        $pdf = Pdf::loadView('alunos.pdf', compact('aluno'));

        return $pdf->download('aluno_' . $aluno->nome . '.pdf');
    }
}
