<?php

namespace App\Jobs;

use App\Models\Deputado;
use App\Models\Despesa;
use App\Services\CamaraDeputadosService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessarDespesasDeputadoAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deputado;
    protected $camaraService;

    public function __construct(Deputado $deputado)
    {
        $this->deputado = $deputado;
        $this->camaraService = new CamaraDeputadosService();
    }

    public function handle(): void
    {
        Log::info("Iniciando busca de despesas para o deputado: {$this->deputado->nome} (ID API: {$this->deputado->id_api})");

        // Você pode parametrizar o ano e mês se quiser buscar dados históricos.
        // Para a API da Câmara, geralmente você precisa passar ano e mês.
        // Vamos buscar para o ano e mês do exemplo da API.
        $ano = 2025; // Exemplo do dado da API
        $mes = 5;    // Exemplo do dado da API

        $despesasApi = $this->camaraService->getDespesasDeputado(
            $this->deputado->id_api,
            $ano,
            $mes
        );

        if (empty($despesasApi)) {
            Log::info("Nenhuma despesa encontrada para o deputado {$this->deputado->nome} no período {$mes}/{$ano}.");
            return;
        }

        foreach ($despesasApi as $despesaData) {
            try {
                // Usar uma combinação de campos para updateOrCreate para evitar duplicatas,
                // já que a API não fornece um ID único para cada item de despesa,
                // mas sim para o documento (codDocumento ou numDocumento).
                // A dataDocumento e valorDocumento podem ajudar a tornar a chave ainda mais única.
                Despesa::updateOrCreate(
                    [
                        'deputado_id' => $this->deputado->id, // Chave estrangeira para o Deputado local
                        'cod_documento' => $despesaData['codDocumento'] ?? null,
                        'data_documento' => $despesaData['dataDocumento'] ?? null,
                        'valor_documento' => $despesaData['valorDocumento'] ?? null,
                        'num_documento' => $despesaData['numDocumento'] ?? null, // Use este como parte da chave única
                    ],
                    [
                        'ano' => $despesaData['ano'] ?? null,
                        'mes' => $despesaData['mes'] ?? null,
                        'tipo_despesa' => $despesaData['tipoDespesa'] ?? null,
                        'tipo_documento' => $despesaData['tipoDocumento'] ?? null,
                        'cod_tipo_documento' => $despesaData['codTipoDocumento'] ?? null,
                        'url_documento' => $despesaData['urlDocumento'] ?? null,
                        'nome_fornecedor' => $despesaData['nomeFornecedor'] ?? null,
                        'cnpj_cpf_fornecedor' => $despesaData['cnpjCpfFornecedor'] ?? null,
                        'valor_liquido' => $despesaData['valorLiquido'] ?? 0.00,
                        'valor_glosa' => $despesaData['valorGlosa'] ?? 0.00,
                        'num_ressarcimento' => $despesaData['numRessarcimento'] ?? null,
                        'cod_lote' => $despesaData['codLote'] ?? null,
                        'parcela' => $despesaData['parcela'] ?? null,
                    ]
                );
            } catch (\Exception $e) {
                Log::error("Erro ao salvar despesa para o deputado {$this->deputado->nome} (ID API: {$this->deputado->id_api}): " . $e->getMessage());
                Log::error("Dados da despesa que causaram o erro: " . json_encode($despesaData));
            }
        }

        Log::info("Processamento de despesas concluído para o deputado: {$this->deputado->nome}.");
    }
}