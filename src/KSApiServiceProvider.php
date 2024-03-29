<?php

namespace SMLNordic\KSApi;

use SMLNordic\KSApi\Commands\KSApiCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class KSApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('kupongsupport-api')
            ->hasConfigFile()
            ->hasCommand(KSApiCommand::class);
    }
}
