<?php

namespace RalphMorris\LaravelInstagram\Models;

use Illuminate\Database\Eloquent\Model;
use RalphMorris\LaravelInstagram\Instagram;

class InstagramProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'access_token',
    ];

    /**
     * Get all of the owning instagramable models.
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Get the feed for the given instance
     * 
     * @return array
     */
    public function getFeed()
    {
        return (new Instagram($this))->getFeed();
    }
}
