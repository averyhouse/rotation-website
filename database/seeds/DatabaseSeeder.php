<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();

        // debugging
        //$this->call(testGotchaSeeder::class);


        // production
        $this->call(gameSeeder::class);

        // Migration
        $this->call(testGotchaSeeder::class);
        //Model::reguard();
    }
}
