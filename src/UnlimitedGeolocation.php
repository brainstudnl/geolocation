<?php

namespace Brainstud\UnlimitedGeolocation;

use Brainstud\UnlimitedGeolocation\GeoLocators\GeoLocatorFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UnlimitedGeolocation
{
    /**
     * Get the geolocation of a request.
     *
     * @param Request $request
     * @return Geolocation|null
     */
    public static function getGeolocation(Request $request): ?Geolocation
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
     * @return Geolocation|null
     */
    private static function getFromHeader(Request $request): ?Geolocation
    {
        if (($value = $request->header(config('unlimited-geolocation.header')))
            && is_string($value)
            && strlen($value) === 2
        ) {
            return new Geolocation($value);
        }

        return null;
    }

    /**
     * Get the location from the configured IP service.
     *
     * @param Request $request
     * @return Geolocation|null
     */
    private static function getFromService(Request $request): ?Geolocation
    {
        if (! ($geocoder = config('unlimited-geolocation.geocoder'))) {
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
            $geolocation = $locator->getGeolocation($ip);
            if ($ttl = config('unlimited-geolocation.cache_ttl')) {
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
