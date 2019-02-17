<?php

namespace RalphMorris\LaravelInstagram\Exceptions;

use Exception;
use RalphMorris\LaravelInstagram\Models\InstagramProfile;

class InstagramErrorException extends Exception
{
    public static function errorGettingFeed(InstagramProfile $instagram)
    {
        return new static("Instagram model id {$instagram->id} failed to retrieve their Instagram feed.");
    }
}