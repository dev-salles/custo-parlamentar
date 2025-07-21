<?php

namespace App\Console\Commands;

use App\Jobs\ProcessarDespesasDeputadoAPI;
use App\Models\Deputado; // Importe o modelo Deputado
use Illuminate\Console\Command;

class ImportDeputadoDespesas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:despesas-deputados'; // Você pode escolher um nome que faça sentido

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa as despesas de todos os deputados existentes no banco de dados da API da Câmara.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Iniciando o processo de importação de despesas para todos os deputados...');

        // Obtenha todos os deputados do banco de dados
        $deputados = Deputado::all();

        if ($deputados->isEmpty()) {
            $this->warn('Nenhum deputado encontrado no banco de dados. Por favor, execute "php artisan import:deputados" primeiro.');
            return;
        }

        $bar = $this->output->createProgressBar(count($deputados));
        $bar->start();

        foreach ($deputados as $deputado) {
            // Despache o Job para processar as despesas deste deputado
            ProcessarDespesasDeputadoAPI::dispatch($deputado);

            $this->line("Despachado Job para despesas do deputado: {$deputado->nome} (ID API: {$deputado->id_api})");
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(); // Pula uma linha após a barra de progresso
        $this->info('Todos os Jobs de despesas de deputados foram despachados para a fila!');
        $this->info('Certifique-se de que seu worker de fila está rodando (php artisan queue:work).');
    }
}