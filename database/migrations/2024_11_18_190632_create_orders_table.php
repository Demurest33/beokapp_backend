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
            $table->decimal('total', 8, 2);
            $table->enum('status', ['preparando', 'listo', 'entregado', 'cancelado']);
            $table->text('message')->nullable();
            $table->text('cancelation_msg')->nullable();
            $table->string('pick_up_date');
            $table->enum('payment_type', ['efectivo', 'transferencia']);
            $table->boolean('is_fav')->default(false);
            $table->string('hash')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
