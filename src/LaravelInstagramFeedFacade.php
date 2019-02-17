<?php

namespace RalphMorris\LaravelInstagramFeed;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RalphMorris\LaravelInstagramFeed\Skeleton\SkeletonClass
 */
class LaravelInstagramFeedFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'instagram';
    }
}
