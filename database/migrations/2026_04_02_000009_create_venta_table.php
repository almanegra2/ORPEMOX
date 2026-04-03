<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->increments('id_venta');
            $table->unsignedInteger('id_cliente');
            $table->unsignedInteger('id_usuario');
            $table->dateTime('fecha');
            $table->decimal('total', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0.00);
            $table->decimal('pagoTotal', 10, 2)->nullable();
            $table->tinyInteger('estado')->nullable();
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};
