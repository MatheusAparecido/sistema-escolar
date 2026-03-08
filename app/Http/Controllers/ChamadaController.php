<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChamadaController extends Controller
{
    public function registrar(Request $request)
    {
        foreach ($request->alunos as $aluno) {

            DB::table('presencas')->insert([
                'aluno_id' => $aluno['id'],
                'data' => today(),
                'presente' => $aluno['presente']
            ]);

            if (!$aluno['presente']) {
                $this->verificarFaltas($aluno['id']);
            }
        }

        return response()->json([
            'status' => 'ok'
        ]);
    }

    private function verificarFaltas($aluno_id)
    {
        $presencas = DB::table('presencas')
            ->where('aluno_id', $aluno_id)
            ->orderBy('data', 'desc')
            ->limit(3)
            ->get();

        if ($presencas->count() < 3) {
            return;
        }

        foreach ($presencas as $p) {
            if ($p->presente) {
                return;
            }
        }

        $aluno = DB::table('alunos')->where('id', $aluno_id)->first();

        $mensagem = "ALERTA BUSCA ATIVA\n";
        $mensagem .= "Aluno: " . $aluno->nome . "\n";
        $mensagem .= "3 faltas consecutivas\n";
        $mensagem .= "Responsável: " . $aluno->telefone_responsavel;

        $this->enviarMensagem($mensagem);
    }


    private function enviarMensagem($mensagem)
    {
        $numeroEscola = "559999999999";

        $url = "https://api.whatsapp.com/send?phone=" . $numeroEscola . "&text=" . urlencode($mensagem);

        // logar mensagem
        Log::info($url);
    }

    public function mensal($sala, $mes)
    {

        $alunos = DB::table('alunos')
            ->where('sala_id', $sala)
            ->get();

        $presencas = DB::table('presencas')
            ->whereMonth('data', $mes)
            ->get()
            ->groupBy('aluno_id');

        $dias = range(1, 31);

        $pdf = Pdf::loadView('relatorios.calendario', [
            'alunos' => $alunos,
            'presencas' => $presencas,
            'dias' => $dias
        ]);

        return $pdf->download('chamada-mensal.pdf');
    }
}
