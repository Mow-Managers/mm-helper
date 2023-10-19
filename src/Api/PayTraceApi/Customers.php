<?php

namespace TechGenies\MM\Api\PayTraceApi;

use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use TechGenies\MM\Exceptions\PayTraceException;

class Customers extends Entity
{
    /**
     * @param $data
     * @return mixed
     * @throws PayTraceException
     */
    public function export($data): mixed
    {
        try {
            $response = Http::withToken($this->accessToken)->asForm()->post($this->apiURL . '/v1/customer/export', $data);
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
    function create($data): mixed
    {
        try {
            $response = Http::withToken($this->accessToken)->asForm()->post($this->apiURL . '/v1/customer/create', $data);
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new PayTraceException($e->response->body(), $e->getCode());
        }
    }

    /**
     * @param array $data
     * @return array
     */
    function getPayload(array $data): array
    {
        $payload['customer_id'] = $data['customer_id'];

        if (isset($data['credit_card_number'])) {
            $payload['credit_card']['number'] = $data['credit_card_number'];
        }

        if (isset($data['credit_card_expiration_month'])) {
            $payload['credit_card']['expiration_month'] = $data['credit_card_expiration_month'];
        }

        if (isset($data['credit_card_expiration_year'])) {
            $payload['credit_card']['expiration_year'] = $data['credit_card_expiration_year'];
        }

        if (isset($data['billing_address_name'])) {
            $payload['billing_address']['name'] = $data['billing_address_name'];
        }

        if (isset($data['billing_address_street_address'])) {
            $payload['billing_address']['street_address'] = $data['billing_address_street_address'];
        }

        if (isset($data['billing_address_city'])) {
            $payload['billing_address']['city'] = $data['billing_address_city'];
        }

        if (isset($data['billing_address_state'])) {
            $payload['billing_address']['state'] = $data['billing_address_state'];
        }

        if (isset($data['billing_address_zip'])) {
            $payload['billing_address']['zip'] = $data['billing_address_zip'];
        }

        if (isset($data['check_account_number'])) {
            $payload['check']['account_number'] = $data['check_account_number'];
        }

        if (isset($data['check_routing_number'])) {
            $payload['check']['routing_number'] = $data['check_routing_number'];
        }

        return $payload;
    }

    /**
     * @param $data
     * @return mixed
     * @throws PayTraceException
     * @throws Exception
     */
    function update($data): mixed
    {
        try {
            if (!isset($data['customer_id'])) {
                throw new Exception('Customer ID no found');
            }
            $payload = $this->getPayload($data);
            $response = Http::withToken($this->accessToken)->asForm()->post($this->apiURL . '/v1/customer/update', $payload);
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            throw new PayTraceException($e->response->body(), $e->getCode());
        }
    }
}
