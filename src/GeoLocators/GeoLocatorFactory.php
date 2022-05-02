<?php

namespace Brainstud\Geolocation\GeoLocators;

use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Factory to build a geo-locator instance.
 */
class GeoLocatorFactory
{
    /**
     * Get the geo-locator service
     * @throws Exception
     */
    public static function getHandler(GeoLocator $geoLocator): GeoLocatorContract
    {
        $service = match ($geoLocator) {
            GeoLocator::IpRegistry => IpRegistry::class,
            GeoLocator::IpStack => IpStack::class,
        };

        try {
            $instance = new $service();
            if (! $instance instanceof GeoLocatorContract) {
                Log::error("Locator doesn't implement GeoLocatorContract");

                throw new Exception("Locator $service doesn't implement GeoLocatorContract");
            }
        } catch (Exception $e) {
            logger()->error("Cannot instantiate handler for class $service", ['locator' => $geoLocator, 'exception' => $e]);

            throw new Exception("Cannot instantiate handler for class $service");
        }

        return $instance;
    }
}
