<?php

namespace SMLNordic\KSApi;

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
}
