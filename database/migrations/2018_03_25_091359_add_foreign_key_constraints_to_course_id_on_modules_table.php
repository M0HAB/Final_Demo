<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraintsToCourseIdOnModulesTable extends Migration
{

    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropForeign('modules_course_id_foreign');
        });
    }
}
