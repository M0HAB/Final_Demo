<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_books', function (Blueprint $table) {
            $table->increments('id');
            $table->float('assignments_weight')->nullable();
            $table->float('quizzes_weight')->nullable();
            $table->float('midterm_weight')->nullable();
            $table->float('finalexam_weight')->nullable();
            $table->float('practical_weight')->nullable();

            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grade_books');
    }
}
