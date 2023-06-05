<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lugar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lugares';
    public $timestamps = false;

    protected $fillable = [
        'sala_id',
        'fila',
        'posicao',
    ];

    public function isOcupado(int $sessaoId): bool
    {
        $sessao = Sessao::find($sessaoId);

        $bilhetes = $sessao->bilhetes()->where('lugar_id', $this->id)->get();

        if ($bilhetes->isEmpty()) {
            return false;
        }

        return true;
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function getPrettyLugar(): string
    {
        return $this->fila . $this->posicao;
    }
}
