# Laravel Geolocation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/brainstud/geolocation.svg?style=flat-square)](https://packagist.org/packages/brainstud/geolocation)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/brainstud/geolocation/run-tests?label=tests)](https://github.com/brainstud/geolocation/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/brainstud/geolocation/Check%20&%20fix%20styling?label=code%20style)](https://github.com/brainstud/geolocation/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/brainstud/geolocation.svg?style=flat-square)](https://packagist.org/packages/brainstud/geolocation)

Get the country & timezone of the request with the cloudflare country header or fallback to a paid geo-locator API.

```php
$location = Geolocation::getLocation($request);
// { countryCode: "NL", timeZone: "Europe/Amsterdam" }
````

The aim of this package prioritize the cloudflare header to keep costs down. Only if that fails an API-call will be done.
By this philosophy only minimal info will be available. (country code and timezone)

## Installation

You can install the package via composer:

```bash
composer require brainstud/geolocation
```
You can publish the config file with:

```bash
php artisan vendor:publish --tag="geolocation-config"
```

This is the contents of the published config file:

```php
return [
    'header' => 'CF-IPCountry', // The cloudflare header that contains the country code
    'geocoder' => GeoLocator::IpRegistry, // The geocoder to use if the header is empty
    'ip-registry' => [ // Credentials for the ip registry API
        'base_url' => env('IP_REGISTRY_URL', 'https://api.ipregistry.co'),
        'key' => env('IP_REGISTRY_KEY'),
    ],
    'ip-stack' => [ // Credentials for the ip stack API
        'base_url' => env('IP_STACK_URL', 'https://api.ipstack.com'),
        'key' => env('IP_STACK_KEY'),
    ],
    'cache_ttl' => DateInterval::createFromDateString('2 months'), // Cache TTL for the geocoder services.
];
```

## Supported services
- [Cloudflare IP geolocation](https://support.cloudflare.com/hc/en-us/articles/200168236-Configuring-Cloudflare-IP-Geolocation)
- [ipregistry](https://ipregistry.co/)
- [ipstack](https://ipstack.com)

## Contributing
You can add a geocoder by creating a class in the `src/GeoLocators` folder that implements `GeoLocatorContract`.
Then add it to the `GeoLocator` enum and `GeoLocatorFactory`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Niek Pijp](https://github.com/niekp)
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
