<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genero extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'generos';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'nome',
    ];

    public function filmes()
    {
        return $this->hasMany(Filme::class, 'genero_code', 'code');
    }
}
