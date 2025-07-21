<?php

namespace App\Http\Controllers;

use App\Models\Deputado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DeputadoController extends Controller
{
    /**
     * Exibe a lista paginada de deputados.
     */
public function index(Request $request)
    {
        // --- INÍCIO DA DEPURACÃO ---

        // 1. Verifique se o termo de pesquisa está chegando:
        $searchTerm = $request->input('search');

        $query = Deputado::query();

        if ($request->has('search') && !empty($searchTerm)) {
            // 2. Verifique como a query SQL está sendo construída (apenas para depuração!):
            // Isso mostrará a SQL bruta que seria executada
            // dd($query->toSql(), $query->getBindings());

            $query->where('nome', 'like', '%' . $searchTerm . '%');
            
            // Código para que eu possa depurar
            //dump("Query WHERE adicionada: nome LIKE '%" . $searchTerm . "%'");
        }

        $query->orderBy('nome');

        // 3. Obtenha os resultados da query ANTES da paginação (temporário para depuração):
        // dd($query->get()); // Isso vai parar a execução e mostrar todos os deputados encontrados SEM paginação

        // --- FIM DA DEPURACÃO ---

        $deputados = $query->paginate(10)->appends($request->only('search'));

        // Se após a depuração acima você ver que a query retorna deputados, mas a view não,
        // então o problema pode ser na iteração do Blade (@forelse).

        return view('deputados.index', compact('deputados'));
    }

    /**
     * Exibe as despesas de um deputado específico.
     *
     * @param \App\Models\Deputado $deputado
     * @return \Illuminate\View\View
     */
public function showExpenses(Request $request, Deputado $deputado) // Injetamos Request aqui
    {
        // Inicia a query para as despesas do deputado
        $despesasQuery = $deputado->despesas();

        // Obtém o ano e o mês da requisição
        $year = $request->input('year');
        $month = $request->input('month');

        // Aplica o filtro por ano, se fornecido e válido
        if ($year && is_numeric($year) && $year > 1900 && $year <= Carbon::now()->year) {
            $despesasQuery->whereYear('data_documento', $year);
        }

        // Aplica o filtro por mês, se fornecido e válido
        if ($month && is_numeric($month) && $month >= 1 && $month <= 12) {
            $despesasQuery->whereMonth('data_documento', $month);
        }

        // Ordena as despesas pela data do documento em ordem decrescente
        $despesasQuery->orderBy('data_documento', 'desc');

        // Pagina os resultados e anexa os filtros de ano e mês aos links de paginação
        $despesas = $despesasQuery->paginate(20)->appends($request->only(['year', 'month']));

        // Para popular os selects na view, vamos obter uma lista de anos disponíveis
        // Você pode ajustar o range de anos conforme a sua necessidade de dados
        $availableYears = range(Carbon::now()->year, 2000); // Ex: do ano atual até 2000

        return view('deputados.show_expenses', compact('deputado', 'despesas', 'availableYears', 'year', 'month'));
    }
}