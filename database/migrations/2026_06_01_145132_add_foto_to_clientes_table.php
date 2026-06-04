<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('registradopor');
        });

        // Asignar foto aleatoria a los clientes existentes
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

        $clientes = DB::table('clientes')->get();
        foreach ($clientes as $cliente) {
            DB::table('clientes')
                ->where('id', $cliente->id)
                ->update(['foto' => $fotos[array_rand($fotos)]]);
        }
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
