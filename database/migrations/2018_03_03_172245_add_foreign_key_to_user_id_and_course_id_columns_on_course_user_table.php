<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToUserIdAndCourseIdColumnsOnCourseUserTable extends Migration
{

    public function up()
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropForeign('course_user_user_id_foreign');
            $table->dropForeign('course_user_course_id_foreign');
        });
    }
}
