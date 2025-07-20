<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CamaraDeputadosService
{
    protected $baseUrl = 'https://dadosabertos.camara.leg.br/api/v2';

    public function getDeputados()
    {
        try {
            $response = Http::get("{$this->baseUrl}/deputados");

            if ($response->successful()) {
                return $response->json()['dados']; // Retorna a parte 'dados' da resposta
            }

            // Gerar Log ou tratar erro caso a requisição não seja bem-sucedida
            Log::error('Erro ao buscar deputados da API: ' . $response->status() . ' - ' . $response->body());
            return null;

        } catch (\Exception $e) {
            // Gerar Log ou tratar exceções de rede, etc.
            Log::error('Exceção ao conectar com a API da Câmara: ' . $e->getMessage());
            return null;
        }
    }

    public function getDespesasDeputado($deputadoId, $ano, $mes)
    {
        try {
            $response = Http::get("{$this->baseUrl}/deputados/{$deputadoId}/despesas", [
                'ano' => $ano,
                'mes' => $mes,
            ]);

            if ($response->successful()) {
                return $response->json()['dados'];
            }

            // Gerar Log ou tratar exceções da busca de despesas do deputado
            Log::error("Erro ao buscar despesas do deputado {$deputadoId}: " . $response->status() . ' - ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Exceção ao conectar com a API da Câmara para despesas: ' . $e->getMessage());
            return null;
        }
    }
}

