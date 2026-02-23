@extends('layouts.app')

@section('content')
    <h2>Alunos da Sala: {{ $sala->nome }}</h2>

    <a style="
            display:inline-block;
            margin-top:10px;
            padding:8px 12px;
            background:#007bff;
            color:white;
            border-radius:5px;
            text-decoration:none;
        "
        href="{{ route('salas.index') }}">Voltar</a>


    <hr>

    <table border="1" width="100%" cellpadding="10">
        <tr>
            <th>Nome</th>
            <th>RA</th>
            <th>Ações</th>
        </tr>

        @foreach ($alunos as $aluno)
            <tr>
                <td>{{ $aluno->nome }}</td>
                <td>{{ $aluno->ra }}</td>
                <td>

                    <!-- BOTÃO OLHO -->
                    <a href="{{ route('alunos.show', $aluno->id) }}" title="Ver ficha">
                        👁️
                    </a>

                </td>
            </tr>
        @endforeach

    </table>
@endsection
