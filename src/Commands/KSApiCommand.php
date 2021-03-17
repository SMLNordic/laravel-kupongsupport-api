<?php

namespace SMLNordic\KSApi\Commands;

use Illuminate\Console\Command;

class KSApiCommand extends Command
{
    public $signature = 'kupongsupport-api';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
