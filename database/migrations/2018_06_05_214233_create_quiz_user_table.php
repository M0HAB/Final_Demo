<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizUserTable extends Migration
{

    public function up()
    {
        Schema::create('quiz_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('quiz_id')->unsigned();
            $table->decimal('grade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_user');
    }
}
