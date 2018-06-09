<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeleteDepartmentsDiscussionsPostsReplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('departments', function ($table) {
        $table->softDeletes();
      });
      Schema::table('discussions', function ($table) {
        $table->softDeletes();
      });
      Schema::table('posts', function ($table) {
        $table->softDeletes();
      });
      Schema::table('replies', function ($table) {
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('departments', function ($table) {
        $table->dropSoftDeletes();
      });
      Schema::table('discussions', function ($table) {
        $table->dropSoftDeletes();
      });
      Schema::table('posts', function ($table) {
        $table->dropSoftDeletes();
      });
      Schema::table('replies', function ($table) {
        $table->dropSoftDeletes();
      });
    }
}
