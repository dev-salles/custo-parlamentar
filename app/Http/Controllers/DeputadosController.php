<?php

namespace App\Http\Controllers;

use App\Services\CamaraDeputadosService;
use Illuminate\Http\Request;

class DeputadosController extends Controller
{
    protected $camaraService;

    public function __construct(CamaraDeputadosService $camaraService)
    {
        $this->camaraService = $camaraService;
    }

    public function index()
    {
        $deputados = $this->camaraService->getDeputados();

        if ($deputados) {
            return view('deputados.index', ['deputados' => $deputados]);
        }

        return back()->with('error', 'Não foi possível carregar os dados dos deputados.');
    }

    public function showDespesas($id, Request $request)
    {
        $ano = $request->input('ano', date('Y'));
        $mes = $request->input('mes', date('m'));

        $despesas = $this->camaraService->getDespesasDeputado($id, $ano, $mes);

        if ($despesas) {
            return view('deputados.despesas', ['despesas' => $despesas, 'deputadoId' => $id]);
        }

        return back()->with('error', 'Não foi possível carregar as despesas do deputado.');
    }
}