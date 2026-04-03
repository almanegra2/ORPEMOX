<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->unsignedInteger('tipo_usuario');
            $table->string('nombre', 100)->nullable();
            $table->string('apellido', 100)->nullable();
            $table->string('usuario', 100);
            $table->string('password', 255);
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 100)->nullable();
            $table->string('correo', 100);
            $table->string('foto', 255)->nullable();
            $table->tinyInteger('estado');
            $table->foreign('tipo_usuario')->references('id_tipo')->on('tipo_usuario')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
