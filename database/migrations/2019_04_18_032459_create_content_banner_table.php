<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dcos_content_banner', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id')->nullable()->unsigned();
            $table->string('picture')->nullable();
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->string('url')->nullable();
            $table->string('flag_active')->default('N');
            $table->timestamps();
        });

        Schema::table('dcos_content_banner', function($table) {
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
        Schema::dropIfExists('dcos_content_banner');
    }
}
