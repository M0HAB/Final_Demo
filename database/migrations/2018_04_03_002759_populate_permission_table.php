<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // populate DB with default permissions
        DB::table('permissions')->insert(
            array(
                array('index' => '1', 'name' => 'Department'),
                array('index' => '2', 'name' => 'index2'),
                array('index' => '3', 'name' => 'index3'),
                array('index' => '4', 'name' => 'index4'),
                array('index' => '5', 'name' => 'index5'),
                array('index' => '6', 'name' => 'index6'),            
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $index = array('1', '2', '3', '4', '5', '6');
        DB::table('permissions')->whereIn('index', $index)->delete();  
    }
}
