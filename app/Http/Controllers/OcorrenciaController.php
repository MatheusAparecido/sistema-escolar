<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ocorrencia;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('ocorrencias', 'public');
        } else {
            $path = null;
        }
        Ocorrencia::create([
            'aluno_id' => $request->aluno_id,
            'descricao' => $request->descricao,
            'professor_nome' => $request->professor_nome,
            'data' => $request->data,
            'tipo_ocorrencia_id' => $request->tipo_ocorrencia_id,
            'codigo_conviva' => $request->codigo_conviva,
            'foto' => $path,
            'user_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Ocorrência cadastrada!');
    }


    public function export(Request $request)
    {
        $query = Ocorrencia::with('aluno.sala');

        if ($request->sala_id) {
            $query->whereHas('aluno', function ($q) use ($request) {
                $q->where('sala_id', $request->sala_id);
            });
        }

        $ocorrencias = $query->get();

        $pdf = Pdf::loadView('ocorrencias.pdf', compact('ocorrencias'));

        return $pdf->download('ocorrencias.pdf');
    }
    private function gerarPdf($ocorrencias)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ocorrencias.pdf', compact('ocorrencias'));

        return $pdf->download('ocorrencias.pdf');
    }

    public function update(Request $request, $id)
    {
        $ocorrencia = Ocorrencia::findOrFail($id);
        $data = [
            'descricao' => $request->descricao,
            'professor_nome' => $request->professor_nome,
            'data' => $request->data,
            'tipo_ocorrencia_id' => $request->tipo_ocorrencia_id,
            'codigo_conviva' => $request->codigo_conviva,
        ];
        if ($request->remover_foto) {
            Storage::disk('public')->delete($ocorrencia->foto);
            $data['foto'] = null;
        }
        if ($request->hasFile('foto')) {


            if ($ocorrencia->foto) {
                Storage::disk('public')->delete($ocorrencia->foto);
            }

            $data['foto'] = $request->file('foto')->store('ocorrencias', 'public');
        }

        $ocorrencia->update($data);

        return back()->with('success', 'Ocorrência atualizada!');
    }

    public function destroy($id)
    {
        $ocorrencia = Ocorrencia::findOrFail($id);
        $ocorrencia->delete();

        return back()->with('success', 'Ocorrência excluída!');
    }

    public function exportPage()
    {
        $ocorrencias = Ocorrencia::with('aluno')->get();
        return view('ocorrencias.export', compact('ocorrencias'));
    }

    public function exportTodas()
    {
        $ocorrencias = Ocorrencia::with('aluno.sala', 'tipo')->get();

        return $this->gerarPdf($ocorrencias);
    }

    public function exportSelecionadas(Request $request)
    {
        $ids = $request->ocorrencias;

        $ocorrencias = Ocorrencia::with('aluno.sala', 'tipo')
            ->whereIn('id', $ids)
            ->get();

        return $this->gerarPdf($ocorrencias);
    }
}
