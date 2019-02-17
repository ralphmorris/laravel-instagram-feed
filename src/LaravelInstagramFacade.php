<?php

namespace RalphMorris\LaravelInstagram;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RalphMorris\LaravelInstagram\Skeleton\SkeletonClass
 */
class LaravelInstagramFacade extends Facade
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
