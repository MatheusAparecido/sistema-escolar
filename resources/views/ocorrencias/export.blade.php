@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="card shadow mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">

                <h3 class="mb-0">📄 Exportar Ocorrências</h3>

                {{-- 🔹 BOTÃO VOLTAR (NOVO) --}}
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    ← Voltar
                </a>

            </div>
        </div>

        <!-- BOTÕES PRINCIPAIS -->
        <div class="card shadow mb-4">
            <div class="card-body d-flex gap-2">

                {{-- 🔹 EXPORTAR TODAS --}}
                <form method="POST" action="{{ route('ocorrencias.export.todas') }}">
                    @csrf
                    <button class="btn btn-success">
                        📥 Exportar Todas
                    </button>
                </form>

                {{-- 🔹 EXPORTAR SELECIONADAS --}}
                <button onclick="enviarSelecionadas()" class="btn btn-primary">
                    ✅ Exportar Selecionadas
                </button>

            </div>
        </div>

        <!-- LISTA DE OCORRÊNCIAS -->
        <div class="card shadow">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <h4 class="mb-0">📋 Lista de Ocorrências</h4>

                    {{-- 🔧 SELECT ALL --}}
                    <button onclick="toggleAll()" class="btn btn-sm btn-secondary">
                        Marcar / Desmarcar Todos
                    </button>
                </div>

                <form id="formSelecionadas" method="POST" action="{{ route('ocorrencias.export.selecionadas') }}">
                    @csrf

                    @forelse ($ocorrencias as $oc)
                        <div class="border rounded p-3 mb-2 d-flex justify-content-between align-items-center">

                            <div>
                                <input type="checkbox" name="ocorrencias[]" value="{{ $oc->id }}"
                                    class="form-check-input me-2">

                                <strong>{{ $oc->aluno->nome }}</strong>
                                <br>

                                <small class="text-muted">
                                    {{ $oc->data_formatada }} |
                                    {{ $oc->tipo->nome ?? 'Sem tipo' }}
                                </small>
                            </div>

                            <span class="badge bg-info">
                                {{ Str::limit($oc->descricao, 40) }}
                            </span>

                        </div>
                    @empty
                        <p>Nenhuma ocorrência encontrada.</p>
                    @endforelse

                </form>

            </div>
        </div>

    </div>

    <script>
        // 🔧 MARCAR TODOS
        function toggleAll() {
            let checkboxes = document.querySelectorAll('input[name="ocorrencias[]"]');

            checkboxes.forEach(cb => {
                cb.checked = !cb.checked;
            });
        }

        // 🔧 ENVIAR SELECIONADAS
        function enviarSelecionadas() {

            let selecionados = document.querySelectorAll('input[name="ocorrencias[]"]:checked');

            if (selecionados.length === 0) {
                alert("Selecione pelo menos uma ocorrência!");
                return;
            }

            document.getElementById('formSelecionadas').submit();
        }
    </script>
@endsection
