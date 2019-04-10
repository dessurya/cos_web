<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dcos_users_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id')->nullable()->unsigned();
            $table->text('logs');
            $table->timestamps();
        });

        Schema::table('dcos_users_logs', function($table) {
            $table->foreign('users_id')->references('id')->on('dcos_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dcos_users_logs');
    }
}
