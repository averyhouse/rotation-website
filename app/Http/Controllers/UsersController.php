<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\Prefrosh;
use App\User;

define("SHOW_TIERS", True);

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /*
     * Display all prefrosh and comments associated with current user.
     */
    public function index()
    {


        if (\Auth::user()->isAdmin()) {
            return redirect('users/index/2');
        }
        if (SHOW_TIERS) {
            $prefrosh = Prefrosh::orderBy('tier', 'desc')->orderBy('averageScore', 'desc')->get();
        } else {
            $prefrosh = Prefrosh::orderBy('lastName', 'asc')->get();
        }
        // Get all comments associated with prefrosh
        $comments = array();
        foreach ($prefrosh as $prefroshy) {
            $comment = $prefroshy->comments()->where('user_id', \Auth::user()->id)->first();
            array_push($comments, $comment);
        }

        $tier_names = array(2 => "Great", 1 => "Good", 0 => "Neutral", -1 => "No Information", -2 => "Poor");
        $show_tiers = SHOW_TIERS;
        return view('prefrosh.index', compact('prefrosh', 'comments', 'show_tiers', 'tier_names'));
    }

    public function sortedIndex($id)
    {
        // Recalculate scores.
        $prefrosh = Prefrosh::orderBy('lastName', 'asc')->get();

        foreach ($prefrosh as $prefroshy) {
            $comments = $prefroshy->comments()->get();
            $numComments = 0;
            $sumScore = 0;
            foreach ($comments as $comment) {
                if (!empty($comment->review)) {
                    $numComments++;
                    $sumScore += $comment->rating;
                }
            }
            $prefroshy->numComments = $numComments;
            $prefroshy->sumScore = $sumScore;
            if ($numComments > 0) {
                $prefroshy->averageScore = $sumScore / pow((float)$numComments, 0.5);
            } else {
                $prefroshy->averageScore = 0.0;
            }
            $prefroshy->save();
        }



        $sortType = $id;
        $show_ratings = True;
        if (\Auth::user()->isAdmin()) {
            if ($sortType == 1) { // By last name Alphabetical.
                $prefrosh = Prefrosh::orderBy('lastName', 'asc')->get();
            } elseif ($sortType == 2) { // By Average Rating
                $prefrosh = Prefrosh::orderBy('averageScore', 'desc')->orderBy('numComments', 'desc')->get();
            } elseif ($sortType == 3) { // By Ratings
                $prefrosh = Prefrosh::orderBy('sumScore', 'desc')->orderBy('numComments', 'asc')->get();
            } elseif ($sortType == 4) { // By reviews
                $prefrosh = Prefrosh::orderBy('numComments', 'desc')->orderBy('sumScore', 'desc')->get();
            } elseif ($sortType == 5) {
                $prefrosh = Prefrosh::orderBy('tier', 'desc')->orderBy('averageScore', 'desc')->orderBy('numComments', 'desc')->get();
            } elseif ($sortType == 6) { // Without ratings.
                $prefrosh = Prefrosh::orderBy('tier', 'desc')->orderBy('averageScore', 'desc')->orderBy('numComments', 'desc')->get();
                $show_ratings = False;
            }
            $categories = ["Alphabetical", "Average", "Ratings", "Reviews", "Tier", "No Ratings"];
            return view('admin.index', compact('prefrosh', 'comments', 'sortType', 'categories', 'show_ratings'));
        }
        return redirect('/');
    }

    public function mySubmissions()
    {
        $user = \Auth::user();
        // Admin should not submit feedback. Redirect to aggregate profiles.
        if (\Auth::user()->isAdmin()) {
            return redirect('/userProfiles');
        }
        $preComment = $user->comments()->whereRaw('LENGTH(review) > ?', [0])->get();
        $prefrosh = array();
        $comments = array();
        foreach ($preComment as $comment) {
            if (!empty($comment->review)) {
                array_push($comments, $comment);
                array_push($prefrosh, $comment->prefrosh()->first());
            }
        }

        return view('comments.index', compact('user', 'prefrosh', 'comments'));
    }

    // All comments from user id.
    public function userIndex($id) {
        $user = User::findOrFail($id);
        $preComment = $user->comments()->whereRaw('LENGTH(review) > ?', [0])->get();
        $prefrosh = array();
        $comments = array();
        foreach ($preComment as $comment) {
            if (!empty($comment->review)) {
                array_push($comments, $comment);
                array_push($prefrosh, $comment->prefrosh()->first());
            }
        }

        return view('comments.index', compact('user', 'prefrosh', 'comments'));
    }
    public function updateTiers(Request $request) {
        if (\Auth::user()->isAdmin()) {
            $prefrosh = Prefrosh::all();
            foreach ($prefrosh as $prefroshy) {
                $prefroshy->tier = $request->input($prefroshy->id);
                $prefroshy->save();
            }
        }
        return Redirect::back();
    }

    public function recalculateScores() {
        $prefrosh = Prefrosh::orderBy('lastName', 'asc')->get();

        foreach ($prefrosh as $prefroshy) {
            $comments = $prefroshy->comments()->get();
            $numComments = 0;
            $sumScore = 0;
            foreach ($comments as $comment) {
                if (!empty($comment->review)) {
                    $numComments++;
                    $sumScore += $comment->rating;
                }
            }
            $prefroshy->numComments = $numComments;
            $prefroshy->sumScore = $sumScore;
            if ($numComments > 0) {
                $prefroshy->averageScore = $sumScore / pow((float)$numComments, 0.5);
            } else {
                $prefroshy->averageScore = 0.0;
            }
            $prefroshy->save();
        }
        return 'success';
    }

    public function userProfiles() {
        if (!\Auth::user()->isAdmin()) {
            return redirect('/');
        }
        $users = \App\User::all();
        $activeUsers = array();
        foreach ($users as $user) {
            $comments = $user->comments()->get();
            $numComments = 0;
            $sumScore = 0;
            foreach ($comments as $comment) {
                if (!empty($comment->review)) {
                    $numComments++;
                    $sumScore += $comment->rating;
                }
            }
            $user->numComments = $numComments;
            $user->sumScore = $sumScore;
            if ($numComments > 0) {
                array_push($activeUsers, $user);
            }
        }

        // Sort users by num comments.
        usort($activeUsers, function($a, $b) {
           return $a->numComments < $b->numComments;
        });

        $users = $activeUsers;
        return view('admin.users', compact('users'));
    }

}
