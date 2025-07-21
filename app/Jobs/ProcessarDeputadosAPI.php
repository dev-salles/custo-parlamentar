<?php

namespace App\Jobs;

use App\Models\Deputado;
use App\Services\CamaraDeputadosService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class ProcessarDeputadosAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $camaraService;

    public function __construct()
    {
        $this->camaraService = new CamaraDeputadosService();
    }

    public function handle(CamaraDeputadosService $camaraService): void
    {
        try {
            $deputadosApi = $camaraService->getDeputados();

            if ($deputadosApi) {
                foreach ($deputadosApi as $deputadoData) {
                    Deputado::updateOrCreate(
                        ['id_api' => $deputadoData['id']],
                        [
                            'nome' => $deputadoData['nome'],
                            'sigla_partido' => $deputadoData['siglaPartido'],
                            'url_foto' => $deputadoData['urlFoto'],
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error("Erro ao processar deputados da API: " . $e->getMessage());
        }   
    }
}