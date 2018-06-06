<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VotesFkAndUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('votes', function (Blueprint $table) {
        $table->foreign('reply_id')->references('id')->on('replies');
        $table->foreign('user_id')->references('id')->on('users');
        $table->unique(['reply_id', 'user_id']);
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('votes', function (Blueprint $table) {
        $table->dropForeign(['reply_id']);
        $table->dropForeign(['user_id']);
        $table->dropUnique('votes_reply_id_user_id_unique');
      });
    }
}
