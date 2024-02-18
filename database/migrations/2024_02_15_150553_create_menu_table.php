<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->string('menu_id', 3)->primary();
            $table->string('id_level', 3)->nullable();
            $table->foreign('id_level')->references('id_level')->on('menu_level')->onDelete('cascade');
            $table->string('menu_name', 300);
            $table->string('menu_link', 300);
            $table->string('menu_icon', 300);
            $table->string('parent_id', 30)->nullable();
            $table->string('create_by', 30);
            $table->date('create_date');
            $table->string('delete_mark', 1)->default(0);
            $table->string('update_by', 30);
            $table->date('update_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}