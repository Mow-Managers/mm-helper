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
     * Maps the given data to meet the needs of the receiving API.
     *
     * @param array $data
     * @return array
     */
    function getPayload(array $data): array
    {
        $payload['customer_id'] = $data['customer_id'];

        if (isset($data['credit_card']['number'])) {
            $payload['credit_card']['number'] = $data['credit_card']['number'];
        }

        if (isset($data['credit_card']['expiration_date'])) {
            $payload['credit_card']['expiration_month'] = $data['credit_card']['expiration_month'];
        }

        if (isset($data['credit_card']['expiration_year'])) {
            $payload['credit_card']['expiration_year'] = $data['credit_card']['expiration_year'];
        }

        // Billing Address
        if (isset($data['billing_address']['name'])) {
            $payload['billing_address']['name'] = $data['billing_address']['name'];
        }

        if (isset($data['billing_address']['street_address'])) {
            $payload['billing_address']['street_address'] = $data['billing_address']['street_address'];
        }

        if (isset($data['billing_address']['city'])) {
            $payload['billing_address']['city'] = $data['billing_address']['city'];
        }

        if (isset($data['billing_address']['state'])) {
            $payload['billing_address']['state'] = $data['billing_address']['state'];
        }

        if (isset($data['billing_address']['zip'])) {
            $payload['billing_address']['zip'] = $data['billing_address']['zip'];
        }

        if (isset($data['billing_address']['county'])) {
            $payload['billing_address']['county'] = $data['billing_address']['county'];
        }

        // Set default country for billing address
        $payload['billing_address']['country'] = $data['billing_address']['country'] ?? 'US';

        // Shipping Address
        if (isset($data['shipping_address']['name'])) {
            $payload['shipping_address']['name'] = $data['shipping_address']['name'];
        }

        if (isset($data['shipping_address']['street_address'])) {
            $payload['shipping_address']['street_address'] = $data['shipping_address']['street_address'];
        }

        if (isset($data['shipping_address']['city'])) {
            $payload['shipping_address']['city'] = $data['shipping_address']['city'];
        }

        if (isset($data['shipping_address']['state'])) {
            $payload['shipping_address']['state'] = $data['shipping_address']['state'];
        }

        if (isset($data['shipping_address']['zip'])) {
            $payload['shipping_address']['zip'] = $data['shipping_address']['zip'];
        }

        if (isset($data['shipping_address']['county'])) {
            $payload['shipping_address']['county'] = $data['shipping_address']['county'];
        }

        // Set default country for shipping address
        $payload['shipping_address']['country'] = $data['shipping_address']['country'] ?? 'US';

        if (isset($data['check']['account_number'])) {
            $payload['check']['account_number'] = $data['check']['account_number'];
        }

        if (isset($data['check']['routing_number'])) {
            $payload['check']['routing_number'] = $data['check']['routing_number'];
        }

        if (isset($data['integrator_id'])) {
            $payload['integrator_id'] = $data['integrator_id'];
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
