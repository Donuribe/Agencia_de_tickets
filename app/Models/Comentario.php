<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User; // 🔥 IMPORTANTE importar el modelo

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'mensaje',
        'fecha',
        'registrado_por',
        'estado',
        'ticket_id',
        'usuario_id',
    ];

    // 🔥 Relación con Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // 🔥 Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
