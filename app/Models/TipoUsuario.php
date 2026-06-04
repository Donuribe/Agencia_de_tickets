<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $table = 'tipo_usuarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_tipo',
        'estado',
    ];

    // Relación 1:N con usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class, 'tipo_usuario_id');
    }
}
