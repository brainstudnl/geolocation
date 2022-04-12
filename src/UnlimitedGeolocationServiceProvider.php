<?php

namespace Brainstud\UnlimitedGeolocation;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class UnlimitedGeolocationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('unlimited-geolocation')
            ->hasConfigFile();
    }
}
