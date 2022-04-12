<?php

namespace Brainstud\UnlimitedGeolocation\GeoLocators;

use Brainstud\UnlimitedGeolocation\Geolocation;
use Exception;

/**
 * A geo-locator to get the country code from an IP address.
 */
interface GeoLocatorContract
{
    /**
     * Get the country code in ISO 3166-1 alpha-2 format.
     * @param string $ip
     * @return Geolocation|null
     * @throws Exception
     */
    public function getGeolocation(string $ip): ?Geolocation;
}
