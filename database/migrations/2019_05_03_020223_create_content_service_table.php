<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dcos_content_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id')->nullable()->unsigned();
            $table->string('picture')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->string('flag_active')->default('N');
            $table->timestamps();
        });

        Schema::table('dcos_content_service', function($table) {
            $table->foreign('users_id')->references('id')->on('dcos_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dcos_content_service');
    }
}
