<?php

namespace App\Jobs;

use App\Models\Deputado;
use App\Services\CamaraDeputadosService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessarDeputadosAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Opcional: injetar dependências no construtor se precisar
    protected $camaraService;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // Você pode injetar o serviço aqui, se ele for stateless
        // $this->camaraService = new CamaraDeputadosService();
    }

    /**
     * Execute the job.
     */
    public function handle(CamaraDeputadosService $camaraService): void
    {
        // Injeção de dependência via método handle é geralmente preferível
        // para serviços que precisam ser resolvidos do container de serviços.
        $deputadosApi = $camaraService->getDeputados();

        if ($deputadosApi) {
            foreach ($deputadosApi as $deputadoData) {
                Deputado::updateOrCreate(
                    ['id_api' => $deputadoData['id']],
                    [
                        'nome' => $deputadoData['nome'],
                        'sigla_partido' => $deputadoData['siglaPartido'],
                        'url_foto' => $deputadoData['urlFoto'],
                        // ... outros campos
                    ]
                );

                // Se você precisar buscar as despesas para cada deputado,
                // pode despachar outro Job para isso (encadeamento de Jobs ou Jobs aninhados).
                // Ex: Dispatchar um job para buscar despesas por deputado
                // ProcessarDespesasDeputado::dispatch($deputadoData['id']);
            }
        }
    }
}