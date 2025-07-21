<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportDeputados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:deputados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa os dados dos deputados da API da Câmara para o banco de dados.';

    // App\Console\Commands\ImportDeputados.php
    public function handle()
    {
        \App\Jobs\ProcessarDeputadosAPI::dispatch();
        $this->info('Job para processar deputados despachado!');
    }
}
