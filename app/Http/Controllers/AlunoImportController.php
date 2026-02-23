<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlunoImportController extends Controller
{
    public function form()
    {
        return view('alunos.import');
    }

    public function import(Request $request)
    {
        // aqui depois vamos tratar o CSV
        return back()->with('success', 'Importação realizada!');
    }
}
