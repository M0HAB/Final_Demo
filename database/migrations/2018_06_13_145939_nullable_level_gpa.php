<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableLevelGpa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('level');
          $table->dropColumn('gpa');
      });
      Schema::table('users', function (Blueprint $table) {
          $table->integer('level')->nullable();
          $table->decimal('gpa')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('level');
          $table->dropColumn('gpa');
      });
      Schema::table('users', function (Blueprint $table) {
          $table->integer('level');
          $table->decimal('gpa');
      });
    }
}
