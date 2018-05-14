<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraintsToModuleIdOnLessonsTable extends Migration
{

    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->foreign('module_id')
                ->references('id')->on('modules')
                ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign('lessons_module_id_foreign');
        });
    }
}
