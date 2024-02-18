<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id_user', 30)->primary();
            $table->string('nama_user', 60);
            $table->string('username', 60);
            $table->string('password', 60);
            $table->string('email', 200);
            $table->string('no_hp', 30)->nullable();
            $table->string('wa', 30)->nullable();
            $table->string('pin', 30)->nullable();
            $table->string('id_jenis_user', 3)->nullable();
            $table->string('status_user', 30)->nullable();
            $table->string('delete_mark', 1)->default(0);
            $table->string('create_by', 30)->nullable();
            $table->timestamp('create_date')->useCurrent()->nullable();
            $table->string('update_by', 30)->nullable();
            $table->timestamp('update_date')->useCurrent()->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}