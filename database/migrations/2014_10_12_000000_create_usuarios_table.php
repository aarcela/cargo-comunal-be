<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id();
            $table->string('username', 20)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('activo')->default(true);
            $table->char('estado', 15)->default('pendiente'); // 'pendiente' | 'aprobado' | 'cancelado'
            $table->char('role', 20); // "conductor" | "solicitante" | "administrador" | "analista"
            $table->text('ruta_image')->nullable();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
