<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    use HasFactory;

    // Para que o Deputado::updateOrCreate funcione, você precisa
    // definir quais campos podem ser preenchidos em massa (mass assignable).
    // A forma mais comum é usar $fillable.
    protected $fillable = [
        'id_api',
        'nome',
        'sigla_partido',
        'url_foto',
    ];

    // Opcional: Se sua chave primária na API não é 'id', mas 'id_api' por exemplo,
    // você pode precisar especificar isso, mas para o updateOrCreate,
    // o 'id_api' que você está usando como chave de busca já resolve.
    // protected $primaryKey = 'id_api';
    // public $incrementing = false; // Se o id_api não for auto-incrementável localmente
}