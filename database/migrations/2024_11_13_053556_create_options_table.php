<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Nombre de la opción
            $table->json('values');  // Almacenar las opciones como un JSON
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Relación con el producto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('options');
    }
};
