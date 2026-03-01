@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <!-- DADOS DO ALUNO -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h3 class="mb-3">👤 {{ $aluno->nome }}</h3>

                <p><strong>RA:</strong> {{ $aluno->ra }}</p>
                <p><strong>Sala:</strong> {{ $aluno->sala->nome }}</p>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('ocorrencias.export.page', $aluno->id) }}" class="btn btn-primary">
                        📄 Exportar PDF
                    </a>

                    <a href="{{ route('salas.alunos', $aluno->sala->id) }}" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>
            </div>
        </div>

        <!-- NOVA OCORRÊNCIA -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h4 class="mb-3">➕ Nova Ocorrência</h4>

                <form action="{{ route('ocorrencias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="aluno_id" value="{{ $aluno->id }}">

                    <div class="mb-2">
                        <label>Tipo</label>
                        <select name="tipo_ocorrencia_id" class="form-control" required>
                            <option value="">Selecione</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Professor</label>
                        <input type="text" name="professor_nome" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Data</label>
                        <input type="date" name="data" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control" onchange="previewImagem(event)">
                        <img id="preview" width="120" class="mt-2" />
                    </div>

                    @if (auth()->user()->is_admin == 1)
                        <div class="mb-2">
                            <label>Código Conviva</label>
                            <input type="text" name="codigo_conviva" class="form-control">
                        </div>
                    @endif

                    <button class="btn btn-success mt-2">Salvar</button>
                </form>
            </div>
        </div>
        <form method="GET" class="row mb-3">

            <div class="col-md-4">
                <input type="text" name="busca" class="form-control" placeholder="Buscar descrição..."
                    value="{{ request('busca') }}">
            </div>

            <div class="col-md-4">
                <select name="tipo" class="form-control">
                    <option value="">Todos os tipos</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ request('tipo') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary w-100">Filtrar</button>
            </div>

        </form>
        <!-- LISTA DE OCORRÊNCIAS -->
        <div class="card shadow">
            <div class="card-body">
                <h4 class="mb-3">📋 Ocorrências</h4>

                @forelse($ocorrencias as $oc)
                    <div class="border rounded p-3 mb-3">

                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>📅 {{ $oc->data_formatada }}</strong> |
                                <span class="badge bg-primary">{{ $oc->tipo->nome ?? 'Sem tipo' }}</span>
                            </div>

                            <div>
                                <button data-oc='@json($oc)' onclick="abrirModal(this)"
                                    class="btn btn-warning btn-sm">
                                    ✏ Editar
                                </button>

                                <form action="{{ route('ocorrencias.destroy', $oc->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir?')">
                                        🗑
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p class="mt-2 mb-1"><strong>Professor:</strong> {{ $oc->professor_nome }}</p>

                        <p class="text-muted">
                            {{ Str::limit($oc->descricao, 120) }}
                        </p>

                    </div>
                @empty
                    <p>Nenhuma ocorrência registrada.</p>
                @endforelse

                <div class="mt-3">
                    {{ $ocorrencias->links() }}
                </div>

            </div>
        </div>
        {{-- 🔧 ALTERADO: removi uso de $oc dentro do modal (isso dava erro) --}}
        <div class="modal fade" id="modalEdit" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" id="formEdit" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Editar Ocorrência</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <select name="tipo_ocorrencia_id" id="edit_tipo" class="form-control mb-2"></select>

                            <input type="text" name="professor_nome" id="edit_professor" class="form-control mb-2">

                            <input type="date" name="data" id="edit_data" class="form-control mb-2">

                            <textarea name="descricao" id="edit_descricao" class="form-control mb-2"></textarea>

                            {{-- 🔧 ALTERADO: imagem agora será preenchida via JS --}}
                            <label>Nova Foto</label>
                            <input type="file" name="foto" class="form-control"
                                onchange="previewEditImagem(event)">
                            <br>
                            <img id="edit_preview" width="120" class="mt-2 rounded d-none">

                            @if (auth()->user()->is_admin == 1)
                                <label>Codigo Conviva</label>
                                <input type="text" name="codigo_conviva" id="edit_codigo" class="form-control mb-2">
                            @endif
                            <button type="button" class="btn btn-danger btn-sm" onclick="removerFoto()">Remover
                                Foto</button>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Salvar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        function previewEditImagem(event) {
            let img = document.getElementById('edit_preview');
            img.src = URL.createObjectURL(event.target.files[0]);
            img.classList.remove('d-none');
        }
        // 🔧 ALTERADO: agora recebe o botão e extrai JSON com segurança
        function abrirModal(btn) {

            let oc = JSON.parse(btn.getAttribute('data-oc'));

            console.log("Modal chamado", oc); // 🔧 DEBUG (pode remover depois)

            document.getElementById('formEdit').action = "/ocorrencias/" + oc.id;

            document.getElementById('edit_professor').value = oc.professor_nome;
            document.getElementById('edit_data').value = oc.data;
            document.getElementById('edit_descricao').value = oc.descricao;

            // 🔧 ALTERADO: evita erro se não for admin
            let codigo = document.getElementById('edit_codigo');
            if (codigo) {
                codigo.value = oc.codigo_conviva ?? '';
            }

            // 🔧 ALTERADO: select recriado corretamente
            let select = document.getElementById('edit_tipo');
            select.innerHTML = '';

            @foreach ($tipos as $tipo)
                select.innerHTML += `<option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>`;
            @endforeach

            select.value = oc.tipo_ocorrencia_id;

            // 🔧 ALTERADO: preview da imagem no modal
            let img = document.getElementById('edit_preview');

            if (oc.foto) {
                img.src = "/storage/" + oc.foto;
                img.classList.remove('d-none');
            } else {
                img.classList.add('d-none');
            }

            new bootstrap.Modal(document.getElementById('modalEdit')).show();
        }

        function removerFoto() {
            let img = document.getElementById('edit_preview');
            img.src = '';
            img.classList.add('d-none');

            // cria input hidden pra backend saber que quer remover
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remover_foto';
            input.value = '1';

            document.getElementById('formEdit').appendChild(input);
        }

        function previewImagem(event) {
            let img = document.getElementById('preview');
            img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
