<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deputado_id')->constrained('deputados')->onDelete('cascade'); // Chave estrangeira

            // Campos diretamente mapeados da API
            $table->integer('ano')->nullable();
            $table->integer('mes')->nullable();
            $table->string('tipo_despesa')->nullable();
            $table->integer('cod_documento')->nullable(); // codDocumento
            $table->string('tipo_documento')->nullable(); // tipoDocumento
            $table->integer('cod_tipo_documento')->nullable(); // codTipoDocumento
            $table->date('data_documento')->nullable(); // dataDocumento - convertemos para 'date'
            $table->string('num_documento')->nullable(); // numDocumento (parece ser a NF)
            $table->decimal('valor_documento', 10, 2)->nullable(); // valorDocumento
            $table->string('url_documento')->nullable(); // urlDocumento
            $table->string('nome_fornecedor')->nullable(); // nomeFornecedor
            $table->string('cnpj_cpf_fornecedor')->nullable(); // cnpjCpfFornecedor
            $table->decimal('valor_liquido', 10, 2)->nullable(); // valorLiquido
            $table->decimal('valor_glosa', 10, 2)->nullable(); // valorGlosa
            $table->string('num_ressarcimento')->nullable(); // numRessarcimento
            $table->integer('cod_lote')->nullable(); // codLote
            $table->integer('parcela')->nullable(); // parcela

            // Outros campos de controle
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};