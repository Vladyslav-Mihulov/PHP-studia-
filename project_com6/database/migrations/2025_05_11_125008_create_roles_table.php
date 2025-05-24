<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('role_name', 50);
            $table->char('active', 1);
            $table->date('date_start');
            $table->date('date_end')->nullable();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
