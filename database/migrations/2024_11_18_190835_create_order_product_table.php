<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->text('cancelation_msg')->nullable();
            $table->decimal('price', 8, 2); // Columna de precio
            $table->json('selected_options')->nullable();
            $table->string('image_url')->nullable(); // URL de la imagen
            $table->string('product_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_product');
    }
};
