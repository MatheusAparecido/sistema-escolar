@extends('layouts.app')

@section('content')
    <div
        style="max-width:500px; margin:60px auto; background:white; padding:30px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1);">

        <h2 style="margin-bottom:20px;">📥 Importar Alunos (CSV)</h2>

        @if (session('success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('alunos.import') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label><strong>Selecione o arquivo CSV:</strong></label>

            <input type="file" name="file" required style="display:block; margin-top:10px; margin-bottom:20px;">

            <button type="submit"
                style="width:100%; padding:12px; background:#007bff; color:white; border:none; border-radius:5px;">
                Importar
            </button>

            <a href="{{ route('salas.index') }}"
                style="
        display:block;
        margin-top:15px;
        text-align:center;
        padding:10px;
        background:#6c757d;
        color:white;
        border-radius:5px;
        text-decoration:none;
    ">
                ← Voltar para Salas
            </a>
        </form>

    </div>
@endsection
