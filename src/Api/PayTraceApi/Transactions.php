<?php

namespace TechGenies\MM\Api\PayTraceApi;


use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use TechGenies\MM\Exceptions\PayTraceException;

class Transactions extends Entity
{
    /**
     * @param $data
     * @return mixed
     * @throws PayTraceException
     */
    public function keyedSale($data): mixed
    {
        try {
            $response = Http::withToken($this->accessToken)->asForm()->post($this->apiURL . '/v1/transactions/sale/keyed', $data);
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
    public function saleByTransactionId($data): mixed
    {
        try {
            $response = Http::withToken($this->accessToken)->asForm()->post($this->apiURL . '/v1/transactions/sale/by_transaction', $data);
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
            $response = Http::withToken($this->accessToken)->asForm()->post($this->apiURL . '/v1/transactions/sale/by_customer', $data);
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new PayTraceException($e->response->body(), $e->getCode());
        }
    }
}
