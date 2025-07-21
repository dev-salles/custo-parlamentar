<?php

namespace App\Http\Controllers;

use App\Models\Deputado;
use Illuminate\Http\Request;

class DeputadoController extends Controller
{
    /**
     * Exibe a lista paginada de deputados.
     */
    public function index()
    {
        // Pega todos os deputados do banco de dados com paginação
        // O método paginate() retorna uma instância de LengthAwarePaginator
        // que facilita a exibição da paginação na view.
        $deputados = Deputado::orderBy('nome')->paginate(10); // 10 deputados por página

        return view('deputados.index', compact('deputados'));
    }

    /**
     * Exibe as despesas de um deputado específico.
     *
     * @param \App\Models\Deputado $deputado
     * @return \Illuminate\View\View
     */
    public function showExpenses(Deputado $deputado)
    {
        // Carrega as despesas relacionadas ao deputado.
        // Se você quiser paginar as despesas também:
        $despesas = $deputado->despesas()->orderBy('data_documento', 'desc')->paginate(20); // 20 despesas por página

        // Ou, se não quiser paginar as despesas, apenas todas elas:
        // $despesas = $deputado->despesas()->orderBy('data_documento', 'desc')->get();

        return view('deputados.show_expenses', compact('deputado', 'despesas'));
    }
}