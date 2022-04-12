<?php

namespace Brainstud\UnlimitedGeolocation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Brainstud\UnlimitedGeolocation\UnlimitedGeolocation
 */
class UnlimitedGeolocation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'unlimited-geolocation';
    }
}
