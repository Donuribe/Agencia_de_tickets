<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $primaryKey = 'id';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'estado',
        'registrado_por',
        'fecha_creacion',
        'fecha_cierre',
        'cliente_id',
        'usuario_asignado_id',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'fecha_creacion' => 'datetime',
            'fecha_cierre' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuarioAsignado()
    {
        return $this->belongsTo(User::class, 'usuario_asignado_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'ticket_id');
    }
}
