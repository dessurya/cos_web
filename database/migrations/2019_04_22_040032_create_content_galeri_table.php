<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentGaleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dcos_galeri_content', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id')->nullable()->unsigned();
            $table->string('picture');
            $table->string('index');
            $table->integer('id_foreign');
            $table->timestamps();
        });

        Schema::table('dcos_galeri_content', function($table) {
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
        Schema::dropIfExists('dcos_galeri_content');
    }
}
