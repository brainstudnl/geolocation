<?php

use Brainstud\Geolocation\GeoLocators\GeoLocator;

return [
    'header' => 'CF-IPCountry',
    'geocoder' => GeoLocator::IpRegistry,
    'ip-registry' => [
        'base_url' => env('IP_REGISTRY_URL', 'https://api.ipregistry.co'),
        'key' => env('IP_REGISTRY_KEY'),
    ],
    'ip-stack' => [
        'base_url' => env('IP_STACK_URL', 'https://api.ipstack.com'),
        'key' => env('IP_STACK_KEY'),
    ],
    'cache_ttl' => DateInterval::createFromDateString('2 months'),
];
