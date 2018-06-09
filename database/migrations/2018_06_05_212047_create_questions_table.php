<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{

    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
            $table->string('first_choice');
            $table->string('second_choice');
            $table->string('third_choice');
            $table->string('fourth_choice');
            $table->string('correct_choice');
            $table->integer('question_points');
            $table->integer('quiz_id')->unsigned();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
