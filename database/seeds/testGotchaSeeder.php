<?php

use Illuminate\Database\Seeder;

class testGotchaSeeder extends Seeder
{
    /**
     * Migrate database.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen('/home/david/gdrive/avery_house/avery_rotation/public/migration.csv', 'r');
        $legend = fgetcsv($file);

        while (true) {
            $entry = fgetcsv($file);
            if(!$entry)
            {
                break;
            }
            $user = App\User::where('name', $entry[0])->first();
            if (empty($user)) {
                continue;
            }

            for ($idx = 1; $idx < count($entry); $idx++) {
                // Get comment.
                $prefrosh = App\Prefrosh::where('name', substr($legend[$idx], strpos($legend[$idx], '. ') + 2))->first();
                if (empty($prefrosh)) {
                    continue;
                }
                $comment = $user->comments()->where('prefrosh_id', $prefrosh->id)->first();
                $comment->rating = (int)substr($entry[$idx], 0, 2);
                $comment->review = substr($entry[$idx], 2);
                $comment->save();
            }


        }


    }
}
