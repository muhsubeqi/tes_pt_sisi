<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_user', function (Blueprint $table) {
            $table->id('no_setting');
            $table->string('id_user', 30)->nullable();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->string('menu_id', 3)->nullable();
            $table->foreign('menu_id')->references('menu_id')->on('menu')->onDelete('cascade');
            $table->string('create_date', 30);
            $table->timestamp('create_time')->useCurrent();
            $table->string('delete_mark', 1)->default(0);
            $table->string('update_by', 30);
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
        Schema::dropIfExists('menu_user');
    }
}