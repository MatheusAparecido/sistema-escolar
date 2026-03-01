<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <title>Sistema de Ocorrência</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6fa;
        }

        header {
            background: #2c3e50;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h2 {
            margin: 0;
        }

        .container {
            padding: 20px;
        }

        .btn {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

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

    <header>
        <h2>📘 Sistema de Ocorrência</h2>

        <div>
            @auth
                <span>{{ auth()->user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-danger">Sair</button>
                </form>
            @endauth
        </div>
    </header>

    <div class="container">
        @yield('content')
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
