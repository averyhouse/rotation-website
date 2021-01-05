<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'name'
    ];

    /*
     * Prefrosh registered for this meal.
     */
    public function prefrosh()
    {
        return $this->belongsToMany('App\Prefrosh', 'meal_prefrosh');
    }
}
