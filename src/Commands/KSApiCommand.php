<?php

namespace SMLNordic\KSApi\Commands;

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

        // Read the contents of the .env file
        $envFile = base_path('.env');
        $contents = File::get($envFile);

        // Split the contents into an array of lines
        $lines = explode("\n", $contents);

        // Loop through the lines and update the values
        foreach ($lines as &$line) {
            // Skip empty lines
            if (empty($line)) {
                continue;
            }

            // Split each line into key and value
            $parts = explode("=", $line, 2);
            $key = $parts[0];

            // Check if the key exists in the provided data
            if (isset($this->envs[$key])) {
                // Update the value
                $line = $key."=".$this->envs[$key];
                unset($this->envs[$key]);
            }
        }

        // Append any new keys that were not present in the original file
        foreach ($this->envs as $key => $value) {

            $lines[] = $key."=".$value;
        }
        // Combine the lines back into a string
        $updatedContents = implode("\n", $lines);

        // Write the updated contents back to the .env file
        File::put($envFile, $updatedContents);
    }


}
