<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePhotosToFilesAndRemoveUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('photos', function (Blueprint $table) {
        $table->dropUnique('photos_relate_id_relate_type_unique');
      });
      Schema::rename('photos', 'files');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::rename('files', 'photos');
      Schema::table('photos', function (Blueprint $table) {
        $table->unique(['relate_id', 'relate_type']);
      });

    }
}
