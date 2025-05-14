<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product');
            $table->string('name_product', 100);
            $table->text('description')->nullable();
            $table->float('price');
            $table->char('if_active', 1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
