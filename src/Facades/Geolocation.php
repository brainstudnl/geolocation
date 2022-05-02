<?php

namespace Brainstud\Geolocation\Facades;

use Brainstud\Geolocation\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Location getLocation(Request $request)
 */
class Geolocation extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'geolocation';
    }
}
