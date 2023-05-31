<?php

namespace App\Models;

use App\Models\Lugar;
use App\Models\Recibo;
use App\Models\Sessao;
use App\Models\Cliente;
use App\Models\Configuracao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bilhete extends Model
{
    use HasFactory;

    protected $table = 'bilhetes';

    protected $fillable = [
        'recibo_id',
        'cliente_id',
        'sessao_id',
        'lugar_id',
        'preco_sem_iva',
        'estado',
    ];

    public function recibo()
    {
        return $this->belongsTo(Recibo::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function sessao()
    {
        return $this->belongsTo(Sessao::class);
    }

    public function lugar()
    {
        return $this->belongsTo(Lugar::class);
    }

    public function getPrecoComIva()
    {
        $valorIva = Configuracao::first()->percentagem_iva;
        return number_format($this->preco_sem_iva + ($this->preco_sem_iva * floatval($valorIva) / 100), 2, ',', '.');
    }

    public function getPrettyEstado()
    {
        return ucwords($this->estado);
    }
}
