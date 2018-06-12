<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssdeliversTable extends Migration
{
    public function up()
    {
        Schema::create('assdelivers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('answer')->nullable();
            $table->string('file')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('ass_id')->unsigned();
            $table->foreign('ass_id')->references('id')->on('assignments')->onDelete('cascade');




            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assdelivers');
    }
}
