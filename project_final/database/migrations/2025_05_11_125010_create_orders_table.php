<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id_order');
            $table->string('status');
            $table->dateTime('date_order')->nullable();
            $table->dateTime('date_end_order')->nullable();
            $table->unsignedInteger('user_id_user');
            $table->decimal('total_price', 10, 2);

            $table->foreign('user_id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
