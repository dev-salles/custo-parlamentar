<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deputados', function (Blueprint $table) {
            $table->id(); // ID local
            $table->integer('id_api')->unique(); // ID da API da Câmara
            $table->string('nome');
            $table->string('sigla_partido');
            $table->string('url_foto')->nullable();
            // Adicione outros campos que você precisar da API
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deputados');
    }
};