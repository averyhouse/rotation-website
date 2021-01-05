<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'rating',
        'review',
    ];

    /*
     * Get the user who this comment belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*
     * Get the prefrosh this comment is about.
     */
    public function prefrosh()
    {
        return $this->belongsTo('App\Prefrosh');
    }
}
