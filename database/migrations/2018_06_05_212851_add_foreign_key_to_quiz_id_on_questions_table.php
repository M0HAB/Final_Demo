<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToQuizIdOnQuestionsTable extends Migration
{

    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('quiz_id')
                ->references('id')->on('quizzes')
                ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign('questions_quiz_id_foreign');
        });
    }
}
