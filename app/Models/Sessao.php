<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    use HasFactory;

    protected $table = 'sessoes';

    protected $fillable = [
        'filme_id',
        'sala_id',
        'data',
        'horario_inicio',
    ];

    // check if sessao is full
    public function isFull()
    {
        $bilhetesVendidos = $this->bilhetes->count();
        $lotacao = $this->sala->lugares->count();

        echo $bilhetesVendidos . ' ' . $lotacao;
    }

    public function filme()
    {
        return $this->belongsTo(Filme::class, 'filme_id');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }

    public function bilhetes()
    {
        return $this->hasMany(Bilhete::class, 'sessao_id');
    }
}
