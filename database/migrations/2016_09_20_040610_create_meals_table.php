<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('name');
            $table->timestamps();
        });

        Schema::create('meal_prefrosh', function(Blueprint $table)
        {
            $table->integer('prefrosh_id')->unsigned()->index();
            // setup foreign key.
            $table->foreign('prefrosh_id')->references('id')->on('prefroshes')->onDelete('cascade');

            $table->integer('meal_id')->unsigned()->index();
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');

            $table->boolean('present')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('meal_prefrosh');
        Schema::drop('meals');

    }
}
