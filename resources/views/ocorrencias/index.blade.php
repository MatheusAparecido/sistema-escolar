@extends('layouts.app')

@section('content')
    <div class="row">

        <!-- FILTROS -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    🔍 Filtros
                </div>
                <div class="card-body">
                    <form method="GET">

                        <div class="mb-3">
                            <label>Aluno</label>
                            <select name="aluno_id" class="form-control">
                                <option value="">Todos</option>
                                @foreach ($alunos as $aluno)
                                    <option value="{{ $aluno->id }}">
                                        {{ $aluno->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary w-100">
                            Filtrar
                        </button>
                    </form>

                    <hr>

                    <a href="/ocorrencias/pdf" class="btn btn-danger w-100">
                        📄 Exportar PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- CADASTRO -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-success text-white">
                    ➕ Nova Ocorrência
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Aluno</label>
                            <select name="aluno_id" class="form-control" required>
                                @foreach ($alunos as $aluno)
                                    <option value="{{ $aluno->id }}">
                                        {{ $aluno->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Descrição</label>
                            <textarea name="descricao" class="form-control" rows="3" required></textarea>
                        </div>

                        <button class="btn btn-success">
                            Salvar
                        </button>
                    </form>
                </div>
            </div>

            <!-- LISTAGEM -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    📋 Lista de Ocorrências
                </div>
                <div class="card-body table-responsive">

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>Sala</th>
                                <th>Descrição</th>
                                <th>Data</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($ocorrencias as $o)
                                <tr>
                                    <td>{{ $o->aluno->nome }}</td>
                                    <td>{{ $o->aluno->sala->nome }}</td>
                                    <td>{{ $o->descricao }}</td>
                                    <td>{{ \Carbon\Carbon::parse($o->data)->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Nenhuma ocorrência encontrada
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>

        </div>

    </div>
@endsection
