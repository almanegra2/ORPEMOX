<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id_producto');
            $table->unsignedInteger('id_categoria');
            $table->string('codigo', 255)->nullable();
            $table->string('nombre', 50);
            $table->decimal('precio', 10, 2);
            $table->integer('stock');
            $table->string('descripcion', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->tinyInteger('estado');
            $table->foreign('id_categoria')->references('id_categoria')->on('categoria')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
