<?php

namespace SMLNordic\KSApi;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class KSApi
{
    private $token;

    private $client;

    private $helper;

    public function __construct()
    {
        $this->token = config('kupongsupport-api.token', false);

        if (! $this->token) {
            throw new \Exception('Missing bearer token');
        }

        $this->setupClient();
        $this->helper = new KSApiHelperFunctions();
    }

    /**
     * Base setup for all requests
     */
    private function setupClient()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => config('kupongsupport-api.base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token,
            ],

        ]);
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function createCoupon(array $options)
    {
        $defaultOptions = [
            'template' => null,
            'type' => null,
            'delivery_type' => null,
            'amount' => 0,
            'valid_days' => 90,
        ];

        $params = array_merge($defaultOptions, $options);

        // Check/Validate/Fill params with missing values
        $params = $this->helper->validateCouponParams($params);

        try {
            $response = $this->client->post('/api/coupons/', [
                'json' => $params,
            ]);

            return $this->helper->handleApiResponse($response);

        } catch (RequestException $e) {
            throw new Exception('API request failed', 902);
        }

    }

    /**
     * @param  int  $id  Coupon ID to fetch
     *
     * @throws Exception
     */
    public function getCouponStatus(int $id)
    {
        try {
            $response = $this->client->get('/api/coupons/'.$id);

            return $this->helper->handleApiResponse($response);

        } catch (RequestException $e) {
            throw new Exception('API request failed', 903);
        }
    }

    public function resendCoupon(int $id)
    {
        try {
            $response = $this->client->post('/api/coupons/resend', [
                'json' => [
                    'id' => $id,
                ],
            ]);

            return $this->helper->handleApiResponse($response);

        } catch (RequestException $e) {
            throw new Exception('API request failed', 905);
        }
    }

    /**
     * @param  int  $templateId KSID of template to check
     * @return string|false
     */
    public function checkTemplate(int $templateId)
    {
        if (! $templateId) {
            return false;
        }

        $response = $this->client->get('/api/templates/'.$templateId);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            return false;
        }
    }
}
