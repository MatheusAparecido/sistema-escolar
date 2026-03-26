<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Ocorrencia;
use App\Models\Professor;
use App\Models\Professores;
use App\Models\Sala;
use App\Models\TipoOcorrencia;
use App\Services\AlunoImportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function form()
    {
        $salas = Sala::all();
        return view('alunos.import', compact('salas'));
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

        // 🔥 sala obrigatória (dropdown)
        $sala = Sala::find($request->sala_id);

        if (!$sala) {
            return back()->with('error', 'Selecione uma sala válida.');
        }

        $conteudo = file($file->getRealPath());

        if (!$conteudo) {
            return back()->with('error', 'Erro ao ler o arquivo.');
        }

        $linhas = array_map(function ($linha) {
            return str_getcsv($linha, ';');
        }, $conteudo);

        unset($linhas[0]); // remove cabeçalho (linha 1)

        foreach ($linhas as $linha) {

            // 🔥 garante que tem pelo menos até coluna G
            if (count($linha) < 7) continue;

            $nome = trim($linha[1]); // coluna B

            // 🔥 RA continua juntando C + D
            $ra = preg_replace('/\s+/', '', trim(($linha[2] ?? '') . ($linha[3] ?? '')));

            $dataNascimento = $linha[4] ?? null; // coluna E

            // 🔥 SITUAÇÃO = coluna G
            $situacao = strtolower(trim($linha[6] ?? ''));

            // 🔥 só importa ATIVOS
            if ($situacao !== 'ativo') {
                continue;
            }

            try {
                $dataNascimento = \Carbon\Carbon::parse($dataNascimento)->format('Y-m-d');
            } catch (\Exception $e) {
                $dataNascimento = null;
            }

            // 🔥 salva ou atualiza pelo RA
            Aluno::updateOrCreate(
                ['ra' => $ra],
                [
                    'nome' => $nome,
                    'data_nascimento' => $dataNascimento,
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

        $professores = Professores::orderBy('nome')->get() ?? collect();

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

        return view('alunos.show', compact('aluno', 'tipos', 'ocorrencias', 'professores'));
    }

    public function exportarPDF($id)
    {
        $aluno = Aluno::with('sala', 'ocorrencias')->findOrFail($id);

        $pdf = Pdf::loadView('alunos.pdf', compact('aluno'));

        return $pdf->download('aluno_' . $aluno->nome . '.pdf');
    }
}
