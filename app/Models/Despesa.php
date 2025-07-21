<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'deputado_id',
        'ano',
        'mes',
        'tipo_despesa',
        'cod_documento',
        'tipo_documento',
        'cod_tipo_documento',
        'data_documento',
        'num_documento',
        'valor_documento',
        'url_documento',
        'nome_fornecedor',
        'cnpj_cpf_fornecedor',
        'valor_liquido',
        'valor_glosa',
        'num_ressarcimento',
        'cod_lote',
        'parcela',
    ];

    protected $casts = [
        'data_documento' => 'date', // Garante que data_documento seja um objeto Carbon
        'valor_documento' => 'decimal:2',
        'valor_liquido' => 'decimal:2',
        'valor_glosa' => 'decimal:2',
    ];

    public function deputado()
    {
        return $this->belongsTo(Deputado::class);
    }
}