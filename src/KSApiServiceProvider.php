<?php

namespace SMLNordic\KSApi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SMLNordic\KSApi\Commands\KSApiCommand;

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
            ->hasViews()
            ->hasMigration('create_kupongsupport_api_table')
            ->hasCommand(KSApiCommand::class);
    }
}
