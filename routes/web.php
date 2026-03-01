<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\AlunoImportController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return redirect('/salas');
});

Route::get('/dashboard', function () {
    return redirect('/salas');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::middleware(['auth'])->group(function () {

    Route::get('/ocorrencias', [OcorrenciaController::class, 'index'])->name('ocorrencias.index');
    Route::post('/ocorrenciasSalvar', [OcorrenciaController::class, 'store'])->name('ocorrencias.store');
    Route::get('/ocorrencias/pdf', [OcorrenciaController::class, 'exportarPDF']);
    Route::put('/ocorrencias/{id}', [OcorrenciaController::class, 'update'])->name('ocorrencias.update');
    Route::delete('/ocorrencias/{id}', [OcorrenciaController::class, 'destroy'])->name('ocorrencias.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/salas', [SalaController::class, 'index'])->name('salas.index');

    Route::get('/salas/{id}/alunos', [AlunoController::class, 'porSala'])->name('salas.alunos');
});

Route::middleware(['auth'])->group(function () {
    // ✅ IMPORTAÇÃO
    Route::get('/alunos/import', [AlunoController::class, 'form'])->name('alunos.import.form');
    Route::post('/alunos/import', [AlunoController::class, 'importar'])->name('alunos.import');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/alunos/{id}', [AlunoController::class, 'show'])->name('alunos.show');
    Route::get('/alunos/{id}/pdf', [AlunoController::class, 'exportarPDF'])->name('alunos.pdf');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/ocorrencias/exportar', [OcorrenciaController::class, 'exportPage'])->name('ocorrencias.export.page');
    Route::post('/ocorrencias/exportar', [OcorrenciaController::class, 'export'])->name('ocorrencias.export');
    Route::post('/ocorrencias/export/todas', [OcorrenciaController::class, 'exportTodas'])->name('ocorrencias.export.todas');
    Route::post('/ocorrencias/export/selecionadas', [OcorrenciaController::class, 'exportSelecionadas'])->name('ocorrencias.export.selecionadas');
});
