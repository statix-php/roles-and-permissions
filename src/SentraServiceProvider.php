<?php

namespace Statix\Sentra;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SentraServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.pcom/spatie/laravel-package-tools
         */
        $package
            ->name('sentra')
            ->hasConfigFile();
    }
}
