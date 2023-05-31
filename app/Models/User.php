<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo',
        'bloqueado',
        'foto_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'id');
    }

    public function getAvatarPath(): string
    {
        if (!$this->foto_url) {
            return '/img/user_default.jpg';
        }

        return '/storage/fotos/' . $this->foto_url;
    }

    public function getPrettyTipo(): string
    {
        switch ($this->tipo) {
            case 'A':
                return 'Administrador';
            case 'F':
                return 'Funcionário';
            case 'C':
                return 'Cliente';
            default:
                return 'Desconhecido';
        }
    }
}
