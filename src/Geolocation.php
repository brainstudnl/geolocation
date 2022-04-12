<?php

namespace Brainstud\UnlimitedGeolocation;

use stdClass;

/**
 * Geolocation.
 *
 * The geolocation data.
 */
class Geolocation
{
    /**
     * @param string $countryCode The Country code in ISO 3166-1 alpha-2 format.
     */
    public function __construct(
        public string $countryCode
    ) {
    }

    /**
     * Convert IpRegistry data to Geolocation
     * @param stdClass $data
     * @return Geolocation
     */
    public static function fromIpRegistry(stdClass $data): Geolocation
    {
        $countryCode = $data->location?->country?->code;

        return new Geolocation($countryCode);
    }
}
