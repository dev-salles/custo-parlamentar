<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'deputado_id',
        'id_api_despesa', // Se a API retornar um ID único para a despesa
        'tipo_despesa',
        'data_documento',
        'tipo_documento',
        'cod_documento',
        'valor_documento',
        'valor_liquido',
        'url_documento',
        'nome_fornecedor',
        'cnpj_cpf_fornecedor',
        'num_nota_fiscal',
    ];

    // Relação inversa
    public function deputado()
    {
        return $this->belongsTo(Deputado::class);
    }
}
