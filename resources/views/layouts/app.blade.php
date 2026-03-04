<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Ocorrência</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* 🔷 HEADER */
        .main-header {
            width: 100%;
            background: #1e293b;
            color: white;
        }

        .header-content {
            max-width: 1200px;
            margin: auto;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-area img {
            height: 40px;
        }

        .title {
            font-weight: bold;
            font-size: 16px;
        }

        .subtitle {
            font-size: 12px;
            opacity: 0.8;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 12px;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        /* 🔷 CONTEÚDO */
        .main-container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            flex: 1;
        }

        /* 🔷 CARDS */
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* 🔷 FOOTER */
        .main-footer {
            background: #1e293b;
            color: #cbd5e1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
        }

        /* 🔷 SALAS */
        .card-sala {
            width: 130px;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            display: block;
        }

        .card-sala:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .fundamental {
            background: #d0ebff;
            color: #084298;
        }

        .medio {
            background: #e6ffe6;
            color: #146c43;
        }

        .tecnico {
            background: #fff3cd;
            color: #997404;
        }
    </style>
</head>

<body>

    <!-- 🔷 HEADER -->
    <div class="main-header">
        <div class="header-content">

            <div class="logo-area">
                <img src="/images/logo.png">

                <div>
                    <div class="title">Sistema de Ocorrências Escolares</div>
                    <div class="subtitle">Controle disciplinar de alunos</div>
                </div>
            </div>

            <div class="header-right">
                <div>
                    {{ now()->format('d/m/Y H:i') }}
                </div>

                @auth
                    <div>👤 {{ auth()->user()->name }}</div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="logout-btn">Sair</button>
                    </form>
                @endauth
            </div>

        </div>
    </div>

    <!-- 🔷 CONTEÚDO -->
    <div class="main-container">
        @yield('content')
    </div>

    <!-- 🔷 FOOTER -->
    <div class="main-footer">
        © {{ date('Y') }} - Sistema de Ocorrências Escolares | Desenvolvido por Matheus
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
