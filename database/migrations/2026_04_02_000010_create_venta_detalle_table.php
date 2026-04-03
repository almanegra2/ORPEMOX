<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('venta_detalle', function (Blueprint $table) {
            $table->increments('id_venta_detalle');
            $table->unsignedInteger('id_venta');
            $table->unsignedInteger('id_producto');
            $table->decimal('precio', 10, 2)->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->tinyInteger('estado')->nullable();
            $table->foreign('id_producto')->references('id_producto')->on('producto')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_venta')->references('id_venta')->on('venta')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta_detalle');
    }
};
