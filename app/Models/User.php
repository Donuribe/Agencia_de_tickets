<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Ticket;
use App\Models\Comentario;
use App\Models\TipoUsuario;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'estado',
        'tipo_usuario_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Tickets del usuario
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    // Comentarios del usuario
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'usuario_id');
    }

    // Tipo de usuario
    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'tipo_usuario_id');
    }
}
