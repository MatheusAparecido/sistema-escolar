@extends('layouts.app')

@section('content')
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
        }

        .btn {
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            background: #3b82f6;
            transition: 0.2s;
        }

        .btn:hover {
            background: #2563eb;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f1f5f9;
        }

        th {
            text-align: left;
            padding: 12px;
            font-size: 14px;
            color: #555;
        }

        td {
            padding: 12px;
            border-top: 1px solid #eee;
        }

        tr:hover {
            background: #f9fafb;
        }

        .actions a {
            font-size: 18px;
            text-decoration: none;
            transition: 0.2s;
        }

        .actions a:hover {
            transform: scale(1.2);
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>

    <div class="page-header">
        <div class="title">👨‍🎓 Alunos - {{ $sala->nome }}</div>

        <a href="{{ route('salas.index') }}" class="btn">
            ⬅ Voltar
        </a>
    </div>

    <div class="card">

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>RA</th>
                    <th style="width: 100px;">Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($alunos as $aluno)
                    <tr>
                        <td>{{ $aluno->nome }}</td>
                        <td>{{ $aluno->ra }}</td>
                        <td class="actions">

                            <a href="{{ route('alunos.show', $aluno->id) }}" title="Ver ficha">
                                👁️
                            </a>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty">
                            Nenhum aluno encontrado
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
