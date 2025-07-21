<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    // App\Console\Kernel.php
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new \App\Jobs\ProcessarDeputadosAPI)->daily(); // Trigger para rodar o programa diáriamente.
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}