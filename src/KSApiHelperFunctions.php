<?php

namespace SMLNordic\KSApi;

use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;

class KSApiHelperFunctions
{

    /**
     *
     * @param  type  $number
     * @return type
     * @throws SocialMediaLabException
     */
    public function formatNumberTo46($number)
    {
        $number = trim($number);

        if (static::stringStartsWith($number, "0")) {
            return "46".substr($number, 1);
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
     * @param  type  $haystack
     * @param  type  $needle
     * @return type
     */
    private static function stringStartsWith($haystack, $needle)
    {
        return ! strncmp($haystack, $needle, strlen($needle));
    }

    /**
     * @param  Response  $response
     * @return mixed
     * @throws Exception
     */
    public static function handleApiResponse(Response $response)
    {
        if ($response->getStatusCode() == 200 && $response->getBody()) {
            return json_decode($response->getBody());
        } else {
            throw new Exception('Could not parse response', 901);
        }
    }


    public static function validateCouponParams(array $params)
    {

        $validator = Validator::make($params, [
            'type' => 'required|in:print,mobile',
            'email' => 'required_without:phone_number|email',
            'phone_number' => 'required_without:email|string|min:10|max:12'
        ]);

        if ($validator->fails()) {
            dd($validator);
        }
        dd('Validation OK!', $validator);

        // Type is required
        if ( ! $params['type']) {

        }

        if ( ! $params['email'] || ! $params['phone_number']) {
            throw new Exception('Parameter "email" or "phone_number" is required');
        } elseif ( ! $params['email']) {
            // validate email

        }

        if ( ! $params['delivery_type']) {

        }
    }
}
