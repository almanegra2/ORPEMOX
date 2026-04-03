<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tipo_usuario', function (Blueprint $table) {
            $table->increments('id_tipo');
            $table->string('tipo', 100)->default('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_usuario');
    }
};
