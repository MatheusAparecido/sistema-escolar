@extends('layouts.app')
@if ($errors->any())
    <div style="color:red;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
@section('content')
    <div style="max-width: 500px; margin: 40px auto;">

        <div
            style="
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    ">

            <h2 style="text-align:center; margin-bottom:20px;">
                👤 Cadastro de Usuário
            </h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nome -->
                <div style="margin-bottom:15px;">
                    <label>Nome</label>
                    <input type="text" name="name" required class="form-control">
                </div>

                <!-- Email -->
                <div style="margin-bottom:15px;">
                    <label>Email</label>
                    <input type="email" name="email" required class="form-control">
                </div>

                <!-- Senha -->
                <div style="margin-bottom:15px;">
                    <label>Senha</label>
                    <input type="password" name="password" required class="form-control">
                </div>

                <!-- Confirmar Senha -->
                <div style="margin-bottom:20px;">
                    <label>Confirmar Senha</label>
                    <input type="password" name="password_confirmation" required class="form-control">
                </div>

                <!-- Botão -->
                <button type="submit"
                    style="
                width:100%;
                background:#2563eb;
                color:#fff;
                border:none;
                padding:12px;
                border-radius:8px;
                font-weight:bold;
                transition:0.3s;
            "
                    onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                    ➕ Cadastrar Usuário
                </button>

            </form>

            <!-- Voltar -->
            <div style="text-align:center; margin-top:15px;">
                <a href="{{ route('salas.index') }}" style="color:#555;">
                    ← Voltar
                </a>
            </div>

        </div>
    </div>
@endsection
