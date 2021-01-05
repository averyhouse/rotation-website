<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeRatingSumsFloats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prefroshes', function(Blueprint $table) {
            $table->dropColumn('sumScore');

        });
        Schema::table('prefroshes', function(Blueprint $table) {
            $table->float('sumScore')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prefroshes', function(Blueprint $table) {
            $table->dropColumn('sumScore');
            $table->integer('sumScore')->default(0);
        });
    }
}
