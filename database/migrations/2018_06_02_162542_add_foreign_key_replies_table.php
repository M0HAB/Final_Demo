<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('replies', function (Blueprint $table) {
        $table->foreign('post_id')->references('id')->on('posts');
        $table->foreign('user_id')->references('id')->on('users');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('replies', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropForeign(['post_id']);
      });

    }
}
