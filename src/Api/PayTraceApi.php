<?php

namespace TechGenies\MM\Api;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use TechGenies\MM\Api\PayTraceApi\ACH;
use TechGenies\MM\Api\PayTraceApi\Customers;
use TechGenies\MM\Exceptions\PayTraceException;

class PayTraceApi
{
    private string $accessToken;
    private string $apiURL;

    public Customers $customers;
    public ACH $ach;

    /**
     * PayTraceWS constructor.
     * @throws PayTraceException
     */
    public function __construct()
    {
        try {
            $this->apiURL = config('mm.payTrace.apiURL');
            $username =  config('mm.payTrace.username');
            $password =  config('mm.payTrace.password');

            $data = [
                'username' => $username,
                'password' => $password,
                'grant_type' => 'password'
            ];

            $response = Http::post($this->apiURL . '/oauth/token', $data);
            $response->throw();

            // AccessToken
            $this->accessToken = $response->json('access_token');

            // Entities
            $this->customers = new Customers($this->apiURL, $this->accessToken);
            $this->ach = new ACH($this->apiURL, $this->accessToken);
        } catch (RequestException $e) {
            throw new PayTraceException($e->response->body(), $e->getCode());
        }
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return array
     */
    public function getCredentials(): array
    {
        $username =  config('mm.payTrace.username');
        $password =  config('mm.payTrace.password');
        $apiURL =  config('mm.payTrace.apiURL');

        return [
            'username' => $username,
            'password' => $password,
            'grantType' => 'password',
            'apiURL' => $apiURL
        ];
    }
}
