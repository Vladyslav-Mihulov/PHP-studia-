<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->int('status')->nullable();
            $table->dateTime('date_order');
            $table->dateTime('date_end_order')->nullable();
            $table->unsignedBigInteger('user_id_user');
            $table->float('total_price');
            
            $table->foreign('user_id_user')->references('id_user')->on('users');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
