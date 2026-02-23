<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ocorrencia;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;



class OcorrenciaController extends Controller
{
    public function index(Request $request)
    {
        $query = Ocorrencia::with('aluno.sala');

        if ($request->aluno_id) {
            $query->where('aluno_id', $request->aluno_id);
        }

        if ($request->sala_id) {
            $query->whereHas('aluno', function ($q) use ($request) {
                $q->where('sala_id', $request->sala_id);
            });
        }

        $ocorrencias = $query->get();
        $alunos = Aluno::all();

        return view('ocorrencias.index', compact('ocorrencias', 'alunos'));
    }

    public function store(Request $request)
    {
        Ocorrencia::create([
            'aluno_id' => $request->aluno_id,
            'user_id' => auth()->id(),
            'descricao' => $request->descricao,
            'data' => $request->data,
            'professor_nome' => $request->professor_nome
        ]);

        return redirect()->back()->with('success', 'Ocorrência cadastrada!');
    }

    public function exportarPDF()
    {
        $ocorrencias = Ocorrencia::with('aluno.sala')->get();

        $pdf = Pdf::loadView('ocorrencias.pdf', compact('ocorrencias'));

        return $pdf->download('ocorrencias.pdf');
    }

    public function update(Request $request, $id)
    {
        $ocorrencia = Ocorrencia::findOrFail($id);

        $ocorrencia->update([
            'descricao' => $request->descricao,
            'data' => $request->data,
            'professor_nome' => $request->professor_nome
        ]);

        return back()->with('success', 'Ocorrência atualizada!');
    }

    public function destroy($id)
    {
        $ocorrencia = Ocorrencia::findOrFail($id);
        $ocorrencia->delete();

        return back()->with('success', 'Ocorrência excluída!');
    }
}
