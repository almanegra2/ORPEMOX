<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->increments('id_empresa');
            $table->string('nombre', 255)->nullable();
            $table->string('ubicacion', 255)->nullable();
            $table->string('telefono', 20)->default('');
            $table->string('ruc', 50)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('foto', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
