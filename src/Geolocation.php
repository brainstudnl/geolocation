<?php

namespace Brainstud\UnlimitedGeolocation;

use DateTimeZone;
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
     * @param ?string $timeZone The timezone
     */
    public function __construct(
        public string $countryCode,
        public ?string $timeZone = null
    ) {
    }

    /**
     * Get the geolocation data from a country code.
     * @param string $countryCode
     * @return Geolocation
     */
    public static function fromCountryCode(string $countryCode): Geolocation
    {
        $timeZone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $countryCode);
        if (count($timeZone) > 1) {
            return new Geolocation($countryCode);
        }

        return new Geolocation($countryCode, current($timeZone));
    }

    /**
     * Convert IpRegistry data to Geolocation
     * @param stdClass $data
     * @return Geolocation
     */
    public static function fromIpRegistry(stdClass $data): Geolocation
    {
        $countryCode = $data->location?->country?->code;
        $timeZone = $data->time_zone?->id;

        return new Geolocation($countryCode, $timeZone);
    }

    public function isComplete(): bool
    {
        return $this->countryCode && $this->timeZone;
    }
}
