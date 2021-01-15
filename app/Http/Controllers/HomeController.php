<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Meal;
use Illuminate\Support\Facades\View;
use App\Http\Requests\PasswordRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $defaultMeal = 0;
        // return redirect(action('HomeController@show', $defaultMeal));
        return redirect(action('UsersController@index'));
    }

    /**
     * Shows a meal
     */
    public function show($id)
    {
        if ($id == 0) {
            return redirect(action('UsersController@index'));
        }
        View::share('curMealID', $id);
        $meal = Meal::findOrFail($id);
        // Get all prefrosh associated with meal
        $prefrosh = $meal->prefrosh()->orderBy('lastName', 'asc')->get();

        // Aggregate data is isAdmin.
        if(\Auth::user()->isAdmin())
        {
            foreach ($prefrosh as $prefroshy) {
                $comments = $prefroshy->comments()->get();
                $numComments = 0;
                $sumScore = 0;
                foreach($comments as $comment) {
                    if(!empty($comment->review)) {
                        $numComments++;
                        $sumScore += $comment->rating;
                    }
                }
                $prefroshy->numComments = $numComments;
                $prefroshy->sumScore = $sumScore;
            }
            return view('admin.meal', compact('meal', 'prefrosh'));
        }
        // Get all comments associated with found prefrosh
        $comments = array();
        foreach ($prefrosh as $prefroshy) {
            $comment = $prefroshy->comments()->where('user_id', \Auth::user()->id)->first();
            array_push($comments, $comment);
        }
        return view('meals.show', compact('meal', 'prefrosh', 'comments'));
    }

    public function passwordChange(PasswordRequest $request)
    {
        $user = \Auth::user();
        if (Hash::check($request->oldPassword, $user->password)) {
            $user->password = bcrypt($request->newPassword);
            $user->save();
        }
        return redirect(action('HomeController@index'));
    }
}
