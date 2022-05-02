<?php

namespace Brainstud\Geolocation\GeoLocators;

use Brainstud\Geolocation\Location;
use Exception;

/**
 * A geo-locator to get the country code from an IP address.
 */
interface GeoLocatorContract
{
    /**
     * Get the country code in ISO 3166-1 alpha-2 format.
     * @param string $ip
     * @return Location|null
     * @throws Exception
     */
    public function getLocation(string $ip): ?Location;
}
