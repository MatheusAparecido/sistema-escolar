@extends('layouts.app')

@section('content')
    <div style="max-width:800px; margin:auto; font-family:Arial;">

        <div style="background:#fff; padding:20px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1);">
            <h2>👤 {{ $aluno->nome }}</h2>

            <p><strong>RA:</strong> {{ $aluno->ra }}</p>
            <p><strong>Sala:</strong> {{ $aluno->sala->nome }}</p>

            <a href="{{ route('alunos.pdf', $aluno->id) }}"
                style="
            display:inline-block;
            margin-top:10px;
            padding:8px 12px;
            background:#007bff;
            color:white;
            border-radius:5px;
            text-decoration:none;
        ">
                Exportar PDF
            </a>


            <a style="
            display:inline-block;
            margin-top:10px;
            padding:8px 12px;
            background:#007bff;
            color:white;
            border-radius:5px;
            text-decoration:none;
        "
                href="{{ route('salas.alunos', $aluno->sala->id) }}" class="btn btn-secondary">
                Voltar
            </a>

        </div>


        <br>

        <!-- NOVA OCORRÊNCIA -->
        <div style="background:#fff; padding:20px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1);">
            <h3>➕ Nova Ocorrência</h3>

            <form action="/ocorrencias" method="POST">
                @csrf

                <input type="hidden" name="aluno_id" value="{{ $aluno->id }}">

                <input type="text" name="professor_nome" placeholder="Nome do professor" required
                    style="width:100%; margin-bottom:10px; padding:8px;">

                <input type="date" name="data" required style="margin-bottom:10px; padding:8px;">

                <textarea name="descricao" placeholder="Descrição..." required style="width:100%; height:80px; padding:8px;"></textarea>

                <br><br>

                <button style="background:#28a745; color:white; padding:10px; border:none; border-radius:5px;">
                    Salvar
                </button>
            </form>
        </div>

        <br>

        <!-- OCORRÊNCIAS -->
        <div style="background:#fff; padding:20px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.1);">
            <h3>📋 Ocorrências</h3>

            @forelse($aluno->ocorrencias as $oc)
                <div style="border-bottom:1px solid #eee; padding:10px 0;">

                    <p><strong>📅 {{ $oc->data_formatada }}</strong></p>
                    <p><strong>👩‍🏫 {{ $oc->professor_nome }}</strong></p>

                    <form action="{{ route('ocorrencias.update', $oc->id) }}" method="POST" style="margin-bottom:10px;">
                        @csrf
                        @method('PUT')

                        <label>Professor:</label>
                        <input type="text" name="professor_nome" value="{{ $oc->professor_nome }}"
                            style="width:100%; margin-bottom:5px;">

                        <label>Data:</label>
                        <input type="date" name="data" value="{{ $oc->data }}" style="margin-bottom:5px;">

                        <label>Descrição:</label>
                        <textarea name="descricao" style="width:100%;">{{ $oc->descricao }}</textarea>

                        <br>

                        <button type="submit">💾 Atualizar</button>
                    </form>
                </div>
            @empty
                <p>Nenhuma ocorrência registrada.</p>
            @endforelse

        </div>


    </div>
@endsection
