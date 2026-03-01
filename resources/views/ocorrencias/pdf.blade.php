<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 15px;
            padding-bottom: 8px;
        }

        .logo {
            width: 60px;
            display: block;
            margin: 0 auto 5px auto;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0 2px 0;
        }

        .info {
            margin-top: 10px;
        }

        .section {
            margin-top: 20px;
        }

        .label {
            font-weight: bold;
        }

        @page {
            margin: 40px 25px 80px 25px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;

            text-align: center;
            font-size: 12px;
            color: #555;
        }

        .ocorrencia {
            border: 1px solid #ccc;
            border-left: 5px solid #007bff;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <footer>
        <hr>
        <hr style="border: 1px solid #ddd;">

        <p style="margin: 5px 0;">
            <strong>E.E. Profª Beathris Caixeiro Del Cisti</strong>
        </p>

        <p style="margin: 0;">
            Gerado em {{ date('d/m/Y H:i') }}
        </p>
    </footer>
    @php
        $logo = base64_encode(file_get_contents(public_path('images/logo.png')));
    @endphp

    <div class="header" style="display: flex; align-items: center; justify-content: center;">
        <img src="data:image/png;base64,{{ $logo }}" class="logo" style="margin-right:10px;">

        <div>
            <div class="title">E.E. Profª Beathris Caixeiro Del Cisti</div>
            <div>Relatório do Aluno</div>
            <div>{{ date('d/m/Y') }}</div>
        </div>
    </div>

    <!-- 🔥 DADOS DO ALUNO -->
    @php
        $aluno = $ocorrencias->first()->aluno ?? null;
    @endphp

    @if ($aluno)
        <div class="aluno-box">
            <h3>👤 Dados do Aluno</h3>

            <p><span class="label">Nome:</span> {{ $aluno->nome }}</p>
            <p><span class="label">RA:</span> {{ $aluno->ra }}</p>
            <p><span class="label">Sala:</span> {{ $aluno->sala->nome ?? '-' }}</p>
        </div>
    @endif

    <!-- 🔥 LISTA DE OCORRÊNCIAS -->
    @foreach ($ocorrencias as $o)
        <div class="ocorrencia">

            <div class="titulo">
                📅 {{ \Carbon\Carbon::parse($o->data)->format('d/m/Y') }}
                — {{ $o->tipo->nome ?? 'Sem tipo' }}
            </div>

            <p><span class="label">Professor:</span> {{ $o->professor_nome }}</p>

            <p><span class="label">Descrição:</span><br>
                {{ $o->descricao }}
            </p>

            @if ($o->codigo_conviva)
                <p><span class="label">Código Conviva:</span> {{ $o->codigo_conviva }}</p>
            @endif

            @if ($o->foto)
                <img src="{{ public_path('storage/' . $o->foto) }}">
            @endif

        </div>
    @endforeach

</body>

</html>
