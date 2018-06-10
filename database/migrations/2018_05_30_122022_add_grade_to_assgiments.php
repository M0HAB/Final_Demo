<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGradeToAssgiments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->integer('full_mark')->unsigned()->nullable();
        });
        Schema::table('assdelivers', function (Blueprint $table) {
            $table->decimal('grade')->unsigned()->nullable();
            $table->string('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('assignments', function (Blueprint $table) {
        $table->dropColumn('full_mark');
    });
        Schema::table('assdelivers', function (Blueprint $table) {
            $table->dropColumn('grade');
        });
    }
}
