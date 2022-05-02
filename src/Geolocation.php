<?php

namespace Brainstud\Geolocation;

use Brainstud\Geolocation\GeoLocators\GeoLocatorFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Geolocation
{
    /**
     * Get the geolocation of a request.
     *
     * @param Request $request
     * @return Location|null
     */
    public static function getLocation(Request $request): ?Location
    {
        if ($country = self::getFromHeader($request)) {
            return $country;
        }
        if ($country = self::getFromService($request)) {
            return $country;
        }

        return null;
    }

    /**
     * Get the location from the configured header.
     *
     * @param Request $request
     * @return Location|null
     */
    private static function getFromHeader(Request $request): ?Location
    {
        if (($value = $request->header(config('geolocation.header')))
            && is_string($value)
            && strlen($value) === 2
        ) {
            $location = Location::fromCountryCode($value);
            if ($location->isComplete()) {
                return $location;
            }
        }

        return null;
    }

    /**
     * Get the location from the configured IP service.
     *
     * @param Request $request
     * @return Location|null
     */
    private static function getFromService(Request $request): ?Location
    {
        if (! ($geocoder = config('geolocation.geocoder'))) {
            return null;
        }

        $ip = $request->getClientIp();

        $cacheKey = "CountryCodeFromService::v1::$ip";
        $cached = Cache::get($cacheKey, 'NOT_FOUND');
        if ($cached !== 'NOT_FOUND') {
            return $cached;
        }

        try {
            $locator = GeoLocatorFactory::getHandler($geocoder);
            $geolocation = $locator->getLocation($ip);
            if ($ttl = config('geolocation.cache_ttl')) {
                Cache::put($cacheKey, $geolocation, $ttl);
            }

            return $geolocation;
        } catch (Exception $e) {
            Log::error($e, [
                'IP' => $ip,
            ]);
        }

        return null;
    }
}
