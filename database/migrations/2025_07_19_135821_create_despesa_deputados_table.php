<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('despesas_deputados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deputado_id')->constrained('deputados')->onDelete('cascade'); // Chave estrangeira
            $table->integer('id_api_despesa')->unique()->nullable(); // ID único da despesa, se a API fornecer
            $table->string('tipo_despesa');
            $table->date('data_documento')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('cod_documento')->nullable();
            $table->decimal('valor_documento', 10, 2); // Valor será formatado com 2 casas decimais. Exemplo: 50,00.
            $table->decimal('valor_liquido', 10, 2);
            $table->string('url_documento')->nullable();
            $table->string('nome_fornecedor')->nullable();
            $table->string('cnpj_cpf_fornecedor')->nullable();
            $table->string('num_nota_fiscal')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('despesas_deputados');
    }
};
