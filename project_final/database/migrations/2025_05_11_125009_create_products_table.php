<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id_product');
            $table->string('name_product');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('if_active')->default(true);
            $table->string('image')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
