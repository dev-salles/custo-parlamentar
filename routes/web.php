<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeputadoController;

Route::get('/', function () {
    return redirect()->route('deputados.index'); // Redireciona a raiz para a lista de deputados
});

// Rota para a lista paginada de deputados
Route::get('/deputados', [DeputadoController::class, 'index'])->name('deputados.index');

// Rota para as despesas de um deputado específico usando Model Binding
Route::get("/deputados/{deputado}/despesas", [DeputadoController::class, 'showExpenses'])->name('deputados.despesas');

// IMPORTANTE:
// Certifique-se de que o job de importação de dados dos deputados e despesas
// já foi executado e que você tem dados no banco para testar!