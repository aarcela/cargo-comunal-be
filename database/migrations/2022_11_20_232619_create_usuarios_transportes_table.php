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
    public function up()
    {
        Schema::create('usuarios_transportes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->uuid('id_user_transporte')->primary();
            $table->uuid('id_user');

            $table->string('nro_placa', 40);
            $table->string('marca', 40);
            $table->string('modelo', 40);
            $table->string('carnet_circulacion', 40);
            $table->string('carga_maxima', 40);
            $table->char('tipo', 36)->nullable();
            $table->char('estado', 15)->default('pendiente'); // 'pendiente' | 'aprobado' | 'cancelado'

            $table->dateTime('fecha_creado');
            $table->dateTime('fecha_editado');

            $table->foreign('id_user')
                ->references('id_user')
                ->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios_transportes');
    }
};
