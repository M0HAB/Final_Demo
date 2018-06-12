<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{

    public function up()
    {

        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('title', 200);
            $table->string('course_department');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('course_language');
            $table->string('course_specialization');
            $table->text('description');
            $table->text('how_to_pass');
            $table->integer('commitment');
            $table->boolean('is_active')->default(0);
            $table->integer('instructor_id')->unsigned();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
