<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('my_users')->onDelete('cascade');
            $table->integer('total');
            $table->enum('status', ['preparing', 'ready', 'delivered', 'cancelled']);
            $table->text('message')->nullable();
            $table->string('pick_up_date');
            $table->enum('payment_type', ['efectivo', 'transferencia']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
