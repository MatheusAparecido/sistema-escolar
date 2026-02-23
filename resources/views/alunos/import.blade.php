@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <title>Importar Alunos</title>
    </head>

    <body style="font-family: Arial; background:#f5f6fa; margin:0; padding:0;">

        <div
            style="
    max-width:500px;
    margin:60px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
">

            <h2 style="margin-bottom:20px;">📥 Importar Alunos (CSV)</h2>

            @if (session('success'))
                <div
                    style="
            background:#d4edda;
            color:#155724;
            padding:10px;
            border-radius:5px;
            margin-bottom:15px;
        ">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('alunos.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label style="font-weight:bold;">Selecione o arquivo CSV:</label>

                <input type="file" name="arquivo" required
                    style="
            display:block;
            margin-top:10px;
            margin-bottom:20px;
        ">

                <button type="submit"
                    style="
            width:100%;
            padding:12px;
            background:#007bff;
            color:white;
            border:none;
            border-radius:5px;
            font-size:16px;
            cursor:pointer;
        ">
                    Importar
                </button>
            </form>

            <hr style="margin:25px 0;">

            <p style="font-size:14px; color:#555;">
                📌 <strong>Formato esperado do CSV:</strong><br>
                nome, ra, sala
            </p>

            <p style="font-size:13px; color:#888;">
                Exemplo:<br>
                João Silva,12345,6A
            </p>

            <a href="{{ route('salas.index') }}"
                style="
        display:inline-block;
        margin-top:20px;
        text-decoration:none;
        color:#007bff;
    ">
                ← Voltar para Salas
            </a>

        </div>

    </body>

    </html>
@endsection
