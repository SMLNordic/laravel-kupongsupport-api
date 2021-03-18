<?php

namespace SMLNordic\KSApi;

use Exception;
use GuzzleHttp\Client;

class KSApi
{

    private $token;
    private $client;

    public function __construct()
    {
        $this->token = config('kupongsupport-api.token', false);

        if ( ! $this->token) {
            throw new \Exception('Missing bearer token');
        }

        $this->setupClient();
    }

    /**
     * Base setup for all requests
     */
    private function setupClient()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => config('kupongsupport-api.base_url'),
            'headers'  => [
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer '.$this->token
            ]

        ]);
    }

    /**
     * @param  array  $options
     * @return mixed
     * @throws Exception
     */
    public function createCoupon(array $options)
    {
        $defaultOptions = [
            'template'         => null,
            'type'             => null,
            'delivery_type'    => null,
            'amount'           => 0,
            'valid_days'       => 90,
            'ticket_reference' => null,
            'phone_number'     => null,
            'email'            => null,
            'first_name'       => null,
            'last_name'        => null,
            'custom_message'   => null,
            'custom_sms'       => null,
            'custom_text'      => null,
        ];

        $params = array_merge($defaultOptions, $options);

        try {
            $response = $this->client->post('/api/coupons/', [
                'json' => $params
            ]);

            return KSApiHelperFunctions::handleApiResponse($response);


        } catch (RequestException $e) {
            throw new Exception('API request failed', 902);
        }


    }

    /**
     * @param  int  $id  Coupon ID to fetch
     * @throws Exception
     */
    public function getCouponStatus(int $id)
    {
        try {
            $response = $this->client->get('/api/coupons/'.$id);

            return KSApiHelperFunctions::handleApiResponse($response);

        } catch (RequestException $e) {
            throw new Exception('API request failed', 903);
        }
    }


    public function resendCoupon(int $id)
    {
        try {
            $response = $this->client->post('/api/coupons/resend', [
                'json' => [
                    'id' => $id
                ]
            ]);

            return KSApiHelperFunctions::handleApiResponse($response);


        } catch (RequestException $e) {
            throw new Exception('API request failed', 905);
        }
    }
}
