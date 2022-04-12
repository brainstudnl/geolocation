# Unlimited Geolocation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/brainstud/unlimited-geolocation.svg?style=flat-square)](https://packagist.org/packages/brainstud/unlimited-geolocation)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/brainstud/unlimited-geolocation/run-tests?label=tests)](https://github.com/brainstud/unlimited-geolocation/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/brainstud/unlimited-geolocation/Check%20&%20fix%20styling?label=code%20style)](https://github.com/brainstud/unlimited-geolocation/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/brainstud/unlimited-geolocation.svg?style=flat-square)](https://packagist.org/packages/brainstud/unlimited-geolocation)

Get the geolocation of the request to base the locale or timestamp on. This package will try to get the location from the cloudflare (or other configuable) header, or use a paid geo-locator API.

```php
UnlimitedGeolocation::getGeolocation($request)?->countryCode
````

## Installation

You can install the package via composer:

```bash
composer require brainstud/unlimited-geolocation
```
You can publish the config file with:

```bash
php artisan vendor:publish --tag="unlimited-geolocation-config"
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
    'cache_ttl' => DateInterval::createFromDateString('2 months'), // Cache TTL for the geocoder services.
];
```

## Usage
Configure the package with the config file. After that the package can be used like this.

```php
UnlimitedGeolocation::getGeolocation($request)?->countryCode
````

## Supported services
- [Cloudflare IP geolocation](https://support.cloudflare.com/hc/en-us/articles/200168236-Configuring-Cloudflare-IP-Geolocation)
- [IP Registry](https://ipregistry.co/)

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
