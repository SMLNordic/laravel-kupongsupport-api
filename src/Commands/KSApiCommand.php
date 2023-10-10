<?php

namespace SMLNordic\KSApi\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class KSApiCommand extends Command
{
    public $signature = 'ks-api-init';

    public $description = 'Install and publish config';

    private $envs = [
        'KS_API_TOKEN' => '',
        'KS_API_BASE_URL' => '',
    ];

    public function handle()
    {

        if ($this->confirm('This will reset all your KSAPI env vars that has already been set. Continue?')) {
            foreach($this->envs as $key => $value) {
                $process = Process::fromShellCommandline('php artisan env:set '.$key.' "'.$value.'"');
                $process->run();
                // executes after the command finishes
                if ( ! $process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }

                echo $process->getOutput();
            }
            $this->comment('All done');
        } else {
            $this->comment('Aborting...');
        }

    }
}
