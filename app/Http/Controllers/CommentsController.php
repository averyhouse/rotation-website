<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CommentRequest;
use App\Http\Requests;
use App\Comment;
use App\Prefrosh;
use App\User;
use Illuminate\Support\Facades\View;

class CommentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /* show page to edit a comment
     * Note: id is of prefrosh since a user should only be able to edit one comment per prefrosh
     * */
    public function edit($id)
    {

        $prefrosh = Prefrosh::findOrFail($id);
        $comment = $prefrosh->comments()->where('user_id', \Auth::user()->id)->first();
        if ($comment->user_id != \Auth::user()->id) {
            return "Access denied";
        }
        $meals = $prefrosh->meals()->get();
        return view('comments.edit', compact('comment', 'prefrosh', 'meals'));
    }

    public function update($id, CommentRequest $request)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id != \Auth::user()->id) {
            return "Access denied" . $comment . "not equal to " . \Auth::user()->id;
        }

        // Edit counts.
        $prefrosh = Prefrosh::findOrFail($comment->prefrosh_id);
        $prefrosh->sumScore += $request->rating - $comment->rating;
        $prefrosh->numComments += !empty($request->review) - !empty($comment->review);
        if ($prefrosh->numComments > 0) {
            $prefrosh->averageScore = $prefrosh->numScore / pow($prefrosh->numComments, 0.5);
        } else {
            $prefrosh->averageScore = 0.0;
        }
        $prefrosh->save();

        $comment->update($request->all());
        return redirect(action('HomeController@show', $comment->prefrosh()->first()->meals()->first()->id));
    }

    /* show page of comment
       Note: id is of prefrosh
    */
    public function show($id)
    {
        if (!\Auth::user()->isAdmin()) {
            return redirect('/');
        }

        $prefrosh = Prefrosh::findOrFail($id);
        $meals = $prefrosh->meals()->get();
        $comments = $prefrosh->comments()->get();
        $numComments = 0;
        $sumScore = 0;
        foreach($comments as $comment) {
            if(!empty($comment->review)) {
                $numComments++;
                $sumScore += $comment->rating;
            }
        }
        $prefrosh->numComments = $numComments;
        $prefrosh->sumScore = $sumScore;
        if ($prefrosh->numComments > 0) {
            $prefrosh->averageScore = $prefrosh->numScore / pow($prefrosh->numComments, 0.5);
        } else {
            $prefrosh->averageScore = 0.0;
        }
        $prefrosh->save();
        return view('admin.prefrosh', compact('prefrosh', 'comments', 'meals'));
    }

    public function migrate()
    {
        $file = fopen('/home/david/gdrive/avery_house/avery_rotation/public/migrate.csv', 'r');
        $legend = fgetcsv($file);
        // Parse legend.
        for ($idx = 2; $idx < count($legend); $idx++) {
            $legend[$idx] = str_replace('(', '"', $legend[$idx]);
            $legend[$idx] = str_replace(')', '"', $legend[$idx]);
            $legend[$idx] = substr($legend[$idx],
                strpos($legend[$idx], ', ') + 2) . ' ' . substr($legend[$idx], 0, strpos($legend[$idx], ', '));
        }

        $wrong = 0;
        $errors = array();
        while (true) {
            $entry = fgetcsv($file);
            if(!$entry)
            {
                break;
            }
            $user = User::where('name', $entry[1])->first();
            if (empty($user)) {
                continue;
            }

            for ($idx = 2; $idx < count($entry); $idx++) {
                // Check if comment exists, skip otherwise.
                if (!$entry[$idx]) {
                    continue;
                }
                // Get comment.
                $prefrosh = Prefrosh::where('name', $legend[$idx])->first();
                // Add error if prefrosh name not found.
                if (empty($prefrosh)) {
                    if (!empty($entry[$idx])) {
                        $wrong += 1;
                        array_push($errors, $legend[$idx]);
                    }
                    continue;
                }
                $comment = $user->comments()->where('prefrosh_id', $prefrosh->id)->first();
                if ($idx % 2 == 0) { // Even columns are ratings, odd are comments.
                    $comment->rating = (float)$entry[$idx];
                } else {
                    $comment->review = $entry[$idx];
                }
                $comment->save();
            }


        }
        return $errors;


    }

}
