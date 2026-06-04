<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'estado',
        'registradopor',
        'foto',
    ];

    // Relación con ticket(1:N)
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'cliente_id');
    }

    public static function getRandomFoto()
    {
        $fotos = [
            '/backend/dist/img/user1-128x128.jpg',
            '/backend/dist/img/user2-160x160.jpg',
            '/backend/dist/img/user3-128x128.jpg',
            '/backend/dist/img/user4-128x128.jpg',
            '/backend/dist/img/user5-128x128.jpg',
            '/backend/dist/img/user6-128x128.jpg',
            '/backend/dist/img/user7-128x128.jpg',
            '/backend/dist/img/user8-128x128.jpg',
        ];
        
        return $fotos[array_rand($fotos)];
    }
}
