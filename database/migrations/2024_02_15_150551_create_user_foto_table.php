<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_foto', function (Blueprint $table) {
            $table->id('no_foto');
            $table->string('id_user', 30)->nullable();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->string('foto', 300)->nullable();
            $table->string('create_by', 30);
            $table->timestamp('create_date')->useCurrent();
            $table->string('delete_mark', 1)->default(0);
            $table->string('update_by', 1);
            $table->timestamp('update_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_foto');
    }
}