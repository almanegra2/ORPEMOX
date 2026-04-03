<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('id_cliente');
            $table->string('dni', 50)->nullable();
            $table->string('nombre', 100)->default('');
            $table->string('apellido', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('correo', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
