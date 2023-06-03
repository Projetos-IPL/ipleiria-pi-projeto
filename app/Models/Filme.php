<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    use HasFactory;

    protected $table = 'filmes';

    protected $fillable = [
        'titulo',
        'genero_code',
        'ano',
        'cartaz_url',
        'sumario',
        'trailer_url',
        'custom'
    ];

    public function getCartazPath(): string
    {
        if (!$this->cartaz_url) {
            return '/img/cartaz_default.png';
        }

        return '/storage/cartazes/' . $this->cartaz_url;
    }

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_code', 'code');
    }

    public function sessoes()
    {
        return $this->hasMany(Sessao::class, 'filme_id');
    }
}
