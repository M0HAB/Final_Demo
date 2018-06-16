<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFksToSeveralTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->dropUnique('discussions_course_id_unique');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('course_department');
            $table->dropColumn('course_specialization');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('course_department')->unsigned()->nullable();
            $table->integer('course_specialization')->unsigned()->nullable();
            $table->foreign('course_department')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('course_specialization')->references('id')->on('specializations')->onDelete('cascade');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('friend_id');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('friend_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('friend_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->dropForeign('discussions_course_id_foreign');
            $table->unique(['course_id']);
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign('courses_course_department_foreign');
            $table->dropForeign('courses_course_specialization_foreign');
            $table->dropColumn('course_department');
            $table->dropColumn('course_specialization');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->string('course_department');
            $table->string('course_specialization');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_user_id_foreign');
            $table->dropForeign('messages_friend_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('friend_id');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('friend_id')->unsigned();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_module_id_foreign');
        });
    }
}
