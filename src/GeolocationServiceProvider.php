<?php

namespace Brainstud\Geolocation;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GeolocationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('geolocation')
            ->hasConfigFile();

        $this->app->bind('geolocation', fn () => new Geolocation());
    }
}
