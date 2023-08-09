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
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('nro_placa', 40)->nullable();
            $table->string('marca', 40)->nullable();
            $table->string('modelo', 40)->nullable();
            $table->string('carnet_circulacion', 40)->nullable();
            $table->string('carga_maxima', 40)->nullable();
            $table->char('tipo', 36)->nullable();
            $table->char('estado', 15)->default('pendiente'); // 'pendiente' | 'aprobado' | 'cancelado'

            $table->timestamps();
            $table->softDeletes();

            /** Relaciones */
            $table->foreign('user_id')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transports');
    }
};
