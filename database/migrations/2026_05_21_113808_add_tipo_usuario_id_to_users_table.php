<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'tipo_usuario_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('tipo_usuario_id')
                    ->nullable()
                    ->after('photo')
                    ->constrained('tipo_usuarios')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'tipo_usuario_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['tipo_usuario_id']);
                $table->dropColumn('tipo_usuario_id');
            });
        }
    }
};
