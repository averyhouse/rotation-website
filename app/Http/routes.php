<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');


Route::auth();

Route::get('/passwordChange', function(){
    return redirect('/');
});

/*
Route::get('/passwordChange', function(){
    return view('auth.passwords.change');
});
Route::post('/passwordChange', 'HomeController@passwordChange');
*/


Route::get('/home', function(){
    return redirect('/');
});

Route::get('meals/{id}', 'HomeController@show');

Route::get('comments/{prefrosh_id}/{meal_id}/edit', 'CommentsController@edit');
Route::get('comments/{id}', 'CommentsController@show');
// Route::put('comments/{id}', 'CommentsController@update');
Route::resource('comments', 'CommentsController');

Route::get('users/index', 'UsersController@index');
// Route::put('users/index', 'UsersController@updateTiers');
Route::get('users/index/{id}', 'UsersController@sortedIndex');
// Route::put('users/index/{id}', 'UsersController@updateTiers');

Route::get('calendar', function() {
    return view('meals/calendar');
});

Route::get('migrate', 'CommentsController@migrate');

Route::get('mySubmissions', 'UsersController@mySubmissions');

Route::get('refresh', 'UsersController@recalculateScores');

Route::get('userProfiles', 'UsersController@userProfiles');
Route::get('users/{id}', 'UsersController@userIndex');
