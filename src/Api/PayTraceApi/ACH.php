<?php

namespace TechGenies\MM\Api\PayTraceApi;


use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use TechGenies\MM\Exceptions\PayTraceException;

class ACH extends Entity
{
    /**
     * @param $data
     * @return mixed
     * @throws PayTraceException
     */
    public function saleByAccount($data): mixed
    {
        try {
            $response = Http::withToken($this->accessToken)->asForm()->post($this->apiURL . '/v1/checks/sale/by_account', $data);
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new PayTraceException($e->response->body(), $e->getCode());
        }
    }

    /**
     * @param $data
     * @return mixed
     * @throws PayTraceException
     */
    public function vaultSale($data): mixed
    {
        try {
            $response = Http::withToken($this->accessToken)->asForm()->post($this->apiURL . '/v1/checks/sale/by_customer', $data);
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new PayTraceException($e->response->body(), $e->getCode());
        }
    }
}
