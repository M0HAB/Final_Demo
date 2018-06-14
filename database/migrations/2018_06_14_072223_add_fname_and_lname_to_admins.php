<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFnameAndLnameToAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('api_token')->after('password');
            $table->string('fname')->after('id');
            $table->string('lname')->after('fname');
            $table->dropColumn('name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('api_token')->after('password');
            $table->dropColumn('fname')->after('id');
            $table->dropColumn('lname')->after('fname');
            $table->string('name');
        });
    }
}
