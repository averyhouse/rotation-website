<?php

use Illuminate\Database\Seeder;

class gameSeeder extends Seeder
{

    public function run()
    {

        // Create all users.
        $file = fopen('/home/david/gdrive/avery_house/avery_rotation/public/users.csv', 'r');
        while (true) {
            $user = fgetcsv($file);
            if(!$user)
            {
                break;
            }
            $curUser = factory(App\User::class)->make();
            $curUser->name = $user[0];
            $curUser->email = $user[1];
            $curUser->password = bcrypt($user[2]);
            $curUser->save();
        }

        // Create admin user.
        $adminUser = factory(App\User::class)->make();
        $adminUser->name = 'admin';
        $adminUser->email = 'admin@admin.com';
        $adminUser->password = bcrypt('whale17');
        $adminUser->admin = True;
        $adminUser->save();

        // Create all prefrosh.
        $file = fopen('/home/david/gdrive/avery_house/avery_rotation/public/prefrosh.csv', 'r');
        $first = true;
        $numMeals = 0;
        while (true) {
            // Make Dinners.
            if($first)
            {
                $dinners = fgetcsv($file);
                while (!empty($dinners[$numMeals + 3]))
                {
                    $curMeal = factory(App\Meal::class)->make();
                    $curMeal->name = $dinners[$numMeals + 3];
                    $curMeal->save();
                    $numMeals++;
                }

                $first = false;
            }
            // Parse prefrosh.
            $prefrosh = fgetcsv($file);
            if(!$prefrosh)
            {
                break;
            }
            $curPrefrosh = factory(App\Prefrosh::class)->make();
            // If no nickname.
            if(empty($prefrosh[2]))
            {
                $curPrefrosh->name = $prefrosh[1] . ' ' . $prefrosh[0];

            } else
            {
                $curPrefrosh->name = $prefrosh[1] . ' "' . $prefrosh[2] . '" ' . $prefrosh[0];

            }
            $curPrefrosh->picture = $prefrosh[0] . '_' . $prefrosh[1] . '.JPG';

            $curPrefrosh->lastName = $prefrosh[0];
            $curPrefrosh->save();
            for ($idx = 3; $idx < $numMeals + 3; $idx++)
            {
                if ($prefrosh[$idx] != 0) {
                    // Note ids are 1 indexed.
                    $curPrefrosh->meals()->attach($idx - 2);
                    $curPrefrosh->save();
                }
            }

        }

        // Create comments for each user x prefrosh pair.
        foreach (\App\User::all() as $user)
        {
            foreach (\App\Prefrosh::all() as $prefrosh)
            {
                $curComment = factory(App\Comment::class)->make();
                $curComment->user_id = $user->id;
                $curComment->prefrosh_id = $prefrosh->id;
                $curComment->save();
            }
        }






    }
}
