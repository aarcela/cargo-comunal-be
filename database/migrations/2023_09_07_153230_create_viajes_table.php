<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('viajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('transport_id');
            $table->string('ruta')->nullable();
            $table->string('tiempo')->nullable();
            $table->time('hora')->nullable();
            $table->string('peso')->nullable();
            $table->string('status', 15, ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->string('latitud_origen', 40)->nullable();
            $table->string('longitud_origen', 40)->nullable();
            $table->string('latitud_destino', 40)->nullable();
            $table->string('longitud_destino', 40)->nullable();
            $table->timestamps();
            $table->softDeletes();

            /** Relaciones */
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('transport_id')->references('id')->on('transports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('viajes');
    }
};
