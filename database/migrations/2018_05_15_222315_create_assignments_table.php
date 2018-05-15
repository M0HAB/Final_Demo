<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('file')->nullable();
            $table->dateTime('deadline');
            $table->timestamps();
            //TODO foreign key to module of the course
            $table->integer('module_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
