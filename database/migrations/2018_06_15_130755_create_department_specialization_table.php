<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentSpecializationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_specialization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dep_id')->unsigned()->nullable();
            $table->integer('spec_id')->unsigned()->nullable();
            $table->foreign('dep_id')->references('id')->on('departments');
            $table->foreign('spec_id')->references('id')->on('specializations');
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
        Schema::dropIfExists('department_specialization');
    }
}
