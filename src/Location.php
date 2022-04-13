<?php

namespace Brainstud\Geolocation;

use DateTimeZone;
use stdClass;

/**
 * Location.
 *
 * The geolocation data.
 */
class Location
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
     * @return Location
     */
    public static function fromCountryCode(string $countryCode): Location
    {
        $timeZone = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $countryCode);
        if (count($timeZone) > 1) {
            return new Location($countryCode);
        }

        return new Location($countryCode, current($timeZone));
    }

    /**
     * Convert IpRegistry data to Location
     * @param stdClass $data
     * @return Location
     */
    public static function fromIpRegistry(stdClass $data): Location
    {
        $countryCode = $data->location?->country?->code;
        $timeZone = property_exists($data, 'time_zone') ? $data->time_zone?->id : null;

        return new Location($countryCode, $timeZone);
    }

    /**
     * Convert IpRegistry data to Location
     * @param stdClass $data
     * @return Location
     */
    public static function fromIpStack(stdClass $data): Location
    {
        $countryCode = $data->country_code;
        $timeZone = property_exists($data, 'time_zone') ? $data->time_zone?->id : null;

        return new Location($countryCode, $timeZone);
    }

    public function isComplete(): bool
    {
        return $this->countryCode && $this->timeZone;
    }
}
