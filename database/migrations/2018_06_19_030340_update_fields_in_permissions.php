<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsInPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // populate DB with default permissions
        $names = ['Department', 'Quiz', 'Discussion', 'Course', 'Assignment', 'Grade'];
        for ($i=0; $i < 6; $i++) {
            DB::table('pindexes')->where('index', $i+1)->update(['name' => $names[$i]]);
        }
        DB::table('roles')->where('name', 'student')->update(['permission' => 5242612]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $names = ['Department', 'index2', 'index3', 'index4', 'index5', 'index6'];
        for ($i=0; $i < 6; $i++) {
            DB::table('pindexes')->where('index', $i+1)->update(['name' => $names[$i]]);
        }
        DB::table('roles')->where('name', 'student')->update(['permission' => 4473924]);
    }
}
