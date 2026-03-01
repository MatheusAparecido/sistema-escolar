@extends('layouts.app')

@section('content')
    <style>
        .page-title {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: 0.2s;
        }

        .btn-green {
            background: #16a34a;
        }

        .btn-green:hover {
            background: #15803d;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            margin-top: 25px;
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card-sala {
            width: 180px;
            padding: 18px;
            border-radius: 12px;
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: 0.2s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .card-sala:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
        }

        .fundamental {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .medio {
            background: linear-gradient(135deg, #9333ea, #7e22ce);
        }

        .tecnico {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .card-sala small {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            opacity: 0.9;
        }
    </style>

    <div class="page-title">🏫 Salas</div>

    <div class="top-actions">
        <a href="{{ route('alunos.import.form') }}" class="btn btn-green">
            📄 Importar Alunos
        </a>

        @auth
            @if (auth()->user()->is_admin)
                <a href="{{ route('register') }}" class="btn btn-green">
                    ➕ Novo Usuário
                </a>
            @endif
        @endauth
    </div>

    @php
        $fundamental = $salas->filter(fn($s) => in_array($s->serie, ['6', '7', '8', '9']));
        $medio = $salas->filter(fn($s) => in_array($s->serie, ['1', '2', '3']));
        $tecnico = $salas->filter(fn($s) => $s->tipo === 'tecnico');
    @endphp

    <!-- FUNDAMENTAL -->
    <div class="section-title">📘 Ensino Fundamental</div>
    <div class="grid">
        @foreach ($fundamental as $sala)
            <a href="{{ route('salas.alunos', $sala->id) }}" class="card-sala fundamental">
                {{ $sala->nome }}
            </a>
        @endforeach
    </div>

    <!-- MÉDIO -->
    <div class="section-title">🎓 Ensino Médio</div>
    <div class="grid">
        @foreach ($medio->where('tipo', 'regular') as $sala)
            <a href="{{ route('salas.alunos', $sala->id) }}" class="card-sala medio">
                {{ $sala->nome }}
            </a>
        @endforeach
    </div>

    <!-- TÉCNICO -->
    <div class="section-title">🛠 Ensino Técnico</div>
    <div class="grid">
        @foreach ($tecnico as $sala)
            <a href="{{ route('salas.alunos', $sala->id) }}" class="card-sala tecnico">
                {{ $sala->nome }}
                <small>{{ $sala->curso ?? '' }}</small>
            </a>
        @endforeach
    </div>
@endsection
