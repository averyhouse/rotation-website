<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefrosh extends Model
{
    protected $fillable = [
        'name',
        'picture'
    ];

    /*
     * Get comments about this prefrosh.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /*
     * Get meals prefrosh should go to.
     */
    public function meals()
    {
        return $this->belongsToMany('App\Meal');
    }
}
