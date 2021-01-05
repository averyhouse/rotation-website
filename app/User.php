<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

define("LIVE_SCORE", 20);
define("LIVE_BONUS", 5);
define("DEAD_SCORE", 15);
define("BASE_WEIGHT", 10);

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Returns if current user is an admin
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /*
     * Get all comments associated with user.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
