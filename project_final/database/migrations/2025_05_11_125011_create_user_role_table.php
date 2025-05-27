<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTable extends Migration
{
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->unsignedInteger('user_id_user');
            $table->unsignedInteger('role_id_role');
            $table->date('date_start1')->nullable();
            $table->date('date_end1')->nullable();

            $table->primary(['user_id_user', 'role_id_role']);

            $table->foreign('user_id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('role_id_role')->references('id_role')->on('roles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}
