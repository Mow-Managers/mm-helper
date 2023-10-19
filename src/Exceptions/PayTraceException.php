<?php

namespace TechGenies\MM\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class PayTraceException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function getError(): JsonResponse
    {
        return response()->json(json_decode($this->message, true), $this->code);
    }
}
