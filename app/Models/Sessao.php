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

    // check if sessao is full, by getting the number of lugares sold in the bilhetes for this sessao
    // then compare to the max number of lugares in the sala
    // make it optimized in regard of the number of queries
    public function isFull()
    {
        $bilhetes = $this->bilhetes;
        $lugaresSold = 0;

        foreach ($bilhetes as $bilhete) {
            $lugaresSold += $bilhete->lugar->id;
        }

        return $lugaresSold === $this->sala->numero_lugares ? 'Sim' : 'Não';
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
