<?php

namespace SMLNordic\KSApi\Commands;

use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use Illuminate\Console\Command;

class KSApiCommand extends Command
{

    public $signature = 'ks-api-init';

    public $description = 'Install and publish config';

    private $envs = [
        'KS_API_TOKEN'    => '',
        'KS_API_BASE_URL' => '',
    ];

    public function handle()
    {

        if ($this->confirm('This will reset all your KSAPI env vars that has already been set. Continue?')) {
            self::updateEnvFile($this->envs);
            $this->comment('All done');
        } else {
            $this->comment('Aborting...');
        }

    }

    public function updateEnvFile(array $data)
    {

        // Load the .env file into a repository
        $repository = RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(EnvConstAdapter::class)
            ->addWriter(PutenvAdapter::class)
            ->immutable()
            ->make();

        // Loop through the data and update the values
        foreach ($data as $key => $value) {
            $repository->set($key, $value);
        }

        // Save the changes back to the .env file
        $factory = new DotenvFactory($repository, true);
        $dotenv = Dotenv::create($repository, $factory);
        $dotenv->safeLoad();
        $dotenv->toEnv();

        return true;

    }
}
