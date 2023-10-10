<?php

namespace SMLNordic\KSApi;

use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;

class KSApiHelperFunctions
{
    /**
     * @return mixed
     *
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

    /**
     * @return array
     *
     * @throws Exception
     */
    public static function validateCouponParams(array $params)
    {

        if (! $params['template']) {
            if ($params['type'] == 'mobile') {
                $params['template'] = config('kupongsupport-api.templates.mobile');
            } elseif ($params['type'] == 'print') {
                $params['template'] = config('kupongsupport-api.templates.print');
            }
        }

        if (! $params['delivery_type']) {

            if (isset($params['phone_number']) && ! empty($params['phone_number'])) {
                $params['delivery_type'] == 'sms';
            } elseif (isset($params['email']) && ! empty($params['email'])) {
                $params['delivery_type'] = 'email';
            } else {
                $params['delivery_type'] = 'api';
            }
        }

        $validator = Validator::make($params, [
            'template' => 'required|numeric',
            'type' => 'required|in:print,mobile',
            'email' => 'nullable|required_without:phone_number|email',
            'phone_number' => 'nullable|required_without:email|string|min:10|max:12',
            'delivery_type' => 'required|in:sms,email,api',
            'valid_days' => 'numeric|min:1',
            'amount' => 'numeric',
        ]);

        if ($validator->fails()) {
            throw new Exception('Parameter validation failed: '.$validator->errors()->first());
        } else {
            return $validator->validated();
        }

    }

    /**
     * @param  string  $number Phone number to format
     * @return string Formatted phone number
     *
     * @throws Exception
     */
    public function formatNumberTo46($number)
    {
        $number = trim($number);

        if (static::stringStartsWith($number, '0')) {
            return '46'.substr($number, 1);
        }
        if (static::stringStartsWith($number, '46')) {
            return $number;
        }
        if (static::stringStartsWith($number, '+46')) {
            return substr($number, 1);
        }

        throw new \Exception('Number format error');
    }

    /**
     * @param  type  $haystack
     * @param  type  $needle
     * @return type
     */
    private static function stringStartsWith($haystack, $needle)
    {
        return ! strncmp($haystack, $needle, strlen($needle));
    }
}
