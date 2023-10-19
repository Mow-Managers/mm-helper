<?php

namespace TechGenies\MM\Api\PayTraceApi;

class Entity
{
    protected string $accessToken;
    protected string $apiURL;

    /**
     * Customers constructor.
     * @param $apiURL
     * @param $accessToken
     */
    public function __construct($apiURL, $accessToken)
    {
        $this->apiURL = $apiURL;
        $this->accessToken = $accessToken;
    }
}
