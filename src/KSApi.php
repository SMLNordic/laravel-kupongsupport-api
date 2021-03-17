<?php

namespace SMLNordic\KSApi;

class KSApi
{

    private $token;

    public function __construct()
    {
        $this->token = config('kupongsupport-api.token', false);

        if(!$this->token) {
            throw new \Exception('Missing bearer token');
        }
    }
}
