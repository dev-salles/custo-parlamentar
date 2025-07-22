<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckDeputadosTableSeeder extends Seeder
{
    public function run(): void
    {
        // Retorna a contagem de registros na tabela 'deputados'
        echo DB::table('deputados')->count();
    }
}