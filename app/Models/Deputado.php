<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    use HasFactory;


    protected $fillable = [
        'id_api',
        'nome',
        'sigla_partido',
        'url_foto',
    ];


    // O método despesas define que um deputado pode ter várias despesas 
    public function despesas()
    {
        return $this->hasMany(Despesa::class);
    }
}