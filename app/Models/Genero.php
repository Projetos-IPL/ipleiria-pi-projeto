<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'generos';

    // TODO fix deleted_at column

    protected $fillable = [
        'code',
        'nome',
        'deleted_at'
    ];

    public function filmes()
    {
        return $this->hasMany(Filme::class, 'genero_code', 'code');
    }
}
