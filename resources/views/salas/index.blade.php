@extends('layouts.app')

@section('content')
    <h1>Salas</h1>
    <a href="{{ route('alunos.import.form') }}"
        style="
    display:inline-block;
    margin-bottom:20px;
    padding:10px 15px;
    background:#28a745;
    color:white;
    text-decoration:none;
    border-radius:5px;
">
        📄 Importar Alunos
    </a>
    @auth
        @if (auth()->user()->is_admin)
            <a href="{{ route('register') }}"
                style="
    display:inline-block;
    margin-bottom:20px;
    padding:10px 15px;
    background:#28a745;
    color:white;
    text-decoration:none;
    border-radius:5px;
"
                onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                ➕ Novo Usuário
            </a>
        @endif
    @endauth
    @php
        $fundamental = $salas->filter(fn($s) => in_array($s->serie, ['6', '7', '8', '9']));
        $medio = $salas->filter(fn($s) => in_array($s->serie, ['1', '2', '3']));
        $tecnico = $salas->filter(fn($s) => $s->tipo === 'tecnico');
    @endphp

    <!-- FUNDAMENTAL -->
    <h2>📘 Ensino Fundamental</h2>
    <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:30px;">
        @foreach ($fundamental as $sala)
            <a href="{{ route('salas.alunos', $sala->id) }}" class="card-sala fundamental">
                {{ $sala->nome }}
            </a>
        @endforeach
    </div>

    <!-- MÉDIO -->
    <h2>🎓 Ensino Médio</h2>
    <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:30px;">
        @foreach ($medio->where('tipo', 'regular') as $sala)
            <a href="{{ route('salas.alunos', $sala->id) }}" class="card-sala medio">
                {{ $sala->nome }}
            </a>
        @endforeach
    </div>

    <!-- TÉCNICO -->
    <h2>🛠 Ensino Técnico</h2>
    <div style="display:flex; flex-wrap:wrap; gap:15px;">
        @foreach ($tecnico as $sala)
            <a href="{{ route('salas.alunos', $sala->id) }}" class="card-sala tecnico">
                {{ $sala->nome }}
                <br>
                <small>{{ $sala->curso ?? '' }}</small>
            </a>
        @endforeach
    </div>
@endsection
