<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIErrorApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_error_application', function (Blueprint $table) {
            $table->id('error_id');
            $table->string('id_user', 30)->nullable();
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->string('error_date', 3);
            $table->string('modules', 100);
            $table->string('controller', 200);
            $table->string('function', 200);
            $table->string('error_line', 30);
            $table->string('error_message', 1000);
            $table->string('status', 30);
            $table->string('param', 300)->nullable();
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
        Schema::dropIfExists('i_error_application');
    }
}