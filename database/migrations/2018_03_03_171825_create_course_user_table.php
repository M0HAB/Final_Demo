<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseUserTable extends Migration
{

    public function up()
    {
        Schema::create('course_user', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->boolean('is_passed')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('course_user');
    }
}
