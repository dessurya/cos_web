<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dcos_content_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id')->nullable()->unsigned();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('comments');
            $table->string('index');
            $table->integer('id_foreign');
            $table->timestamps();
        });

        Schema::table('dcos_content_comments', function($table) {
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
        Schema::dropIfExists('dcos_content_comments');
    }
}
