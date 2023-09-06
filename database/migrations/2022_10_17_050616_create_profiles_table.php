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
        Schema::create('profiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('first_name', 16)->nullable();
            $table->string('second_name', 16)->nullable();
            $table->string('first_surname', 16)->nullable();
            $table->string('second_surname', 16)->nullable();
            $table->string('phone')->nullable();
            $table->text('ci')->nullable();
            $table->date('fecha_nc')->nullable();
            $table->timestamps();
            $table->softDeletes();

            /** Relaciones */
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
