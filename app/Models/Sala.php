<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sala extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'salas';
    public $timestamps = false;

    protected $fillable = [
        'nome',
    ];

    public function getLotacao()
    {
        return $this->lugares()->count();
    }

    public function getPosicoesForFila(string $fila)
    {
        return $this->lugares()->where('fila', $fila)->get('posicao');
    }

    public function getFilasForSala()
    {
        return $this->lugares()->select('fila')->distinct()->get();
    }

    public function lugares()
    {
        return $this->hasMany(Lugar::class);
    }
}
