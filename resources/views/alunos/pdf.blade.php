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

    <div class="section">
        <p><span class="label">Nome:</span> {{ $aluno->nome }}</p>
        <p><span class="label">Sala:</span> {{ $aluno->sala->nome ?? 'N/A' }}</p>
    </div>

    <div class="ocorrencia">
        <p class="label">Ocorrências:</p>

        @forelse($aluno->ocorrencias as $ocorrencia)
            <div
                style="
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 15px;
    ">
                <div><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</div>
                <div><strong>Data:</strong> {{ \Carbon\Carbon::parse($ocorrencia->data)->format('d/m/Y') }}</div>
            </div>
        @empty
            <p>Nenhuma ocorrência registrada.</p>
        @endforelse
    </div>

</body>



</html>
