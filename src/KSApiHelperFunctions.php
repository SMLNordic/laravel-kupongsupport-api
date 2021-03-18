<?php

namespace SMLNordic\KSApi;

use Exception;
use GuzzleHttp\Psr7\Response;

class KSApiHelperFunctions
{

    /**
     *
     * @param type $number
     * @return type
     * @throws SocialMediaLabException
     */
    public function formatNumberTo46($number)
    {
        $number = trim($number);

        if (static::stringStartsWith($number, "0")) {
            return "46" . substr($number, 1);
        }
        if (static::stringStartsWith($number, "46")) {
            return $number;
        }
        if (static::stringStartsWith($number, "+46")) {
            return substr($number, 1);
        }

        throw new \Exception('Number format error');
    }

    /**
     *
     * @param type $haystack
     * @param type $needle
     * @return type
     */
    private static function stringStartsWith($haystack, $needle)
    {
        return !strncmp($haystack, $needle, strlen($needle));
    }

    /**
     * @param  Response  $response
     * @return mixed
     * @throws Exception
     */
    public static function handleApiResponse(Response $response) {
        if ($response->getStatusCode() == 200 && $response->getBody()) {
            return json_decode($response->getBody());
        } else {
            throw new Exception('Could not parse response', 901);
        }
    }
}
