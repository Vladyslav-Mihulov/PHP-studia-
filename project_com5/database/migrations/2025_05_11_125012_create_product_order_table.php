<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('product_order', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id_order');
            $table->unsignedBigInteger('product_id_product');
            $table->integer('quantity');
            $table->float('price');

            $table->primary(['order_id_order', 'product_id_product']);

            $table->foreign('order_id_order')->references('id_order')->on('orders');
            $table->foreign('product_id_product')->references('id_product')->on('products');
});

    }

    
    public function down(): void
    {
        Schema::dropIfExists('product_order');
    }
};
