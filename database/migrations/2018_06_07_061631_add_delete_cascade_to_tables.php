<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeleteCascadeToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('posts', function (Blueprint $table) {
        $table->dropForeign(['discussion_id']);
        $table->foreign('discussion_id')->references('id')->on('discussions')->onDelete('cascade');
      });
      Schema::table('replies', function (Blueprint $table) {
        $table->dropForeign(['post_id']);
        $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
      });
      Schema::table('votes', function (Blueprint $table) {
        $table->dropForeign(['reply_id']);
        $table->foreign('reply_id')->references('id')->on('replies')->onDelete('cascade');
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('posts', function (Blueprint $table) {
        $table->dropForeign(['discussion_id']);
        $table->foreign('discussion_id')->references('id')->on('discussions');
      });
      Schema::table('replies', function (Blueprint $table) {
        $table->dropForeign(['post_id']);
        $table->foreign('post_id')->references('id')->on('posts');
      });
      Schema::table('votes', function (Blueprint $table) {
        $table->dropForeign(['reply_id']);
        $table->foreign('reply_id')->references('id')->on('replies');
      });
    }
}
