<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('discussions', function (Blueprint $table) {
        $table->dropColumn('course_id');
      });
      Schema::table('discussions', function (Blueprint $table) {
        $table->integer('course_id')->unsigned()->nullable()->unique();
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
        $table->dropColumn('course_id');
      });
      Schema::table('discussions', function (Blueprint $table) {
        $table->integer('course_id')->unsigned()->nullable();
      });
    }
}
