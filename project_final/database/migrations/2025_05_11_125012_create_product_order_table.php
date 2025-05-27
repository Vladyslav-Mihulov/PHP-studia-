<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrderTable extends Migration
{
    public function up()
    {
        Schema::create('product_order', function (Blueprint $table) {
            $table->unsignedInteger('order_id_order');
            $table->unsignedInteger('product_id_product');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            $table->primary(['order_id_order', 'product_id_product']);

            $table->foreign('order_id_order')->references('id_order')->on('orders')->onDelete('cascade');
            $table->foreign('product_id_product')->references('id_product')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_order');
    }
}
