<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entrada', function (Blueprint $table) {
            $table->increments('id_entrada');
            $table->unsignedInteger('id_producto');
            $table->unsignedInteger('id_proveedor')->nullable();
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->dateTime('fecha')->nullable();
            $table->foreign('id_producto')->references('id_producto')->on('producto')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedor')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrada');
    }
};
