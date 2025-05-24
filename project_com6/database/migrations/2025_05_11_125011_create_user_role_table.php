<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id_user');
            $table->unsignedBigInteger('role_id_role');
            $table->date('date_start1');
            $table->date('date_end1')->nullable();

            $table->primary(['user_id_user', 'role_id_role']);

            $table->foreign('user_id_user')->references('id_user')->on('users');
            $table->foreign('role_id_role')->references('id_role')->on('roles');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('user_role');
    }
};
