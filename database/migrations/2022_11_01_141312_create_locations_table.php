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
        Schema::create('locations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->boolean('online')->default(false);
            $table->string('latitude', 40)->nullable();
            $table->string('longitude', 40)->nullable();
            $table->time('connection_time')->nullable();
            $table->date('connection_date')->nullable();
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
        Schema::dropIfExists('usuarios_location');
    }
};
