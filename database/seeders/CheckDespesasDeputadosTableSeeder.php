<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckDespesasDeputadosTableSeeder extends Seeder
{

    public function run(): void
    {
        // Retorna a contagem de registros na tabela 'despesa_deputados'
        echo DB::table('despesa_deputados')->count();
    }
}