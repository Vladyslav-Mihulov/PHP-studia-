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
            $table->string('status', 25)->nullable();
            $table->date('date_order');
            $table->date('date_end_order')->nullable();
            $table->unsignedBigInteger('user_id_user');

            $table->foreign('user_id_user')->references('id_user')->on('users');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
