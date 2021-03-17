<?php

namespace SMLNordic\KSApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SMLNordic\KSApi\KSApi
 */
class KSApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'kupongsupport-api';
    }
}
